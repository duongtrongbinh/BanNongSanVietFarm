<?php
namespace App\Http\Services;

use App\Enums\NotificationSystem;
use App\Enums\TransferStatus;
use App\Enums\TypeUnitEnum;
use App\Http\Requests\OrderRequest;
use App\Jobs\SendOrderConfirmation;
use App\Jobs\SendOrderToGHN;
use App\Jobs\UpdateOrderStatusJob;
use App\Models\Order;
use App\Models\OrderHistory;
use App\Models\Product;
use App\Models\TransferHistory;
use Barryvdh\Debugbar\Twig\Extension\Debug;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Enums\Roles;
use App\Notifications\SystemNotification;
use \Illuminate\Support\Facades\Notification;
use \App\Events\SystemNotificationEvent;

class GHNService
{
    protected $apiUrl;
    protected $shopId;

    protected $token;
    protected $urlShipping = 'https://online-gateway.ghn.vn/shiip/public-api/v2/shipping-order/fee/2232';
    protected $ghnTranform;

    public function __construct(GHNTranform $ghnTranform)
    {
        $this->apiUrl = env('GHN_API_URL');
        $this->shopId = env('GHN_SHOP_ID');
        $this->token = env('GHN_API_TOKEN');
        $this->ghnTranform = $ghnTranform;
    }
    public function store(OrderRequest $request)
    {
        if(!session('cart')){
            return redirect()->route('home');
        }
        $value = $this->fillterData($request->all());
        DB::beginTransaction();
        try {
            $order = $this->saveData($value, session('cart'));
            $ghnData = $this->createOrderGHN($value,session('cart'), $order->order_code);
            $this->ghnTranform->saveOrderDataToStorage($ghnData, $order->order_code);

            if ($request['payment_method'] == 'VNPAYQR') {
                $url = $this->paymentVNPAY($value['after_total_amount'], $order->order_code);
                $routeUrl = redirect()->away($url);
            } else {
                $routeUrl = redirect()->route('checkout.success',$order->order_code);
            }
            dispatch(new SendOrderConfirmation($order,session('cart'),session('service_fee')));

            Notification::send(Roles::admins(),new SystemNotification($order));

            broadcast(new SystemNotificationEvent(NotificationSystem::adminNotificationNew()));

            DB::commit();
            session()->forget('cart');
            session()->forget('service_fee');
            return $routeUrl;
        } catch (\Exception $e) {
            Log::debug($e);
            DB::rollBack();
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi tạo đơn hàng.');
        }
    }


    private function fillterData(array $data){
        $totalAmount = 0;

        $provinceParts = explode(' - ', $data['province']);
        $provinceName = isset($provinceParts[1]) ? $provinceParts[1] : '';

        $districtParts = explode(' - ', $data['district']);
        $districtName = isset($districtParts[1]) ? $districtParts[1] : '';

        $wardParts = explode(' - ', $data['ward']);
        $wardName = isset($wardParts[1]) ? $wardParts[1] : '';

        $data['province_name'] = $provinceName;
        $data['district_name'] = $districtName;
        $data['ward_name'] = $wardName;
        unset($data['province']);
        unset($data['district']);
        unset($data['ward']);
        $data['province'] = $provinceParts[0];
        $data['district'] = $districtParts[0];
        $data['ward'] = $wardParts[0];
        foreach (array_values(session('cart')) as $product) {
            $totalAmount += $product['quantity'] * intval($product['price_sale']);
        }
        $data['shipping'] = session('service_fee') ? session('service_fee') : 0;
        $data['before_total_amount'] = $totalAmount;
        $data['after_total_amount'] = $totalAmount + $data['shipping'];
        $data['address_detail'] = $data['specific_address'] . ', ' . $data['ward_name'] . ', ' . $data['district_name'] . ', ' .  $data['province_name'] . ", Vietnam";
        return $data;
    }
    public function createOrderGHN($data, $items, $ordercode)
    {
        $product = $this->formatDataGHN($items);

        $jsonData = [
            "note" => $data['note'] ?? 'No',
            "required_note" => "KHONGCHOXEMHANG",
            "client_order_code" => $ordercode,
            "to_name" => $data['name'],
            "to_phone" => $data['phone'],
            "to_address" => $data['address_detail'],
            "to_ward_name" => $data['ward_name'],
            "to_district_name" => $data['district_name'],
            "to_province_name" => $data['province_name'],
            "content" => "",
            "weight" => 15,
            "length" => 15,
            "width" => 15,
            "height" => 15,
            "cod_failed_amount" => 0,
            "pick_station_id" => null,
            "deliver_station_id" => null,
            "insurance_value" => 100000,
            "service_id" => 0,
            "service_type_id" => 2,
            "coupon" => null,
            "pickup_time" => Carbon::now()->timestamp,
            "pick_shift" => [2],
            "items" => $product,
        ];

        if ($data['payment_method'] == 'VNPAYQR') {
            $jsonData["payment_type_id"] = 1;
            $jsonData["cod_amount"] = 0;
        } else {
            $jsonData["payment_type_id"] = 2;
            $jsonData["cod_amount"] = intval($data['after_total_amount'] + $data['shipping'] );
        }

        return $jsonData;
    }

    public function formatDataGHN($data)
    {
        $items = [];

        foreach ($data as $key => $product) {
            $item = [
                "name" => $product['name'],
                "quantity" => (int) $product['quantity'],
                "price" => intval($product['price']),
                "code" => $key.'ABC',
                "length" => $product['length'],
                "width" => $product['width'],
                "height" => $product['height'],
                "category" => [
                    "level1" => "Rau"
                ],
            ];

            $items[] = $item;
        }

        return $items;
    }
    public function paymentVNPAY($after_total_amount, $order_code)
    {
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('bill.return');
        $vnp_TmnCode = "2OYKK3KL";
        $vnp_HashSecret = "TI27HBAXXZ868VL3QVAKOKU3ED6AK5EE";

        $vnp_TxnRef = $order_code;
        $vnp_OrderInfo = 'Thanh toán hóa đơn';
        $vnp_OrderType = 'Nong San Viet Fam';
        $vnp_Amount = $after_total_amount * 100;
        $vnp_Locale = 'VN';
        $vnp_BankCode = '';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);//
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        return $vnp_Url;
    }

    public function saveData($data, $dataProducts){
        return DB::transaction(function () use ($data, $dataProducts) {
            $data['payment_method'] = $data['payment_method'] ? 1 : 2;
            if(Auth::user()->id){
                $data['user_id'] = Auth::user()->id;
            }else{
                $data['user_id'] = 1;
            }
            $data['address'] = $data['address_detail'];
            $order = Order::create($data);
            $products = [];
            foreach ($dataProducts as $id => $item) {
                $products[$id] = [
                    'name' => $item['name'],
                    'image' => $item['image'],
                    'price_regular' => $item['price_regular'],
                    'price_sale' => $item['price_sale'],
                    'quantity' => $item['quantity'],
                ];
            }
            $this->updateQuantityProduct($products);
            $order->products()->attach($products);
            OrderHistory::create([
                'order_id' => $order->id,
                'status' => OrderStatus::PENDING
            ]);
            return $order;
        });
    }

    public function UpdateStatusOrder($status,$code){
            $order = Order::query()->where('order_code',$code)->first();
            $order->update([
                    'payment_status' => $status,
            ]);
            return $order;
    }

    private function updateQuantityProduct($products){
         foreach ($products as $id => $item) {
            $product = Product::find($id);
            if ($product) {
                $product->quantity -= $item['quantity'];
                $product->save();
            }
        }
    }


    public function retryOrder(Order $order)
    {
        try {
            if ($order->status !== OrderStatus::RETRY) {
                return redirect()->back()->with('error', 'Không thể thực hiện lại đơn hàng này.');
            }

            $order->status = OrderStatus::PENDING;
            $order->save();

            SendOrderToGHN::dispatch($order, $order->toArray(), $order->items()->toArray());

            return redirect()->back()->with('success', 'Đã gửi lại yêu cầu tạo đơn hàng.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi thực hiện lại đơn hàng.');
        }
    }

   public function pay_return(Request $request){
        $dd = $request->input('vnp_ResponseCode');
        $code = $request->input('vnp_TxnRef');
        if($dd == "00" ){
            $this->UpdateStatusOrder(PaymentStatus::SUCCESS_PAYMENT,$code);
            return redirect()->route('checkout.success',$code);
        }else{
            return redirect()->route('checkout.success',$code);
        }
    }

    public function shippingFee(Request $request)
    {
        $value = $this->fillterDataShipping($request->all());
        $product = $this->formatDataGHN(session('cart'));
        $jsonData = [
            "service_type_id" => $value["service_type_id"],
            "to_district_id" => (int)$value["to_district_id"],
            "to_ward_code" => $value['to_ward_code'],
            "height" => $value['height'],
            "length" => $value['length'],
            "weight" => $value['weight'],
            "insurance_value" => $value['insurance_value'],
            "items" => $product,
        ];

        $headers = [
            'Content-Type' => 'application/json',
            'ShopId'=> $this->shopId,
            'token'=> $this->token,
        ];

        if ($value['to_ward_code']){

            $response = Http::withHeaders($headers)->post($this->urlShipping, $jsonData);
            if ($response->successful()) {
                $responseData = $response->json();
                $total = $responseData['data']['total'];
                session(['service_fee' => $total]);
                return response()->json($responseData,200) ;
            }
            if ($response->failed()){
                session(['service_fee' => TypeUnitEnum::SHIPPING_DEFAULT->value]);
                $array = [
                    'message' => 'shipping_default',
                    'total' => intval(TypeUnitEnum::SHIPPING_DEFAULT->value)
                ];
                return response()->json($array,200) ;
            }
        }else{
            $array = [
                'message' => 'missing',
            ];
            session(['service_fee' => 0]);
            return response()->json($array,200) ;
        }
    }

    public function fillterDataShipping(array $data)
    {
        $data["service_type_id"] = 2;
        $data["to_district_id"] = $data['district_id'];
        $data['to_ward_code'] = $data['ward_code'];
        $data['height'] = 20;
        $data['length'] = 30;
        $data['weight'] = 3000;
        $data['width'] = 40;
        $data['insurance_value'] = 0;
        return $data;
    }

 public function delivery(Request $request)
    {
        $Status = '';
        $order = Order::query()->where('order_code',$request->OrderCode)->first();
        if($order){
            foreach(TransferStatus::values() as $key => $value){
                if (strtoupper($request->Status) == $value){
                    $Status = $key;
                }
            }
            if ($Status != ''){
                TransferHistory::create([
                    'order_id' => $order->id,
                    'status' => $Status,
                    'warehouse' => $request->Warehouse,
                ]);
                 UpdateOrderStatusJob::dispatch($order->order_id, $order->status);
                return response()->json('success',200);
            }else{
                return response()->json([$Status, 'Không tìm thấy trạng thái đơn hàng.'],400);
            }
        }else{
                return response()->json([$order, 'Không tìm thấy đơn hàng.'],400);
        }
    }

}

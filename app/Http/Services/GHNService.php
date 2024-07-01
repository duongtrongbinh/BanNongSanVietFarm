<?php
namespace App\Http\Services;

use App\Enum\OrderStatus;
use App\Jobs\SendOrderConfirmation;
use App\Jobs\SendOrderToGHN;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GHNService
{
    protected $apiUrl;
    protected $shopId;
    protected $token;
    protected $urlShipping = 'https://online-gateway.ghn.vn/shiip/public-api/v2/shipping-order/fee';

    public function __construct()
    {
        $this->apiUrl = env('GHN_API_URL');
        $this->shopId = env('GHN_SHOP_ID'); 
        $this->token = env('GHN_API_TOKEN');
    }
    public function store(Request $request)
    {
        $value = $this->fillterData($request->all());

        DB::beginTransaction();

        try {
            $order = $this->saveData($value, session('cart'));

            if ($request['payment_method'] == 'VNPAYQR') {
                $order->status = OrderStatus::PENDING_PAYMENT;
                $order->expires_at = Carbon::now()->addDay();
                $order->save();

                $url = $this->paymentVNPAY($value['after_total_amount'], $order->order_code);
                $routeUrl = redirect()->away($url);
            } else {
                SendOrderToGHN::dispatch($order, $value, session('cart'));
                $routeUrl = redirect()->route('home');
            }

            DB::commit();
            session()->forget('cart');
            return $routeUrl;
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi tạo đơn hàng.');
        }
    }

    //     public function store(Request $request)
    // {
    //     $value = $this->fillterData($request->all());
    //     $order_code = 200;
    //     $order_code = $this->createOrderGHN($value,session('cart'));
    //     if($order_code != 400) {
    //         $data = Order::where('order_code',$order_code)->first();
    //         $value['order_code'] = $order_code;
    //         $value['user_id'] = Auth::id();
    //         // dispatch(new SendOrderConfirmation($value));
    //         if($request['payment_method'] != 'VNPAYQR'){
    //             $this->saveData($value, session('cart'));
    //             $routeUrl = redirect()->route('home');
    //         }else{
    //             // payment save data
    //             $value['payment_method'] = 1;
    //             $order = $this->saveData($value,session('cart'));
    //            if(isset($order)){
    //                $url = $this->paymentVNPAY($value['after_total_amount'],$order_code);
    //                $routeUrl = redirect()->away($url);
    //            }else{
    //                $routeUrl = redirect()->route('home')->withErrors(['error'=>'error system']);
    //            }
    //         }

    //         session()->forget('cart');
    //         return $routeUrl;
    // }else{
    //         return redirect()->back()->with('error', 'Lỗi hệ thống,vui lòng đặt hàng lại sau.');
    //     }
    // }


    private function fillterData(array $data){
        $totalAmount = 0;

        $provinceParts = explode(' - ', $data['province']);
        $provinceName = isset($provinceParts[1]) ? $provinceParts[1] : '';

        // Xử lý huyện
        $districtParts = explode(' - ', $data['district']);
        $districtName = isset($districtParts[1]) ? $districtParts[1] : '';

        // Xử lý xã
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
        foreach (session('cart') as $product) {
            $totalAmount += $product['quantity'] * intval($product['price_sale']);
        }
        $data['before_total_amount'] = $totalAmount;
        $data['after_total_amount'] = $totalAmount;
        $data['shipping'] = 0;

        $data['address'] = $data['specific_address'] . ', ' . $data['ward_name'] . ', ' . $data['district_name'] . ', ' .  $data['province_name'] . ", Vietnam";

        return $data;
    }
    public function createOrderGHN($data,$items)
    {

        $product = $this->formatDataGHN($items);

        $jsonData = [
            "note" => $data['note'] ?? 'No',
            "required_note" => "KHONGCHOXEMHANG",
            "client_order_code" => '',
            "to_name" => $data['name'],
            "to_phone" => $data['phone'],
            "to_address" => $data['address'],
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

        // Điều chỉnh loại thanh toán và COD
        if ($data['payment_method'] == 'VNPAYQR') {
            $jsonData["payment_type_id"] = 1;
            $jsonData["cod_amount"] = 0;
        } else {
            $jsonData["payment_type_id"] = 2;
            $jsonData["cod_amount"] = intval($data['after_total_amount']);
        }


        // Chuẩn bị header cho yêu cầu
        $headers = [
            'Content-Type' => 'application/json',
            'ShopId'=>"4734816",
            'token'=>'d4d4cd6f-8f70-11ee-96dc-de6f804954c9'
        ];
            // Gửi yêu cầu POST tới GHN API
            $response = Http::withHeaders($headers)->post($this->apiUrl, $jsonData);
            // Xử lý phản hồi


            if ($response->successful()) {
                $responseData = $response->json();

                $orderCode = $responseData['data']['order_code'];
                return $orderCode;
            }

            if ($response->failed()) {
                $statusCode = $response->status();
                $errorMessage = $response->json()['message'] ?? 'Unknown error';
                return $statusCode;
            }

        // $data['address_detail'] = $data['address'] . ', ' . $data['ward_name'] . ', ' . $data['district_name'] . ', ' .  $data['province_name'] . ", Vietnam";
        // return $data;

    }
    public function formatDataGHN($data){
        $items = [];
        foreach ($data as $key => $product) {
            $item = [
                "name" => $product['name'],
                "quantity" => (int) $product['quantity'],
                "price" => intval($product['price']),
                "code" => $key.'ABC',
                "weight" => 100,
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
            $order = Order::create($data);

            $products = [];
            foreach ($dataProducts as $id => $item) {
                $products[$id] = [
                    'name' => $item['name'],
                    'image' => $item['image'],
                    'price_regular' => $item['price_regular'],
                    'price_sale' => $item['price_sale'],
                    'quantity' => $item['quantity']
                ];
            }
            $this->updateQuantityProduct($products);
            $order->products()->attach($products);
            return $order;
        });    
    }

    public function UpdateStatusOrder($status,$code){
        try {
            $order = Order::query()->where('order_code',$code)->first();
            $order->update([
                'status' => $status,
            ]);
        }catch (\Exception $exception){
            dd($exception);
        }
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
            $this->UpdateStatusOrder(OrderStatus::PREPARE,$code);
            return redirect()->route('home');
        }else{
            return redirect()->route('home');
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
        // Chuẩn bị header cho yêu cầu
        $headers = [
            'Content-Type' => 'application/json',
            'ShopId'=> $this->shopId,
            'token'=> $this->token,
        ];

        // Gửi yêu cầu POST tới GHN API
        $response = Http::withHeaders($headers)->post($this->urlShipping, $jsonData);

        Log::debug($response);
        // Xử lý phản hồi
        if ($response->successful()) {
            $responseData = $response->json();
            $total = $responseData['data']['total'];
            // Kiểm tra và cập nhật session total_cart
            session(['service_fee' => $total]);
            return response()->json($responseData,200) ;
        }
        if ($response->failed()) {
            $statusCode = $response->status();
            $errorMessage = $response->json()['message'] ?? 'Unknown error';
            return $response;
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

}
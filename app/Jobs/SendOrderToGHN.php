<?php

// app/Jobs/SendOrderToGHN.php
namespace App\Jobs;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Enums\OrderStatus;

class SendOrderToGHN implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3; // Số lần thử lại tối đa
    public $retryAfter = 300; // 5 phút

    protected $order;
    protected $data;
    protected $items;
    protected $apiUrl = env('GHN_API_URL'); // Thay thế bằng URL thực tế

    public function __construct(Order $order, $data, $items)
    {
        $this->order = $order;
        $this->data = $data;
        $this->items = $items;
    }

    public function handle()
    {
        $this->order->status = OrderStatus::PENDING;
        $this->order->save();

        try {
            $response = $this->sendToGHN();

            if ($response->successful()) {
                $responseData = $response->json();
                $orderCode = $responseData['data']['order_code'];
                $this->order->order_code = $orderCode;
                $this->order->status = OrderStatus::PREPARE;
                $this->order->save();
            } else {
                throw new \Exception('Failed to send order to GHN');
            }
        } catch (\Exception $e) {
            Log::error('Error sending order to GHN: ' . $e->getMessage());
            $this->order->status = OrderStatus::RETRY;
            $this->order->save();
            $this->release($this->retryAfter);
        }
    }

    protected function sendToGHN()
    {
        $product = $this->formatDataGHN($this->items);

        $jsonData = [
            "note" => $this->data['note'] ?? 'No',
            "required_note" => "KHONGCHOXEMHANG",
            "client_order_code" => '',
            "to_name" => $this->data['name'],
            "to_phone" => $this->data['phone'],
            "to_address" => $this->data['address_detail'],
            "to_ward_name" => $this->data['ward_name'],
            "to_district_name" => $this->data['district_name'],
            "to_province_name" => $this->data['province_name'],
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

        if ($this->data['payment_method'] == 'VNPAYQR') {
            $jsonData["payment_type_id"] = 1;
            $jsonData["cod_amount"] = 0;
        } else {
            $jsonData["payment_type_id"] = 2;
            $jsonData["cod_amount"] = intval($this->data['after_total_amount']);
        }

        $headers = [
            'Content-Type' => 'application/json',
            'ShopId' => "4734816",
            'token' => 'd4d4cd6f-8f70-11ee-96dc-de6f804954c9'
        ];

        return Http::withHeaders($headers)->post($this->apiUrl, $jsonData);
    }

     public function formatDataGHN($data){
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
}
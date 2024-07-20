<?php

namespace App\Http\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class GHNTranform
{
    protected $apiUrl;
    protected $shopId;
    protected $token;

    public function __construct()
    {
        $this->apiUrl = env('GHN_API_URL');
        $this->shopId = env('GHN_SHOP_ID'); 
        $this->token = env('GHN_API_TOKEN');
    }

    public function saveOrderDataToStorage($data, $orderCode)
    {
        Storage::put("orders/{$orderCode}.json", json_encode($data));
    }

    public function getOrderDataFromStorage($orderCode)
    {
        $data = Storage::get("orders/{$orderCode}.json");
        return json_decode($data, true);
    }

    public function deleteOrderDataFromStorage($orderCode)
    {
        Storage::delete("orders/{$orderCode}.json");
    }

    public function sendToGHN($data)
    {
        $headers = [
            'Content-Type' => 'application/json',
            'ShopId' => $this->shopId,
            'token' => $this->token
        ];

        return Http::withHeaders($headers)->post($this->apiUrl, $data);
    }

     
}
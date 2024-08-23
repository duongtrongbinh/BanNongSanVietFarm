<?php

namespace App\Console\Commands;

use App\Models\service_fee;
use App\Models\Ward;
use Barryvdh\Debugbar\Twig\Extension\Debug;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;

class importServiceFees extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:serviceFees';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $urlShipping = 'https://online-gateway.ghn.vn/shiip/public-api/v2/shipping-order/fee';

            $headers = [
                'Content-Type' => 'application/json',
                'ShopId' => env('GHN_SHOP_ID'),
                'token' => env('GHN_API_TOKEN'),
            ];

            $this->info('Starting process...');

            \App\Models\District::with('ward')->chunk(10, function($districts) use ($headers, $urlShipping) {
                $responseService = [];
                $failedRequests = [];

                foreach ($districts as $district) {
                    $ward = $district->ward->first();

                    if ($ward) {
                        $jsonData = $this->fillterDataShipping([
                            'WardCode' => $ward->WardCode,
                            'DistrictID' => $ward->DistrictID,
                        ]);

                        try {
                            $response = Http::withHeaders($headers)
                                ->timeout(30) // Thêm timeout cho request
                                ->post($urlShipping, $jsonData);

                            if ($response->successful()) {
                                $responseService[] = [
                                    'WardCode' => $ward['WardCode'],
                                    'DistrictID' => $ward['DistrictID'],
                                    'service_fee' => $response['data']['total'],
                                ];
                            } else {
                                $failedRequests[] = [
                                    'DistrictName' => $district->DistrictName,
                                    'WardName' => $ward->WardName,
                                    'error' => $response->body(),
                                ];
                                $this->info('Request failed: ' . $response->body());
                            }
                        } catch (\Exception $e) {
                            $failedRequests[] = [
                                'DistrictName' => $district->DistrictName,
                                'WardName' => $ward->WardName,
                                'error' => $e->getMessage(),
                            ];
                            $this->error('Error for WardCode ' . $ward['WardCode'] . ': ' . $e->getMessage());
                        }
                    }
                }

                // Cập nhật hoặc thêm mới dữ liệu vào database
                if (!empty($responseService)) {
                    $this->updateOrCreateBatch($responseService);
                    sleep(2); // Nghỉ 2 giây giữa các batch để tránh quá tải
                }

                // Ghi log các lỗi kết nối
                if (!empty($failedRequests)) {
                    $this->logFailedRequests($failedRequests);
                }

                $this->info("Processed a chunk of districts.");
            });

            $this->info('Process completed successfully.');

        } catch (\Exception $exception) {
            $this->error('Exception: ' . $exception->getMessage());
            $this->error('File: ' . $exception->getFile());
            $this->error('Line: ' . $exception->getLine());
        }
    }

    private function updateOrCreateBatch(array $data): void
    {
        foreach ($data as $record) {
            service_fee::updateOrCreate(
                ['WardCode' => $record['WardCode'], 'DistrictID' => $record['DistrictID']],
                ['service_fee' => $record['service_fee'], 'updated_at' => now()]
            );
        }
        $this->info("Đã cập nhật/thêm mới " . count($data) . " bản ghi phí dịch vụ.");
    }

    private function logFailedRequests(array $failedRequests): void
    {
        foreach ($failedRequests as $failed) {
            \Log::error("Failed to connect to API for District: {$failed['DistrictName']}, Ward: {$failed['WardName']}. Error: {$failed['error']}");
        }
        $this->info("Đã ghi log " . count($failedRequests) . " lỗi kết nối.");
    }

    public function fillterDataShipping(array $data)
    {
        return [
            "service_type_id" => 2,
            "to_district_id" => (int)$data["DistrictID"],
            "to_ward_code" => $data['WardCode'],
            "height" => 20,
            "length" => 30,
            "weight" => 3000,
            "insurance_value" => 0,
            "items" => [
                [
                    "name" => 'Xa lách thủy tinh thủy canh 230g',
                    "quantity" => 1,
                    "price" => 17000,
                    "code" => 'xa-lach-thuy-tinh-02',
                    "length" => 20,
                    "width" => 20,
                    "height" => 50,
                    "category" => [
                        "level1" => "Rau",
                    ],
                ],
            ],
        ];
    }

}

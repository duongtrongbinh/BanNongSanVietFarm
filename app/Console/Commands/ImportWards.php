<?php

namespace App\Console\Commands;

use App\Models\District;
use App\Models\Provinces;
use App\Models\Ward;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ImportWards extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:wards';

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
        $url = 'https://online-gateway.ghn.vn/shiip/public-api/master-data/ward';

        $districts = District::all();
        $batchSize = 2000; // Kích thước lô (batch size) để chèn dữ liệu
        $data = [];

        $headers = [
            'Content-Type' => 'application/json',
            'token' => env('GHN_API_TOKEN'),
        ];

        for ($i = 0; $i < count($districts); $i++) {
            $item = $districts[$i];

            $response = Http::withHeaders($headers)->post($url, ['district_id' => $item->DistrictID]);

            if ($response->successful()) {
                $wards = $response->json()['data'];
                if ($wards !== null) {
                    for ($j = 0; $j < count($wards); $j++) {
                        $ward = $wards[$j];
                        // Kiểm tra và gán giá trị mặc định nếu cần
                        $wardCode = $ward['WardCode'] ?? null;
                        $districtID = $ward['DistrictID'] ?? null;
                        $wardName = $ward['WardName'] ?? 'Unknown';

                        if ($wardCode === null || $districtID === null) {
                            Log::warning("Missing data for ward: " . json_encode($ward));
                            continue;
                        }

                        $data[] = [
                            'WardCode' => $wardCode,
                            'DistrictID' => $districtID,
                            'WardName' => $wardName,
                        ];

                        // Chèn dữ liệu theo lô
                        if (count($data) >= $batchSize) {
                            $this->insertBatch($data);
                            $data = []; // Xóa dữ liệu đã chèn
                        }
                    }

                    // Chèn dữ liệu còn lại sau vòng lặp
                    if (!empty($data)) {
                        $this->insertBatch($data);
                    }

                    $this->info('Wards imported successfully for district: ' . $item->DistrictName);
                } else {
                    $this->info('No wards data found for district: ' . $item->DistrictName);
                }
            } else {
                Log::debug($response);
                $this->error('Failed to fetch wards for district: ' . $item->DistrictName);
            }
        }

        return 0;
    }

    private function insertBatch(array $data): void
    {
        // Sử dụng upsert để chèn hoặc cập nhật dữ liệu
        Ward::upsert($data, ['WardCode'], ['DistrictID', 'WardName']);
        $this->info("Inserted/Updated " . count($data) . " ward records.");
    }

}

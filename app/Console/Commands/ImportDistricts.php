<?php

namespace App\Console\Commands;

use App\Models\District;
use App\Models\Provinces;
use Barryvdh\Debugbar\Twig\Extension\Debug;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ImportDistricts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:districts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import districts from external API';

    /**
     * Execute the console command.
     */

    public function handle()
    {
        $headers = [
            'Content-Type' => 'application/json',
            'token' => env('GHN_API_TOKEN'),
        ];

        $url = 'https://online-gateway.ghn.vn/shiip/public-api/master-data/district';
        $provinces = Provinces::all();
        $batchSize = 2000; // Kích thước lô (batch size) để chèn dữ liệu
        $data = [];

        // Sử dụng vòng lặp for thay vì foreach
        for ($i = 0; $i < count($provinces); $i++) {
            $item = $provinces[$i];

            $response = Http::withHeaders($headers)->get($url, ['province_id' => $item->ProvinceID]);

            if ($response->successful()) {
                $districts = $response->json()['data'];
                if ($districts !== null) {
                    for ($j = 0; $j < count($districts); $j++) {
                        $district = $districts[$j];

                        // Kiểm tra và gán giá trị mặc định nếu cần
                        $districtID = $district['DistrictID'] ?? null;
                        $provinceID = $district['ProvinceID'] ?? null;
                        $districtName = $district['DistrictName'] ?? 'Unknown';

                        if ($districtID === null || $provinceID === null) {
                            Log::warning("Missing data for district: " . json_encode($district));
                            continue;
                        }

                        $data[] = [
                            'DistrictID' => $districtID,
                            'ProvinceID' => $provinceID,
                            'DistrictName' => $districtName,
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

                    $this->info('Districts imported successfully for province: ' . $item->ProvinceName);
                } else {
                    $this->info('No districts data found for province: ' . $item->ProvinceName);
                }
            } else {
                Log::debug($response);
                $this->error('Failed to fetch districts for province: ' . $item->ProvinceName);
            }
        }

        return 0;
    }

    private function insertBatch(array $data): void
    {
        District::upsert($data, ['DistrictID'], ['ProvinceID', 'DistrictName']);
        $this->info("Inserted/Updated " . count($data) . " district records.");
    }
}

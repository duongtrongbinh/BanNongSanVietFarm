<?php

namespace App\Console\Commands;

use App\Models\Provinces;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ImportProvinces extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:provinces';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import provinces from external API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $url = 'https://online-gateway.ghn.vn/shiip/public-api/master-data/province';
        $response = Http::withHeaders([
            'Token' => env('GHN_API_TOKEN') // Thay YOUR_API_TOKEN bằng token thật của bạn nếu cần
        ])->get($url);

        $data = [];
        $batchSize = 2000;

        if ($response->successful()) {
            $provinces = $response->json()['data'];
            for ($i = 0; $i < count($provinces) ; $i++){
                $province = $provinces[$i];

                $provinceID = $province['ProvinceID'] ?? null;
                $provinceName = $province['ProvinceName'] ?? 'Unknown';

                if ($provinceID === null) {
                    Log::warning("ProvinceID missing for province: " . json_encode($province));
                    continue;
                }

                $data[] = [
                    'ProvinceID' => $provinceID,
                    'ProvinceName' => $provinceName,
                ];
                if (($i + 1) % $batchSize === 0) {
                    $this->insertBatch($data, $i + 1);
                    $data = [];
                }
            }
            if (!empty($data)) {
                $this->insertBatch($data, count($provinces));
            }

            $this->info('Provinces imported successfully.');
        } else {
            Log::debug($response);
            $this->error('Failed to fetch provinces.');
        }
        return 0;
    }

    private function insertBatch(array $data, int $count): void
    {
        Provinces::upsert($data,['ProvinceID'],['ProvinceName']);
        $this->info("Inserted/Updated {$count} rows.");
    }

}

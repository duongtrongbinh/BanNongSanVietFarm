<?php

namespace App\Console\Commands;

use App\Models\Provinces;
use Illuminate\Console\Command;
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

        if ($response->successful()) {
            $provinces = $response->json()['data'];
            foreach ($provinces as $province) {
                Provinces::updateOrCreate(
                    ['ProvinceID' => $province['ProvinceID']],
                    ['ProvinceName' => $province['ProvinceName']],
                );
            }
            $this->info('Provinces imported successfully.');
        } else {
            Log::debug($response);
            $this->error('Failed to fetch provinces.');
        }
        return 0;
    }
}

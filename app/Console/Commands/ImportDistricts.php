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
        foreach ($provinces as $item) {
            $data = [
                'province_id' => $item->ProvinceID
            ];

            $response = Http::withHeaders($headers)->get($url, $data);

            if ($response->successful()) {
                $districts = $response->json()['data'];
                if ($districts != null){
                    foreach ($districts as $district) {
                        District::updateOrCreate(
                            ['DistrictID' => $district['DistrictID']],
                            [
                                'ProvinceID' => $district['ProvinceID'],
                                'DistrictName' => $district['DistrictName']
                            ]
                        );
                    }
                    $this->info('Districts imported successfully.---->'. $item->ProvinceName.'<-----');
                }else{
                    // Miss api
                    $this->info('Districts imported missing api .---->'. $item->ProvinceName.'<-----');
                }
            }else{
                Log::debug($response);
                $this->error('Failed to fetch districts.');
            }
        }
        return 0;
    }
}
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
        $url = 'https://online-gateway.ghn.vn/shiip/public-api/master-data/ward?district_id';

        $districts = District::all();

        foreach ($districts as $item) {

            $headers = [
                'Content-Type' => 'application/json',
                'token' => env('GHN_API_TOKEN'),
            ];

            $data = [
                'district_id' => $item->DistrictID
            ];

            $response = Http::withHeaders($headers)->post($url, $data);

            if ($response->successful()) {
                $wards = $response->json()['data'];
               if ($wards != null){
                   foreach ($wards as $ward) {
                       Ward::updateOrCreate(
                           ['WardCode' => $ward['WardCode']],
                           [
                               'DistrictID' => $ward['DistrictID'],
                               'WardName' => $ward['WardName']
                           ]
                       );
                   }
                   $this->info('Ward imported successfully.---->'. $item->DistrictName.'<-----');
               }else {
                   $this->info('Ward imported missing api.---->'. $item->DistrictName.'<-----');
               }
            } else {
                // In ra chi tiết response khi gặp lỗi
                Log::debug($response);
                $this->error('Failed to fetch Ward.');
            }
        }
        return 0;
    }
}

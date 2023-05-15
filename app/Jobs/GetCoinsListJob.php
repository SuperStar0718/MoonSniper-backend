<?php

namespace App\Jobs;

use App\Models\CoinsList;
use App\Libraries\CoinGecko\CoinGeckoClient;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GetCoinsListJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

          
        $url = 'https://api.coingecko.com/api/v3/coins/list?include_platform=true';

        // Initialize cURL session
                $curl = curl_init($url);
        
        // Set cURL options
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Return the response as a string
                curl_setopt($curl, CURLOPT_HEADER, false); // Exclude the response headers
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification (temporary solution)
        
        // Execute the cURL request
                $coinsList = curl_exec($curl);
                $coinsList = collect(json_decode($coinsList));

        $newCoinsArray = array();
        $newCoinsIds = array();

        //get all coins (to make sure we can update them):
        foreach ($coinsList as $item){
            $contracts = [];

            if(!empty($item->id)) {
                if(!empty($item->platforms)){
                    foreach ($item->platforms as $platform => $contract){
                        $contracts[]=["platform"=>$platform, "contract_address" => $contract];
                    }
                    $contracts = json_encode($contracts);
                }
                $platformsArray = json_decode(json_encode($item->platforms), true);
                $newCoinsArray[] = array(
                    'coin_id' => $item->id,
                    'symbol' => strtoupper($item->symbol),
                    'name' => $item->name,
                    'coin_platform' =>implode("|", array_keys($platformsArray)),
                    'contract_address' => $contracts ?? NULL
                );
                $newCoinsIds[] = $item->id;
            }
        }

        $exist_ids = CoinsList::all('coin_id')->pluck('coin_id')->toArray();

        // get updatable ids//$updatable_ids = array_values(array_intersect($exist_ids, $newCoinsIds));

        // get insertable ids
        $insertable_ids = array_filter(array_values(array_diff($newCoinsIds, $exist_ids)));

        $purge_ids = array_filter(array_values(array_diff($exist_ids, $newCoinsIds)));
        // prepare data for insert
        $data = collect();
        //Push new coins (if any):
        $collection = collect($coinsList);
        foreach ($insertable_ids as $key => $coinId) {
            $filteredArray = $collection->filter(function ($item) use ($coinId) {
                return $item->id === $coinId;
            })->toArray();
            $filteredArray = array_values($filteredArray);
            $result = isset($filteredArray[0]) ? $filteredArray[0] : null;
            $platformsArray = json_decode(json_encode($item->platforms), true);
            if ($result) {
                 $data->push([
                    'coin_id' => $result->id,
                    'symbol' => strtoupper($result->symbol),
                    'name' => $result->name,
                    'coin_platform' =>implode("|", array_keys($platformsArray)),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

        }
        //first add all needed new items to db:
        $this->tryPushingToDB($data->toArray());
        //Then, lets get rid the old dead tokens:
        foreach ($purge_ids as $to_delete) {
            CoinsList::where('coin_id', $to_delete)->delete();
        }

        //if needed to update?
        CoinsList::massUpdate(
            values:$newCoinsArray,
            uniqueBy:'coin_id'
        );

    }

    private function tryPushingToDB($arr,$iterates=0){
        //if its too many records, lets split it...
        foreach (array_chunk($arr,1000) as $t) {
            try {
                //if there is a duplication order id from any reason, continue...
                CoinsList::insert($t);
                //Log::info("Finance Data has Pushed");
            } catch
            (\Exception $e) {
                //Log should be added here
                Log::info('PROBLEM:' . $e);

                Log::info('Trying Again!');

                if ($iterates < 20) {
                    //Check what is happening?

                    $iterates++;
                    //Call again:
                    $this->tryPushingToDB($t,$iterates);
                } else {
                    Log::info('Im giving up :(');
                }

            }
        }
    }
}
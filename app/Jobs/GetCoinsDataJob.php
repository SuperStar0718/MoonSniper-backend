<?php

namespace App\Jobs;

use App\Models\CoinsData;
use App\Libraries\CoinGecko\CoinGeckoClient;
use App\Models\CoinsList;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use function Amp\File\exists;

class GetCoinsDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $pageno;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($pn)
    {
        $this->pageno = $pn;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $client = new CoinGeckoClient(false);

        $coin_array = $client->coins()->getMarkets('usd', ["sparkline"=>"true","price_change_percentage"=>"1h,24h,7d,14d,30d,200d,1y","per_page"=>"250","page"=>$this->pageno]);
        $coin_array = collect($coin_array);

        $newCoinsArray = array();
        $updateCoinsArray = array();
        $newCoinsIds = array();

        //First, lets get ID only to check what is new:
        foreach ($coin_array as $item){
            if(!empty($item['id'])) {
                $newCoinsIds[] = $item['id'];
            }
        }

        // first get ids from table
        $exist_ids = CoinsData::all('coin_id')->pluck('coin_id')->toArray();

        // get insertable ids (New coins)
        $insertable_ids = array_values(array_diff($newCoinsIds, $exist_ids));

        //What token to remove:

        $exist_list_ids = CoinsList::all('coin_id')->pluck('coin_id')->toArray();
        $purge_ids = array_filter(array_values(array_diff($exist_ids, $exist_list_ids)));

        //get all coins (to make sure we can update them):
        foreach ($coin_array as $item){
            if(!empty($item['id'])) {

                $ath_datetime = new \DateTime($item["ath_date"]);
                $ath_datetime_string = $ath_datetime->format('Y-m-d H:i:s');

                $atl_datetime = new \DateTime($item["atl_date"]);
                $atl_datetime_string = $atl_datetime->format('Y-m-d H:i:s');

                $spark_string = "";
                try {
                    for ($sparkline_index = 0; $sparkline_index < sizeof($item["sparkline_in_7d"]["price"]); $sparkline_index++)
                        $spark_string .= $item["sparkline_in_7d"]["price"][$sparkline_index] . "|";
                } catch (\Exception $e) {
                }

                /*if ($item["roi"] != null) {
                    $roi_times = $item["roi"]["times"];
                    $roi_currency = $item["roi"]["currency"];
                    $roi_percentage = $item["roi"]["percentage"];
                } else {
                    $roi_times = "";
                    $roi_currency = "";
                    $roi_percentage = "";
                }*/

                $total_supply_percent = null;
                if($item["max_supply"] != null && $item["circulating_supply"] != null)
                {
                    $total_supply_percent = (floatval($item["circulating_supply"]) * 100) / floatval($item["max_supply"]);
                }

                $coin = array(
                    'coin_id' => $item["id"],
                    'symbol' => strtoupper($item["symbol"]),
                    'image' => $item["image"],
                    'current_price' => $item["current_price"],
                    'market_cap' => $item["market_cap"],
                    'market_cap_rank' => $item["market_cap_rank"],
                    'fully_diluted_valuation' => $item["fully_diluted_valuation"],
                    'total_volume' => $item["total_volume"],
                    'high_24h' => $item["high_24h"],
                    'low_24h' => $item["low_24h"],
                    'price_change_24h' => $item["price_change_24h"],
                    'price_change_percentage_24h' => $item["price_change_percentage_24h"],
                    'market_cap_change_24h' => $item["market_cap_change_24h"],
                    'market_cap_change_percentage_24h' => $item["market_cap_change_percentage_24h"],
                    'circulating_supply' => $item["circulating_supply"],
                    'total_supply' => $item["total_supply"],
                    'total_supply_percent' => $total_supply_percent,
                    'max_supply' => $item["max_supply"],
                    'ath' => $item["ath"],
                    'ath_change_percentage' => $item["ath_change_percentage"],
                    'ath_date' => $ath_datetime_string,
                    'atl' => $item["atl"],
                    'atl_change_percentage' => $item["atl_change_percentage"],
                    'atl_date' => $atl_datetime_string,
                    'price_change_percentage_14d_in_currency' => $item["price_change_percentage_14d_in_currency"],
                    'price_change_percentage_1h_in_currency' => $item["price_change_percentage_1h_in_currency"],
                    'price_change_percentage_1y_in_currency' => $item["price_change_percentage_1y_in_currency"],
                    'price_change_percentage_200d_in_currency' => $item["price_change_percentage_200d_in_currency"],
                    'price_change_percentage_24h_in_currency' => $item["price_change_percentage_24h_in_currency"],
                    'price_change_percentage_30d_in_currency' => $item["price_change_percentage_30d_in_currency"],
                    'price_change_percentage_7d_in_currency' => $item["price_change_percentage_7d_in_currency"],
                    'sparkline_in_7d' => $spark_string,
                    'created_at' => now(),
                    'updated_at' => now()
                );

                //Removed these lines (we are taking the xs from cryptorank today):
/*
                'roi_times' => !empty($roi_times) ? $roi_times : NULL,
                    'roi_currency' => $roi_currency,
                    'roi_percentage' => !empty($roi_percentage) ? $roi_percentage : NULL,

                    Also, I removed these (it overwrite the social fields!!)
                    'description' => "",
                    'platform' => "",
                    'historical_sentiment' => "[]",
                    'historical_social_mentions' => "[]",
                    'historical_social_engagement' => "[]",
*/

                if(in_array($item["id"],$insertable_ids)) {
                    $newCoinsArray[] = $coin;
                }else{
                    $updateCoinsArray[] = $coin;
                }
            }
        }


        // prepare data for insert
        //$data = collect();

        //first add all needed new items to db:
        $this->tryPushingToDB($newCoinsArray);

        Try {
            CoinsData::massUpdate(
                values: $updateCoinsArray,
                uniqueBy: 'coin_id'
            );
        }catch (\Exception $exception){
            Log::info("The Problem here is: ".$exception);
        }

        //Delete unneeded and dead tokens:
        foreach ($purge_ids as $to_delete){
            CoinsData::where('coin_id', $to_delete)->delete();
        }

        return sizeof($coin_array);

    }

    private function tryPushingToDB($arr,$iterates=0){
        //if its too many records, lets split it...
        foreach (array_chunk($arr,1000) as $t) {
            try {
                //if there is a duplication order id from any reason, continue...
                CoinsData::insert($t);
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

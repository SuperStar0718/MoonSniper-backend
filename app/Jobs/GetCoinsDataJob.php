<?php

namespace App\Jobs;

use App\Models\CoinsData;
use App\Libraries\CoinGecko\CoinGeckoClient;
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

        if(Cache::has('proxy')){
            if(Cache::get('proxy')){
                Cache::put('proxy', false, 500);
            }else{
                Cache::put('proxy', true, 500);
            }
        }else{
            Cache::put('proxy', true, 500);
        }

        $client = new CoinGeckoClient(Cache::get('proxy'));
        $coin_array = $client->coins()->getMarkets('usd', ["sparkline"=>"true","price_change_percentage"=>"1h,24h,7d,14d,30d,200d,1y","per_page"=>"250","page"=>$this->pageno]);
        $coin_array = collect($coin_array);


        $newCoinsArray = array();
        $newCoinsIds = array();

        $currentSymbols = [];

        //get all coins (to make sure we can update them):
        foreach ($coin_array as $item){
            if(!empty($item['id'])) {
                //avoid duplications on the current run
                if (!in_array(strtoupper($item["symbol"]), $currentSymbols)) {
                    $currentSymbols[] = strtoupper($item["symbol"]);

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

                    $roi_times = "";
                    $roi_currency = "usd";
                    $roi_percentage = "";

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


                    $newCoinsArray[] = array(
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
                        'roi_times' => !empty($roi_times) ? $roi_times : NULL,
                        'roi_currency' => $roi_currency,
                        'roi_percentage' => !empty($roi_percentage) ? $roi_percentage : NULL,
                        'price_change_percentage_14d_in_currency' => $item["price_change_percentage_14d_in_currency"],
                        'price_change_percentage_1h_in_currency' => $item["price_change_percentage_1h_in_currency"],
                        'price_change_percentage_1y_in_currency' => $item["price_change_percentage_1y_in_currency"],
                        'price_change_percentage_200d_in_currency' => $item["price_change_percentage_200d_in_currency"],
                        'price_change_percentage_24h_in_currency' => $item["price_change_percentage_24h_in_currency"],
                        'price_change_percentage_30d_in_currency' => $item["price_change_percentage_30d_in_currency"],
                        'price_change_percentage_7d_in_currency' => $item["price_change_percentage_7d_in_currency"],
                        'sparkline_in_7d' => $spark_string,
                        'description' => "",
                        'platform' => "",
                        'created_at' => now(),
                        'updated_at' => now()

                    );
                    $newCoinsIds[] = strtoupper($item['symbol']);
                }
            }
        }

        // first get ids from table
        $exist_ids = CoinsData::all('symbol')->pluck('symbol')->toArray();

        // get insertable ids
        $insertable_ids = array_values(array_diff($newCoinsIds, $exist_ids));
        // prepare data for insert
        $data = collect();

        //check for symbol duplications, if we do, lets get rid of the lower rank:
        $duplicates = array();
        foreach(array_count_values($insertable_ids) as $val => $c)
            if($c > 1) $duplicates[] = $val;

        $skip=$exist_ids;

        $currentSymbols2 = [];

        //Push new coins (if any):
        foreach ($insertable_ids as $key => $coinId) {

            if(!in_array(strtoupper($coin_array[$key]["symbol"]),$skip)) {
                if (!in_array(strtoupper($coin_array[$key]["symbol"]), $currentSymbols2)) {
                    $currentSymbols2[] = $coin_array[$key]["symbol"];

            $ath_datetime = new \DateTime( $item["ath_date"]);
            $ath_datetime_string = $ath_datetime->format('Y-m-d H:i:s');

            $atl_datetime = new \DateTime( $item["atl_date"]);
            $atl_datetime_string = $atl_datetime->format('Y-m-d H:i:s');

            $spark_string = "";
            try{
                for($sparkline_index = 0; $sparkline_index < sizeof($item["sparkline_in_7d"]["price"]); $sparkline_index++)
                    $spark_string .= $item["sparkline_in_7d"]["price"][$sparkline_index]."|";
            }catch(\Exception $e)
            {
                Log::error($e);
            }

            $roi_times = null;
            $roi_currency = null;
            $roi_percentage = null;

            if($coin_array[$key]["roi"] != null)
            {
                $roi_times = $coin_array[$key]["roi"]["times"];
                $roi_currency = $coin_array[$key]["roi"]["currency"];
                $roi_percentage = $coin_array[$key]["roi"]["percentage"];
            }

            $total_supply_percent = null;
            if($coin_array[$key]["max_supply"] != null && $coin_array[$key]["circulating_supply"] != null)
            {
                $total_supply_percent = (floatval($coin_array[$key]["circulating_supply"]) * 100) / floatval($coin_array[$key]["max_supply"]);
            }

            $data->push([
                'coin_id' => $coin_array[$key]["id"],
                'symbol' => strtoupper($coin_array[$key]["symbol"]),
                'image' => $coin_array[$key]["image"],
                'current_price' =>$coin_array[$key]["current_price"],
                'market_cap' => $coin_array[$key]["market_cap"],
                'market_cap_rank' => $coin_array[$key]["market_cap_rank"],
                'fully_diluted_valuation' => $coin_array[$key]["fully_diluted_valuation"],
                'total_volume' => $coin_array[$key]["total_volume"],
                'high_24h' => $coin_array[$key]["high_24h"],
                'low_24h' => $coin_array[$key]["low_24h"],
                'price_change_24h' => $coin_array[$key]["price_change_24h"],
                'price_change_percentage_24h' => $coin_array[$key]["price_change_percentage_24h"],
                'market_cap_change_24h' => $coin_array[$key]["market_cap_change_24h"],
                'market_cap_change_percentage_24h' => $coin_array[$key]["market_cap_change_percentage_24h"],
                'circulating_supply' => $coin_array[$key]["circulating_supply"],
                'total_supply' => $coin_array[$key]["total_supply"],
                'total_supply_percent' =>  $total_supply_percent,
                'max_supply' => $coin_array[$key]["max_supply"],
                'ath' => $coin_array[$key]["ath"],
                'ath_change_percentage' => $coin_array[$key]["ath_change_percentage"],
                'ath_date' => $ath_datetime_string,
                'atl' => $coin_array[$key]["atl"],
                'atl_change_percentage' => $coin_array[$key]["atl_change_percentage"],
                'atl_date' => $atl_datetime_string,
                'roi_times' => $roi_times,
                'roi_currency' => $roi_currency,
                'roi_percentage' => $roi_percentage,
                'price_change_percentage_14d_in_currency' => $coin_array[$key]["price_change_percentage_14d_in_currency"],
                'price_change_percentage_1h_in_currency' => $coin_array[$key]["price_change_percentage_1h_in_currency"],
                'price_change_percentage_1y_in_currency' => $coin_array[$key]["price_change_percentage_1y_in_currency"],
                'price_change_percentage_200d_in_currency' => $coin_array[$key]["price_change_percentage_200d_in_currency"],
                'price_change_percentage_24h_in_currency' => $coin_array[$key]["price_change_percentage_24h_in_currency"],
                'price_change_percentage_30d_in_currency' => $coin_array[$key]["price_change_percentage_30d_in_currency"],
                'price_change_percentage_7d_in_currency' => $coin_array[$key]["price_change_percentage_7d_in_currency"],
                'sparkline_in_7d' => $spark_string,
                'description' => "",
                'platform' => "",
                'created_at' => now(),
                'updated_at' => now()
            ]);
                }
            }

            if(in_array(strtoupper(strtoupper($coin_array[$key]["symbol"])),$duplicates)){
                $skip[] = strtoupper(strtoupper($coin_array[$key]["symbol"]));
            }
        }

        //first add all needed new items to db:
        $this->tryPushingToDB($data->toArray());

        //Get all records from db with the symbil from array:
        $existingSymbols = CoinsData::whereIn('symbol', $currentSymbols)->get()->keyBy('symbol')->toArray();

        foreach ($newCoinsArray as $key=>$value){
            $currSymbol=$value['symbol'];
            //check if we have this coin in DB with a different ID:
            if(isset($existingSymbols[$currSymbol]['coin_id'])) {
                if ($value['coin_id'] != $existingSymbols[$currSymbol]['coin_id']) {
                    //We have a duplication!, lets check what is higher m.cap, and we will keep this one:
                    if ((int)$value['market_cap'] > (int)$existingSymbols[$currSymbol]['market_cap']) {
                        //This M.cap is higher, lets delete the old one on db?
                        CoinsData::where('symbol', $currSymbol)->delete();
                    } else {
                        //The db is higher, we can remove it from the list.
                        unset($newCoinsArray[$key]);
                    }
                }
            }
        }

        Try {
            CoinsData::massUpdate(
                values: $newCoinsArray,
                uniqueBy: 'coin_id'
            );
        }catch (\Exception $exception){
            Log::info("The Problem here is: ".$exception);
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

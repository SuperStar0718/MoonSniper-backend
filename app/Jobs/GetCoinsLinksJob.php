<?php

namespace App\Jobs;

use App\Http\Controllers\Messari;
use App\Models\CoinsList;
use App\Models\CoinsData;
use DateInterval;
use DateTime;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GetCoinsLinksJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $page;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($page)
    {
        $this->page = $page;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $allAssets = Messari::getAllAssets(['limit'=>500,'page'=>$this->page]);
        $supported_links = ["website","whitepaper","twitter","medium","reddit","github","telegram","discord","slack","0xtracker"];

        // prepare data for insert
        $data = collect();
        $data2 = collect();
        if(isset($allAssets["data"])){
            foreach ($allAssets["data"] as $coin){
                $dataToPush = array();
                $coinInfoToPush = array();

                if(isset($coin["profile"]["general"]["overview"]["official_links"])) {

                    //coin with links
                    foreach ($coin["profile"]["general"]["overview"]["official_links"] as $links) {
                        if (in_array(strtolower($links['name']), $supported_links)) {
                            $coinInfoToPush[strtolower($links['name'])] = $links['link'];
                        }
                    }
                }

                    // Description
                    if(isset($coin["profile"]["general"]["overview"]["project_details"]))
                    {
                        $coinInfoToPush['coin_description'] = $coin["profile"]["general"]["overview"]["project_details"];
                    }

                    // Tagline
                    if(isset($coin["profile"]["general"]["overview"]["tagline"])){
                        $coinInfoToPush['tagline'] = $coin["profile"]["general"]["overview"]["tagline"];
                    }

                    // Category
                    if(isset($coin["metrics"]["misc_data"]["categories"]))
                    {
                        $coinInfoToPush['coin_category'] = implode("|", $coin["metrics"]["misc_data"]["categories"]);
                    }

                    // xs from launch
                    if(isset($coin["profile"]["economics"]["launch"]["fundraising"]["sales_rounds"]))
                    {
                        if(!empty($coin["profile"]["economics"]["launch"]["fundraising"]["sales_rounds"])) {
                            //get the last round with price data:
                            $total_rounds = count($coin["profile"]["economics"]["launch"]["fundraising"]["sales_rounds"]);

                            for($i=$total_rounds;$i>0;$i--){
                            if(!empty($coin["profile"]["economics"]["launch"]["fundraising"]["sales_rounds"][$i-1]["equivalent_price_per_token_in_usd"])){
                                $dataToPush['round_sale'] = $coin["profile"]["economics"]["launch"]["fundraising"]["sales_rounds"][$i-1]["title"];
                                $dataToPush['round_price'] = $coin["profile"]["economics"]["launch"]["fundraising"]["sales_rounds"][$i-1]["equivalent_price_per_token_in_usd"];
                                break;
                            }
                            }


                        }
                    }

                    // Genesis Date
                    if(isset($coin["metrics"]["misc_data"]["asset_age_days"]))
                    {
                        if(intval($coin["metrics"]["misc_data"]["asset_age_days"]) >= 0)
                        {
                            $currentDate = new DateTime('Y-m-d');
                            $genesisDateDT = $currentDate->sub(new DateInterval('P'.intval($coin["metrics"]["misc_data"]["asset_age_days"]).'D'));
                            $coinInfoToPush['genesis_date'] = $genesisDateDT->format('Y-m-d');
                        }

                    }else if(isset($coin["profile"]["economics"]["launch"]["initial_distribution"]["genesis_block_date"]))
                    {
                        $genesis_date = $coin["profile"]["economics"]["launch"]["initial_distribution"]["genesis_block_date"];

                        if(strpos($genesis_date, "T"))
                        {
                            $genesis_date = substr($genesis_date, 0, strpos($genesis_date, "T"));
                            $coinInfoToPush['genesis_date'] = $genesis_date;
                        }
                    }



                    // Contract Address
                    /*if(isset($coin["contract_addresses"]))
                    {

                        $coinInfoToPush['contract_address'] = json_encode($coin["contract_addresses"]);

                    }*/



                // Process Trading Volume (volume_last_24_hours)
                if(isset($coin["metrics"]["market_data"]["volume_last_24_hours"])){

                    $dataToPush['trading_volume'] = $coin["metrics"]["market_data"]["volume_last_24_hours"];

                }

                //$data2->push(array_merge(['coin_id' => $coin['slug']], $dataToPush));

                CoinsData::where('symbol', strtoupper($coin['symbol']))
                    ->update($dataToPush);

                //$data->push(array_merge(['coin_id' => $coin['slug']],$coinInfoToPush));

                CoinsList::where('symbol', strtoupper($coin['symbol']))
                    ->update($coinInfoToPush);
                     }
            }
        }

        //TODO: We should add it back (debug to check why it doesnt worked)
        /*CoinsList::massUpdate(
            values : $data->toArray(),
            uniqueBy : 'coin_id'
        );


        CoinsData::massUpdate(
            values : $data2->toArray(),
            uniqueBy : 'coin_id'
        );



        */
}

<?php

namespace App\Jobs;

use App\Models\CoinsData;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GetCryptorankRIOJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
       
        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $existing_coin_ids = CoinsData::select('coin_id','current_price')->get();

        $tokens_id = [];
        $id_price = [];

        foreach($existing_coin_ids as $token) {
            array_push($tokens_id,$token->coin_id);
            $id_price[$token->coin_id] = $token->current_price;
        }


        $url = 'https://api.cryptorank.io/v0/coins/crowdsales';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.15) Gecko/20080623 Firefox/2.0.0.15") );
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result= curl_exec ($ch);
        curl_close ($ch);
        $tokens_with_roi = json_decode($result, true);

        $newCoinsArray = [];

        foreach ($tokens_with_roi['data'] as $token_name => $token_data) {
            if(in_array($token_name,$tokens_id)){

                for($rounds=1;$rounds<=count($token_data);$rounds++){

                    if (array_key_exists('price', $token_data[count($token_data)-$rounds])) {
                        //lets use this price

                        if(isset($token_data[count($token_data)-$rounds]['price']['USD'])) {
                            $init_price = $token_data[count($token_data) - $rounds]['price']['USD'];
                            $price_today = $id_price[$token_name];
                            $ROI = round($price_today / $init_price, 2);
                            $roi_percentage = $ROI * 100 - 100;
                            $newCoinsArray[] = array(
                                'coin_id' => $token_name,
                                'roi_times' => $ROI,
                                'roi_currency' => 'usd',
                                'roi_percentage' => $roi_percentage
                            );
                        }//else we dont have other coins to compare with!
                    }
                }
            }
        }


        //push to DB:
        Try {
            CoinsData::massUpdate(
                values: $newCoinsArray,
                uniqueBy: 'coin_id'
            );
        }catch (\Exception $exception){
            Log::info("The Problem here is: ".$exception);
        }
    }
}

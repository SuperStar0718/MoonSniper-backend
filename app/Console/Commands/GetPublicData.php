<?php

namespace App\Console\Commands;

use App\Models\CoinsData;
use Illuminate\Console\Command;

class GetPublicData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'moon:get_public_data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $existing_coin_ids = CoinsData::select('coin_id','current_price')->get();

        foreach($existing_coin_ids as $token) {
            $url = 'https://api.coingecko.com/api/v3/coins/'.$token->coin_id.'/market_chart?vs_currency=usd&days=max';

            // Initialize cURL session
            $curl = curl_init($url);

            // Set cURL options
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Return the response as a string
            curl_setopt($curl, CURLOPT_HEADER, false); // Exclude the response headers
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification (temporary solution)

            // Execute the cURL request
            $coinsList = curl_exec($curl);
            $coinsList = collect(json_decode($coinsList));

            //get all coins (to make sure we can update them):
            foreach ($coinsList as $item){

                //save data back to db:
                /*$init_price = $token_data[count($token_data) - $rounds]['price']['USD'];
                $price_today = $id_price[$token_name];
                $ROI = round($price_today / $init_price, 2);
                $roi_percentage = $ROI * 100 - 100;
                $type = $token_data[count($token_data) - $rounds]['type'];*/


            }













        }

        return Command::SUCCESS;
    }
}

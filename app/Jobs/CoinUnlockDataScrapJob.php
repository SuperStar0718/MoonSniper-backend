<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\CoinsData;
use App\Models\CoinsList;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class CoinUnlockDataScrapJob implements ShouldQueue
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
        $jsonData = file_get_contents('https://token.unlocks.app/');
        $data = $this->getBetween($jsonData, 'type="application/json">', '</script>');
        $data1 = json_decode($data);
        $data1->props->pageProps->info->data;
        $array = [];
        foreach ($data1->props->pageProps->info->data as $key => $value) {
            $coin = CoinsList::where('name', $value->token->name)->where('coins.symbol', $value->token->symbol)
              ->first();
            if ($coin) {

                $coinData = CoinsData::where('coin_id', $coin->coin_id)->first();

                if ($coinData) {
                    $coinData->current_price = $value->token->price;
                    $coinData->fully_diluted_valuation = $value->token->fullyDiluted;
                    $coinData->market_cap = $value->token->marketCap;
                    $coinData->max_supply = $value->token->maxSupply;
                    if ($value->nextEventData != null) {
                        $coinData->next_unlock_date = Carbon::parse($value->nextEventData->beginDate);
                        $coinData->next_unlock_number_of_tokens = $value->nextEventData->amount;

                        $tokenPer = $value->nextEventData->amount / $value->token->maxSupply * 100;
                        $coinData->next_unlock_percent_of_tokens =  $tokenPer;
                     
                        if($tokenPer >=0 && $tokenPer <=8)
                        {
                             $coinData->next_unlock_size =  'SMALL';
                        }else if($tokenPer >8 && $tokenPer <=14)
                        {
                              $coinData->next_unlock_size =  'MEDIUM';
                        }else if($tokenPer >14){
                             $coinData->next_unlock_size =  'BIG';
                        }
                    }
                    $coinData->save();
                }
            }
            // $coinData->next_unlock_number_of_tokens =$value->nextEventData->amount;

            // ->leftJoin('coin_data', 'coins.symbol', '=', 'coin_data.symbol')->first();
        }



        foreach ($data1->props->pageProps->info->data as $key => $value) {
            $array[] = CoinsList::where('name', $value->token->name)->where('coins.symbol', $value->token->symbol)->select('coin_data.*')
                ->leftJoin('coin_data', 'coins.symbol', '=', 'coin_data.symbol')->first();

        }
        // return $data1->props->pageProps->info->data;
        return count($data1->props->pageProps->info->data);
    }
    public static function getBetween($content, $start, $end)
    {
        $r = explode($start, $content);
        if (isset($r[1])) {
            $r = explode($end, $r[1]);
            return $r[0];
        }
        return '';
    }
}

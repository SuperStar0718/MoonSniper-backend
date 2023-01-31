<?php

namespace App\Jobs;

use App\Models\CoinsData;
use App\Models\CoinsList;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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
        $array = [];
        foreach ($data1->props->pageProps->info->data as $key => $value) {
            $coin = CoinsList::where('name', $value->token->name)->where('coins.symbol', $value->token->symbol)->first();
            if ($value->token->coingeckoId) {
                if (!$coin) {
                    $newCoin = new CoinsList();
                    $newCoin->coin_id = $value->token->coingeckoId;
                    $newCoin->symbol = $value->token->symbol;
                    $newCoin->name = $value->token->name;
                    $newCoin->trading_history_flag = 0;
                    $newCoin->save();
                    $coin = $newCoin;
                }
                $coinData = CoinsData::where('coin_id', $coin->coin_id)->where('symbol', $value->token->symbol)->first();
                if ($coinData) {
                    $coinData->current_price = $value->token->price;
                    $coinData->fully_diluted_valuation = $value->token->fullyDiluted;
                    $coinData->market_cap = $value->token->marketCap;
                    $coinData->max_supply = $value->token->maxSupply;
                    $coinData->total_locked = $value->totalLockedAmount;
                    $coinData->circulating_supply = $value->token->circulatingSupply;
                    if ($value->token->maxSupply != 0) {
                        $tokenPer = ($value->totalLockedAmount / $value->token->maxSupply) * 100;
                        if ($tokenPer >= 0 && $tokenPer <= 8) {
                            $coinData->next_unlock_size = 'SMALL';
                        } else if ($tokenPer > 8 && $tokenPer <= 14) {
                            $coinData->next_unlock_size = 'MEDIUM';
                        } else if ($tokenPer > 14) {
                            $coinData->next_unlock_size = 'BIG';
                        }
                        $coinData->total_locked_percent = $tokenPer;

                    }
                    if ($value->nextEventData != null) {
                        $coinData->next_unlock_date = Carbon::parse($value->nextEventData->beginDate);
                        $coinData->next_unlock_number_of_tokens = $value->nextEventData->amount;
                        if($value->token->maxSupply != 0 || $coinData->circulating_supply !=0)
                        {
                            $nextUnlockPer = $coinData->next_unlock_number_of_tokens  / ($value->token->maxSupply?$value->token->maxSupply:$coinData->circulating_supply) * 100;
                            $coinData->next_unlock_percent_of_tokens = $nextUnlockPer;
                        }
                        $coinData->vesting_status = 0;

                    }
                   
                    $coinData->save();
                } else {
                    $coinData = new CoinsData();
                    $coinData->coin_id = $value->token->coingeckoId;
                    $coinData->image = $value->token->icon;
                    $coinData->symbol = $value->token->symbol;
                    $coinData->circulating_supply = $value->token->circulatingSupply;
                    $coinData->current_price = $value->token->price;
                    $coinData->fully_diluted_valuation = $value->token->fullyDiluted;
                    $coinData->market_cap = $value->token->marketCap;
                    $coinData->market_cap = $value->token->marketCap;
                    $coinData->max_supply = $value->token->maxSupply;
                    $coinData->total_locked = $value->totalLockedAmount;
                    if ($value->token->maxSupply != 0) {
                        $tokenPer = ($value->totalLockedAmount / $value->token->maxSupply) * 100;
                        if ($tokenPer >= 0 && $tokenPer <= 8) {
                            $coinData->next_unlock_size = 'SMALL';
                        } else if ($tokenPer > 8 && $tokenPer <= 14) {
                            $coinData->next_unlock_size = 'MEDIUM';
                        } else if ($tokenPer > 14) {
                            $coinData->next_unlock_size = 'BIG';
                        }
                        $coinData->total_locked_percent = $tokenPer;

                    }
                    if ($value->nextEventData != null) {
                        $coinData->next_unlock_date = Carbon::parse($value->nextEventData->beginDate);
                        $coinData->next_unlock_number_of_tokens = $value->nextEventData->amount;
                        $coinData->vesting_status = 0;

                    }
                    
                    if ($value->nextEventData != null) {
                        $coinData->next_unlock_date = Carbon::parse($value->nextEventData->beginDate);
                        $coinData->next_unlock_number_of_tokens = $value->nextEventData->amount;
                        if($value->token->maxSupply != 0 || $coinData->circulating_supply != 0)
                        {
                            $nextUnlockPer = $coinData->next_unlock_number_of_tokens  / ($value->token->maxSupply?$value->token->maxSupply:$coinData->circulating_supply) * 100;
                            $coinData->next_unlock_percent_of_tokens = $nextUnlockPer;
                        }
                        $coinData->vesting_status = 0;

                    }
                    /*
                     * Removed (Automatically overwrite the fields!)
                     * $coinData2->historical_sentiment = '[]';
                    $coinData2->historical_social_mentions = '[]';
                    $coinData2->historical_social_engagement = '[]';*/

                    $coinData->save();
                }

            }
        }

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

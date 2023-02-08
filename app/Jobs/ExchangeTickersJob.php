<?php

namespace App\Jobs;

use App\Libraries\CoinGecko\CoinGeckoClient;
use App\Models\Exchange;
use App\Models\ExchangeTicker;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ExchangeTickersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $i = 1;
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
        $client = new CoinGeckoClient(false);
        $ticker = Exchange::where('flag', 0)->limit(1)->first();
        $this->i = 1;
        if ($ticker) {
            $value = $ticker;
              $deleteDickers = ExchangeTicker::where('exchange_id', $value->exchangeid)->delete();
            try {
                $tickerData = $client->exchanges()->getTickers($value->exchangeid, ['page' => $this->i]);
                $this->callTickerPerpage($tickerData,$value);

            } catch (\Throwable$th) {
                Log::info(['429 MOONERROR' => $th]);
                $count = Exchange::where('flag', 0)->count();
                if ($count > 0) {
                    ExchangeTickersJob::dispatch()->onQueue('moon-sniper-worker-long')->delay(60);
                } else {
                    DB::table('exchanges')
                        ->update(['flag' => 0]);
                }

            }

        } else {
            DB::table('exchanges')
                ->update(['flag' => 0]);
        }
    }
    public function callTickerPerpage($tickerData, $value)
    {
        try {
            foreach ($tickerData['tickers'] as $key => $valueTicker) {
                if ($valueTicker['trust_score'] == 'green') {
                    $exchnageTicker = new ExchangeTicker();
                    //Check
                    $variable = [];
                    $str = $valueTicker['trade_url'];
                    if ($str) {
                        $str = stripslashes($str);
                        $variable = $ar = explode("?", $str);
                    } else {
                        $variable[0] = '';
                    }
                    $exchnageTicker->exchange = $value->name;
                    $exchnageTicker->exchange_id = $value->exchangeid;
                    $exchnageTicker->base = $valueTicker['base'];
                    $exchnageTicker->target = $valueTicker['target'];
                    $exchnageTicker->volume = $valueTicker['volume'];
                    $exchnageTicker->trade_url = $variable[0];
                    $exchnageTicker->save();
                }
            }
          
            $client2 = new CoinGeckoClient(false);
            $this->i = $this->i + 1;
            $tickerData2 = $client2->exchanges()->getTickers($value->exchangeid, ['page' => $this->i]);
            if (count($tickerData2['tickers']) > 0) {
                $this->callTickerPerpage($tickerData2, $value);
                
            } else {
                DB::table('exchanges')
                ->where('exchangeid', $value->exchangeid)
                ->update(['flag' => 1]);
                $count = Exchange::where('flag', 0)->count();
                if ($count > 0) {
                    ExchangeTickersJob::dispatch()->onQueue('moon-sniper-worker-long')->delay(30);
                }
            }
        } catch (\Throwable$th) {
            sleep(60);
            $this->callTickerPerpage($tickerData2, $value);
        }

    }
}

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

class ExchangeTickersJob implements ShouldQueue
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
        $client = new CoinGeckoClient(false);
        $tickers = Exchange::where('flag', 0)->limit(10)->get();
        if (count($tickers) > 0) {
            foreach ($tickers as $key => $value) {
                    $tickerData = $client->exchanges()->getExchange($value->exchangeid);
                    foreach ($tickerData['tickers'] as $key => $valueTicker) {
                        if ($valueTicker['trust_score'] == 'green') {
                            $exchnageTicker = new ExchangeTicker();
                            //Check
                            $variable = "";
                            $str = $valueTicker['trade_url'];
                            if ($str) {
                                $str = stripslashes($str);
                                $variable = substr($str, 0, strpos($str, "?"));
                            }
                            $exchnageTicker->exchange = $value->name;
                            $exchnageTicker->exchange_id = $value->exchangeid;
                            $exchnageTicker->base = $valueTicker['base'];
                            $exchnageTicker->target = $valueTicker['target'];
                            $exchnageTicker->volume = $valueTicker['volume'];
                            $exchnageTicker->trade_url = $variable;
                            $exchnageTicker->save();

                        }

                    }
               
                DB::table('exchanges')
                ->where('exchangeid', $value->exchangeid)
                ->update(['flag' => 1]);
    
            }
         
        } else {
            DB::table('exchanges')
                ->update(['flag' => 0]);
        }

    }
}

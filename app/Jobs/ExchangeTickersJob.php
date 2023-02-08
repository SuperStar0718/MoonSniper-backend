<?php

namespace App\Jobs;

use App\Models\Exchange;
use Illuminate\Bus\Queueable;
use App\Models\ExchangeTicker;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Libraries\CoinGecko\CoinGeckoClient;
use Illuminate\Support\Facades\Log;

class ExchangeTickersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $tickers;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($tickers)
    {
        $this->tickers = $tickers;
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = new CoinGeckoClient(false);
        if (count($this->tickers) > 0) {
            try {
                foreach ($this->tickers as $key => $value) {
                        $tickerData = $client->exchanges()->getTickers($value->exchangeid,['page'=>1]);
                        $deleteDickers = ExchangeTicker::where('exchange_id',$value->exchangeid)->delete();
                        foreach ($tickerData['tickers'] as $key => $valueTicker) {
                            if ($valueTicker['trust_score'] == 'green') {
                                $exchnageTicker = new ExchangeTicker();
                                //Check
                                $variable = [];
                                $str = $valueTicker['trade_url'];
                                if ($str) {
                                    $str = stripslashes($str);
                                    $variable = $ar = explode("?",$str);
                                }else{
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
                    DB::table('exchanges')
                    ->where('exchangeid', $value->exchangeid)
                    ->update(['flag' => 1]);


        
                }

                $count = Exchange::where('flag', 0)->count();
                if($count > 0)
                {
                    ExchangeTickersJob::dispatch()->onQueue('moon-sniper-worker-long')->delay(60);
                }
                } catch (\Throwable $th) {
                    Log::info('429 MOONERROR');
                    $count = Exchange::where('flag', 0)->count();
                    if($count > 0)
                    {
                        ExchangeTickersJob::dispatch()->onQueue('moon-sniper-worker-long')->delay(60);
                    }
                
                    }
           
            } else {
                DB::table('exchanges')
                    ->update(['flag' => 0]);
            }
    }
}

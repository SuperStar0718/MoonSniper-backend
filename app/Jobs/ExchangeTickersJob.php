<?php

namespace App\Jobs;

use as;
use App\Models\Exchange;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Libraries\CoinGecko\CoinGeckoClient;

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

        foreach ($this->tickers as $key => $value) {
           try {
            $tickerData = $client->exchanges()->getExchange($value['exchangeid']);
            foreach ($tickerData['tickers'] as $key => $valueTicker) {
                if ($valueTicker['trust_score'] == 'green') {
                 $exchnageTicker = new ExchangeTicker();
                    $variable = "";
                    $str = $valueTicker['trade_url'];
                    if ($str) {
                        $str = stripslashes($str);
                        $variable = substr($str, 0, strpos($str, "?"));
                    }
                    $exchnageTicker->exchange = $value['name'];
                    $exchnageTicker->exchange_id = $value['exchangeid'];
                    $exchnageTicker->base = $valueTicker['base'];
                    $exchnageTicker->target = $valueTicker['target'];
                    $exchnageTicker->volume = $valueTicker['volume'];
                    $exchnageTicker->trade_url = $variable;
                    $exchnageTicker->save();
                }
            }
           } catch (\Throwable $th) {
            throw $th;
           }

        }
    }
}

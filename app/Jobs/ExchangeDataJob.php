<?php

namespace App\Jobs;

use App\Models\Exchange;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Libraries\CoinGecko\CoinGeckoClient;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ExchangeDataJob implements ShouldQueue
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
        $client = new CoinGeckoClient(false);

        $exchanges =  $client->exchanges()->getList();
        $newExchanges = array();
       
        foreach ($exchanges as $key => $value) {
        //    
        if(!Exchange::where('exchangeid',$value['id'])->exists()){
            $exchange = new Exchange();
             $exchange->exchangeid =  $value['id'];
             $exchange->name =  $value['name'];
             $exchange->save();
             $newExchanges[] = $exchange;
        }
           
        }

       $chunkedData = array_chunk($newExchanges,5);
       $time  = 0;
       foreach ($chunkedData as $key => $valueChunck) {
            ExchangeTickersJob::dispatch($valueChunck)->onQueue('moon-sniper-worker')->delay($time);
            $time = $time+100;
        }

    }
}

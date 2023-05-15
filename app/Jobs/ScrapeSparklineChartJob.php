<?php

namespace App\Jobs;

use App\Models\CoinsData;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ScrapeSparklineChartJob implements ShouldQueue
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
        $t =0;
        $coinsData = CoinsData::where('coingeckoid','!=',null)->paginate(100, ['*'], 'page', 1);
        $page  = $coinsData->lastPage();
        $p = 0;
        for ($i=1; $i <=$page ; $i++) { 
            $coins = CoinsData::where('coingeckoid','!=',null)->select('coingeckoid')->orderBy('market_cap','DESC')->paginate(100, ['*'], 'page', $i)->toArray();
              $box = [];
              foreach ($coins['data'] as $key => $value) {
                $box[] =$value['coingeckoid'];
              }
              $chunks =  array_chunk($box,20);
                foreach ($chunks as $key => $chunkVal) {
                    $job = (new SparklineSaveJob($chunkVal))->onQueue('moon-sniper-worker-long')->delay($t);
                    dispatch($job);
                    $t = $t+60;
                }
             
                // sleep(60);
               
        }
    }
}

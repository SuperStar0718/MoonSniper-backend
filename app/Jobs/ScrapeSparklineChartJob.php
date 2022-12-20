<?php

namespace App\Jobs;

use App\Models\CoinsData;
use Illuminate\Bus\Queueable;
use App\Jobs\ScrapeSparklineChartJob;
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
            $coins = CoinsData::where('coingeckoid','!=',null)->select('coingeckoid')->paginate(100, ['*'], 'page', $i)->toArray();
              $box = [];
              foreach ($coins['data'] as $key => $value) {
                $box[] =$value['coingeckoid'];
              }
              $chunks =  array_chunk($box,10);

             foreach ($chunks as $key => $chunkVal) {
                $job = (new SparklineSaveJob($chunkVal))->onQueue('moon-sniper-worker-long')->delay($t);
                $t+60;
             }
             
                sleep(60);
               
        }
    }
}

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
        $coins = CoinsData::where('coingeckoid','!=',null)->pluck('coingeckoid')->toArray();
        $chunks =  array_chunk($coins,50);
        $i = 0;
        $t=0;
        foreach ($chunks as $key => $value) {
            $job = (new SparklineSaveJob($value))->onQueue('moon-sniper-worker-long')->delay(now()->addseconds($t));
            dispatch($job);
            $t=$t+50;
            $i = $i+1;
            if($i == 10)
            {
             sleep(60);
             $i = 0;
            }
       }
    }
}

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
        $coins = CoinsData::where('coingeckoid','!=',null)->select('coin_id','symbol','coingeckoid')->get();
           foreach ($coins as $key => $coin) {
             $html = file_get_contents('https://www.coingecko.com/coins/'.$coin->coingeckoid.'/sparkline');
             Storage::put('public/sparklineimage/sparkline_'.$coin->coingeckoid.'.svg', $html);
         
        }
    }
}

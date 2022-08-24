<?php

namespace App\Jobs;

use App\Models\Dashboard;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GetFearAndGreedIndexJob implements ShouldQueue
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
        $fgi =  json_decode($this->getFgi("https://api.alternative.me/fng/?limit=14"),true); // text
        $fear_greed_index=$fgi['data'][0]['value'];
        $fear_greed_classification=$fgi['data'][0]['value_classification'];

        $fear_greed_history = json_encode($fgi['data']);

        // 0 <-> 24 Extreme Fear
        //25 <-> 39 Fear
        //40 <-> 54 Natural
        //55 <-> 74 Greed
        //75 <-> 100 Extreme Greed

        if($fear_greed_index < 100 && $fear_greed_index > 0) {
            Dashboard::updateOrCreate(['id' => 1],
                ['fear_greed_index' => $fear_greed_index, 'fear_greed_classification' => $fear_greed_classification, 'fear_greed_history' => $fear_greed_history]
            );
        }
    }

    public function getFgi($url){
        //Get Twitter account
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}

<?php

namespace App\Jobs;

use App\Models\Dashboard;
use DOMDocument;
use DOMXPath;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GetGlobalMarketDataJob implements ShouldQueue
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
        // BTC-ETH Dominance, 24h VOL, MARKET CAP
        $content = file_get_contents("https://www.coingecko.com/en/overall_stats");
        $doc2 = new DOMDocument();
        @$doc2->loadHTML($content);

        $xpath = new DOMXPath($doc2);
        $node = $xpath->query('/html/body/div/div[3]/a/span[1]')->item(0);
        $market_cap =  trim($node->textContent); // text

        $xpath = new DOMXPath($doc2);
        $node = $xpath->query('/html/body/div/div[4]/a/span')->item(0);
        $vol_24h =  trim($node->textContent); // text

        $xpath = new DOMXPath($doc2);
        $node = $xpath->query('/html/body/div/div[6]/a/span')->item(0);
        $btc_dom =  trim($node->textContent); // text

        $xpath = new DOMXPath($doc2);
        $node = $xpath->query('/html/body/div/div[7]/a/span')->item(0);
        $eth_dom =  trim($node->textContent); // text


            Dashboard::updateOrCreate([
                'id'   => 1],
                ['market_cap' => $market_cap, 'vol_24h' => $vol_24h, 'btc_dom' => $btc_dom, 'eth_dom' => $eth_dom]
            );

    }
}

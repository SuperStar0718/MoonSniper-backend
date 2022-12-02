<?php

namespace App\Jobs;

use DOMXPath;
use DOMDocument;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class GetIdForCoinDataJob implements ShouldQueue
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
    Log::info("Coin id scraping");
        $html = file_get_contents('https://www.coingecko.com/?page=1');
        $pagination = $this->getBetween($html, '<ul class="pagination">', '</ul>');
        $docPage = new DOMDocument();
        $docPage->loadHTML($pagination);
        $xpath = new DOMXPath($docPage);
        $query = "//a";
        $entriesPage = $xpath->query($query);
       $totalPages =  $entriesPage[count($entriesPage)-2]->textContent;
       $i=0;
        for ($i=1; $i <= $totalPages ; $i++) { 
            $job = (new coinIdDataScrapingJob($i))->onQueue('moon-sniper-worker')->delay(now()->addseconds($i));
            $i=$i+5;
            dispatch($job);
        }
      
    }
    public static function getBetween($content, $start, $end)
    {
        $r = explode($start, $content);
        if (isset($r[1])) {
            $r = explode($end, $r[1]);
            return $r[0];
        }
        return '';
    }
}

<?php

namespace App\Jobs;

use DOMXPath;
use DOMDocument;
use App\Models\Dashboard;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class CoinSeasonDataJob implements ShouldQueue
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
        $html = file_get_contents('https://www.blockchaincenter.net/altcoin-season-index/');
        $numberDiv = $this->getBetween($html, '<div style="margin-top:-74px">', '</div>');
        $chartData = $this->getBetween($html, 'chartdata2[30] =', ';');
        $docPage = new DOMDocument();
        $docPage->loadHTML($numberDiv);
        $xpath = new DOMXPath($docPage);
        $query = "//div";
        $num = $xpath->query($query);
        $seasonval =   $num[0]->textContent;
         $dashboard = Dashboard::first();
         if($dashboard)
         {
            $dashboard->coinseason =   $seasonval;
            $dashboard->coin_season_history =  json_decode($chartData);
            $dashboard->save();
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

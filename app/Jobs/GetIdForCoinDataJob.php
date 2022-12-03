<?php

namespace App\Jobs;

use DOMXPath;
use DOMDocument;
use App\Models\CoinsData;
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
        $html = file_get_contents('https://www.coingecko.com/?page=1');
        $pagination = $this->getBetween($html, '<ul class="pagination">', '</ul>');
        $docPage = new DOMDocument();
        $docPage->loadHTML($pagination);
        $xpath = new DOMXPath($docPage);
        $query = "//a";
        $entriesPage = $xpath->query($query);
        $totalPages =  $entriesPage[count($entriesPage)-2]->textContent;
        for ($j=1; $j <= $totalPages ; $j++) { 
            $html = file_get_contents('https://www.coingecko.com/?page='.$j.'');
            $data = $this->getBetween($html, '<tbody', '</tbody>');
            $doc = new DOMDocument();
            $doc->loadHTML($data);
            $xpath = new DOMXPath($doc);
            $query = "//i";
            $entries = $xpath->query($query);
            $items = array();
            foreach ($entries as $key => $entry) {
                $items2 = array(
                    'coingeckoid'=>$entry->getAttribute("data-coin-id"),
                );
                
                try {
                    $exist = CoinsData::where('symbol',$entry->getAttribute("data-coin-symbol"))->first();
                    if($exist)
                    {
                        $coinData  = CoinsData::where('symbol',$entry->getAttribute("data-coin-symbol"))->update($items2);

                    }else{
                        $coinData  = CoinsData::where('coin_id',$entry->getAttribute("data-coin-slug"))->update($items2);

                    }
                } catch (\Throwable $th) {
                    $coinData  = CoinsData::where('symbol',$entry->getAttribute("data-coin-symbol"))->orWhere('coin_id',$entry->getAttribute("data-coin-slug"))->update($items2);
                }

                // $items[] = $items2;
            }
           
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

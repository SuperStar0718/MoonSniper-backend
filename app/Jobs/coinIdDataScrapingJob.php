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

class coinIdDataScrapingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $pageno;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($pn)
    {
        $this->pageno = $pn;
    }

   
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       
       
            $html = file_get_contents('https://www.coingecko.com/?page='.$this->pageno.'');
            $data = $this->getBetween($html, '<tbody', '</tbody>');
            $doc = new DOMDocument();
            $doc->loadHTML($data);
            $xpath = new DOMXPath($doc);
            $query = "//i";
            $entries = $xpath->query($query);
            $items = array();
            foreach ($entries as $key => $entry) {
                $items2 = array(
                    'uniqueid'=>$entry->getAttribute("data-coin-id"),
                    'coin_id'=>$entry->getAttribute("data-coin-slug"),
                    'symbol'=>$entry->getAttribute("data-coin-symbol"),
                );
                $items[] = $items2;
            }
            try {
                CoinsData::massUpdate(
                    values: $items,
                    uniqueBy: ['symbol'],
                );
            }catch (\Exception $exception){
                Log::info("The Problem here is: ".$exception);
            }
      
        return $items;
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

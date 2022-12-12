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
        $updated =[];

        for ($j=1; $j <= $totalPages ; $j++) { 
            $html = file_get_contents('https://www.coingecko.com/?page='.$j.'');
            $data = $this->getBetween($html, '<tbody', '</tbody>');
            $doc = new DOMDocument();
            $doc->loadHTML($data);
            $thirdTable = $doc->getElementsByTagName('tr');
            $items1 = array();

            foreach($thirdTable as $tr)
            {
                $items2 = [];
                
               $is = $tr->getElementsByTagName('i');
               $items2[] = $is[0]->getAttribute('data-coin-symbol'); 
               $items2[] = $is[0]->getAttribute('data-coin-id'); 
               $items2[] = $is[0]->getAttribute('data-coin-slug'); 
               $divs = $tr->getElementsByTagName('div'); // get the columns in this row
               $apisym = $divs[6]->getAttribute('data-api-symbol'); 
               $qry = array(
                    'coingeckoid'=>$items2[1],
                );
               if($apisym !="")
               {
                $items2[] = $apisym;
               }
               $items1[] = $items2; 
               if(count($items2)>=4)
               {
                      $exist = CoinsData::where('coin_id',$items2[3])->whereNotIn('id',$updated)->orderBy('market_cap','DESC')->first();
                       if($exist)
                       {
                           $coinData = CoinsData::where('coin_id',$items2[3])->whereNotIn('id',$updated)->orderBy('market_cap','DESC')->first()->update($qry);
                            $updated[] = $exist->id;
                       }
                 
               
               }else{
                  $exist = CoinsData::where('symbol',$items2[0])->whereNotIn('id',$updated)->orderBy('market_cap','DESC')->first();
                   if($exist)
                   {
                       $coinData = CoinsData::where('symbol',$items2[0])->whereNotIn('id',$updated)->orderBy('market_cap','DESC')->first()->update($qry);
                       $updated[] = $exist->id;
                   }else{
                      $exist = CoinsData::where('coin_id',$items2[2])->whereNotIn('id',$updated)->orderBy('market_cap','DESC')->first();
                      if($exist)
                      {
                          $coinData = CoinsData::where('coin_id',$items2[2])->whereNotIn('id',$updated)->orderBy('market_cap','DESC')->first()->update($qry);
                          $updated[] = $exist->id;
                      }

                   }
               }
               
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

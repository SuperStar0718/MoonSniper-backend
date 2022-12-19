<?php

namespace App\Jobs;

use DOMXPath;
use DOMDocument;
use App\Models\ContractIcon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ContractIconsScrapeJob implements ShouldQueue
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
        $html = file_get_contents('https://chainlist.org/');
        $data = $this->getBetween($html, '<body>', '</body>');
        libxml_use_internal_errors(true);
        $docPage = new DOMDocument();
        $docPage->loadHTML($data);
        $xpath = new DOMXPath($docPage);
        $nodes = $xpath->query('//div[@class="shadow bg-white p-8 pb-0 rounded-[10px] flex flex-col gap-3 overflow-hidden"]');
        $tmp_dom = new DOMDocument();
        foreach ($nodes as $node) {
           $name = $node->getElementsByTagName('a');
           $icons = $node->getElementsByTagName("img");
                  $valUrl= $icons[0]->getAttribute("src");
                  $oUrl = 'https://chainlist.org'.$valUrl;
                  $valName= $name[0]->nodeValue;
                  $table = $node->getElementsByTagName("td");
                  $valChainId= $table[0]->nodeValue;
                  $val= $table[1]->nodeValue;
                    $fileName = str_replace(" ","-",$valName);
                    $contents = file_get_contents($oUrl);
                    Storage::put('public/contracticons/'.$fileName.'.jpg', $contents);
                      asset('/storage/contracticons/' .$fileName.'.jpg');
                    $conIcon = new ContractIcon();
                    $conIcon->contract_type = $valName;
                    $conIcon->icon =  asset('/storage/contracticons/' .$fileName.'.jpg');
                    $conIcon->url = $oUrl;
                    $conIcon->save();
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

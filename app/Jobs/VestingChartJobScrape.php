<?php

namespace App\Jobs;

use App\Models\CoinsData;
use App\Models\CoinsList;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class VestingChartJobScrape implements ShouldQueue
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
        $jsonData = file_get_contents('https://token.unlocks.app/');
        $data = $this->getBetween($jsonData, 'type="application/json">', '</script>');
        $data1 = json_decode($data);
        $data1->props->pageProps->info->data;
        $array = [];
        foreach ($data1->props->pageProps->info->data as $key => $value) {
            $coin = CoinsList::where('name', $value->token->name)->where('coins.symbol', $value->token->symbol)
                ->first();

            if ($coin ) {
                $coinData = CoinsData::where('coin_id', $coin->coin_id)->first();
                if($coinData &&  $coinData->vesting_status == 0)
                {
                $result =  json_decode($this->getChartDetails("https://token.unlocks.app/api/chart/".$coin->coin_id.""));
                if($result && isset($result->data))
                {
                        $array[]= $coinData->vesting_chart = $result->data->data;
                        $coinData->vesting_status = 1;
                        $coinData->save();
                    }
                //   return $result->data->data;
               }
            }

        }
       
        return $array;
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
    public function getChartDetails($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
            'accept-language: en-US,en;q=0.9,gu;q=0.8,zh-CN;q=0.7,zh;q=0.6,te;q=0.5',
            'cache-control: max-age=0',
            'cookie: _ga=GA1.1.198816369.1666948558; _hjSessionUser_3057115=eyJpZCI6IjRhMzNkYWVkLWFmZmMtNTdkZi04Mjg0LTcwZDAyNjM0ODlhMiIsImNyZWF0ZWQiOjE2NjY5NDg1NTgxMDgsImV4aXN0aW5nIjp0cnVlfQ==; _hjSession_3057115=eyJpZCI6ImVmNjc3ZGNjLWE0ZjEtNGQ1YS04MzgxLWMxNTNlN2NjZGVhNyIsImNyZWF0ZWQiOjE2NjcyODIwNzg5MDUsImluU2FtcGxlIjpmYWxzZX0=; _hjAbsoluteSessionInProgress=0; _hjIncludedInSessionSample=0; csrfSecret=5r6LUd9a-iXsrpe0HimUmksLRS0wdjNsNnaw.iWfA9P87zb8HbR%252Fo0NGHOKsPXqLD7BAgtl7RScYy4LE; amp_46195f=ovvAh7Wzz3MabEYXZm9fAN...1ggos792c.1ggouroei.1f.0.1f; _ga_75CFN3DMPM=GS1.1.1667282078.10.1.1667284985.52.0.0; uNchBAnD=oAuW6l4u-6mWSRVkJLou4zG7Z35xzV_OOG-0.vCOnwC%2BO0fGkxw3ILHbKmlW5FF8hhYMnwv%2FlKSqufjM',
            'if-none-match: W/"3bgljgn2u32ujh"',
            'sec-ch-ua: "Chromium";v="106", "Google Chrome";v="106", "Not;A=Brand";v="99"',
            'sec-ch-ua-mobile: ?0',
            // 'sec-ch-ua-platform: "Windows"',
            'sec-fetch-dest: document',
            'sec-fetch-mode: navigate',
            'sec-fetch-site: none',
            'sec-fetch-user: ?1',
            'upgrade-insecure-requests: 1',
            'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Safari/537.36',
        ));
        return $str = curl_exec($curl);


    }
}

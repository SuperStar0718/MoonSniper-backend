<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\CoinsData;
use Atymic\Twitter\Twitter;
use Illuminate\Support\Facades\Log;

class GetTwitterDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $tweet;
    private $id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($tweet,$id)
    {
        $this->tweet = $tweet;
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        //Get Twitter account
        $account = $this->get_string_between($this->tweet,'m/','?');

        $authorization = "Authorization: Bearer AAAAAAAAAAAAAAAAAAAAAH1OaAEAAAAAKvOgHIRmgKym7Fc%2BtStfa%2FeauDU%3DGOSMJhVW2Vyen3FSNg9gbqRBoVXFB9u0okiNeopeliAHP1Q256";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, "https://api.twitter.com/2/users/by/username/$account?user.fields=public_metrics");
        $result = curl_exec($ch);
        curl_close($ch);
        if (is_string($result)) {
            if(!isset(json_decode($result)->errors)) {
                try {
                    CoinsData::where('coin_id', $this->id)
                        ->update(['twitter_followers' => json_decode($result)->data->public_metrics->followers_count]);
                }catch (\Exception $exception){
                    Log::error("Cant push twitter followers, result is: $result here is the exception: $exception");
                }

            }
        }
    }

    private function get_string_between($string, $start, $end): string
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);

        $len = strpos($string, $end, $ini) - $ini;
        if (strpos($string, '?') == false) {
            return substr(rtrim($string, '/'), $ini);
        }else{
            return rtrim(substr($string, $ini, $len), '/');
        }

    }
}

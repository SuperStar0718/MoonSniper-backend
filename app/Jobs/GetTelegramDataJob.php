<?php

namespace App\Jobs;

use App\Models\CoinsData;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GetTelegramDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $group;
    private $id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($group,$id)
    {
        $this->group = $group;
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
        $account = $this->get_string_between($this->group,'t.me/','?');
        Log::info("Starting get Telegram members for: $account (coin id is: $this->id)");

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot5215775282:AAHOymx_4azRdPBiiHdAThn9eemTWWaKXSY/getChatMembersCount?chat_id=@$account");
        $result = curl_exec($ch);
        curl_close($ch);
        if (is_string($result)) {
            if(isset(json_decode($result)->ok)) {
                try {
                    CoinsData::where('coin_id', $this->id)
                        ->update(['telegram_members' => json_decode($result)->result]);
                }catch (\Exception $exception){
                    Log::error("Cant push telegram followers, result is: $result here is the exception: $exception");
                }

            }else{
                Log::info("cant find members for: $account, result is: $result");
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

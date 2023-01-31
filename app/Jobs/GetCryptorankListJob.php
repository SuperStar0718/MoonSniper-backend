<?php

namespace App\Jobs;

use App\Http\Controllers\Cryptorank;
use App\Models\CoinsList;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GetCryptorankListJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $offset;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($offset)
    {
        $this->offset = $offset;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $coinsList = Cryptorank::getAllAssets(["offset"=>$this->offset,"limit" => 1000, "optionalFields" => "links"]);
        $coinsList = $coinsList['data'];

        foreach($coinsList as $coin_data) {
            $match = ['symbol' => $coin_data['symbol'], 'name' => $coin_data['name']];

            $existing_links = CoinsList::where($match)->get()->first();


            if(!is_null($existing_links)){
            if($existing_links->count()) {
                foreach ($coin_data['links'] as $link) {
                    switch ($link['type']) {
                        case 'telegram':
                            $existing_links->telegram = $link['value'];
                            break;
                        case 'web':
                            $existing_links->website = $link['value'];
                            break;
                        case 'twitter':
                            $existing_links->twitter = $link['value'];
                            break;
                        case 'reddit':
                            $existing_links->reddit = $link['value'];
                            break;
                        case 'whitepaper':
                            $existing_links->whitepaper = $link['value'];
                            break;
                        case 'medium':
                            $existing_links->medium = $link['value'];
                            break;
                        case 'github':
                            $existing_links->github = $link['value'];
                            break;
                        case 'discord':
                            $existing_links->discord = $link['value'];
                            break;
                    }
                }
                $existing_links->save();
            }
            }
        }

    }
}

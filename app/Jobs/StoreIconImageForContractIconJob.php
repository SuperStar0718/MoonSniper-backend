<?php

namespace App\Jobs;

use Exception;
use GuzzleHttp\Client;
use App\Models\CoinsList;
use App\Models\ContractIcon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class StoreIconImageForContractIconJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $chunk;
    public function __construct($chunk)
    {
        $this->chunk = $chunk;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->chunk as $key => $value) {
            $coinImage = CoinsList::leftJoin('coin_data', 'coins.symbol', '=', 'coin_data.symbol')
                ->Where('coins.coin_id', 'like', '%' . $value->platform . '%')
                ->select('coin_data.image')->first();
            $iconname = '';
            if ($coinImage) {
                $coinImage->image;
                $extension = pathinfo(parse_url($coinImage->image, PHP_URL_PATH), PATHINFO_EXTENSION);
                $client = new Client();
               try{
                $response = $client->get($coinImage->image);
                $html = $response->getBody();
                $iconname = $value->platform . '.' . $extension;
                Storage::put('public/contracts/' . $iconname, $html);
               }catch(Exception $e){
               }
            }
            $inertArray = array(
                'platform' => $value->platform,
                'icon' => $iconname,
            );
                $inertbleArray[] = $inertArray;

        }
        try {
            ContractIcon::insert(
                $inertbleArray
            );
        } catch (\Exception $exception) {
          return $exception;
        }
    }
}

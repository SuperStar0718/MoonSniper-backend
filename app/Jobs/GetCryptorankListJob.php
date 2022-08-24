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
        $coinsList = Cryptorank::getAllAssets(["offset"=>$this->offset,"limit" => 1000]);
        $coinsList = collect($coinsList);

        $newCoinsArray = array();
        $newCoinsIds = array();
        //get all coins (to make sure we can update them):
        foreach ($coinsList['data'] as $item){
            if(!empty($item['id'])) {
                $newCoinsArray[] = array(
                    'symbol' => strtoupper($item['symbol']),
                    'coin_category' => $item['category'] ?? NULL
                );
                //$newCoinsIds[] = $item['symbol'];
            }
        }


        // first get symbol ids from table
        //$exist_ids = CoinsList::all('symbol')->pluck('symbol')->toArray();

        // get updatable ids//$updatable_ids = array_values(array_intersect($exist_ids, $newCoinsIds));

        // get insertable ids
        //$insertable_ids = array_filter(array_values(array_diff($newCoinsIds, $exist_ids)));
        // prepare data for insert
        //$data = collect();

        //check for symbol duplications, if we do, lets get rid of the lower rank:
        /*$duplicates = array();
        foreach(array_count_values($newCoinsIds) as $val => $c)
            if($c > 1) $duplicates[] = $val;

        $skip=[];*/
        //Push new coins (if any):
        /*foreach ($insertable_ids as $key => $coinId) {
            if(!in_array(strtoupper($coinsList['data'][$key]['symbol']),$skip)) {
                $data->push([
                    'coin_id' => $coinsList['data'][$key]['slug'],
                    'symbol' => strtoupper($coinsList['data'][$key]['symbol']),
                    'name' => $coinsList['data'][$key]['name'],
                    'coin_category' => $coinsList['data'][$key]['category'] ?? NULL,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            if(in_array(strtoupper($coinsList['data'][$key]['symbol']),$duplicates)){
                $skip[] = strtoupper($coinsList['data'][$key]['symbol']);
            }
        }*/

        //first add all needed new items to db:
        //$this->tryPushingToDB($data->toArray());

        CoinsList::massUpdate(
            values : $newCoinsArray,
            uniqueBy : 'symbol'
        );

    }


    private function tryPushingToDB($arr,$iterates=0){
            try {
                //if there is a duplication order id from any reason, continue...
                CoinsList::insert($arr);
                //Log::info("Finance Data has Pushed");
            } catch
            (\Exception $e) {
                //Log should be added here
                Log::info('PROBLEM:' . $e);

                Log::info('Trying Again!');

                if ($iterates < 20) {
                    //Check what is happening?

                    $iterates++;
                    //Call again:
                    $this->tryPushingToDB($arr,$iterates);
                } else {
                    Log::info('Im giving up :(');
                }

            }
    }
}

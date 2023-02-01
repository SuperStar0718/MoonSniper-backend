<?php

namespace App\Jobs;

use App\Models\CoinsData;
use App\Models\CoinsList;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Jobs\StoreIconImageForContractIconJob;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class GenerateUniqueContractsJob implements ShouldQueue
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
        $coins = CoinsList::select('contract_address')->get();
        $ContractArray = array();
        foreach ($coins as $key => $value) {
            if ($value->contract_address) {
                $newArray = json_decode($value->contract_address);
                $ContractArray = array_merge($ContractArray, $newArray);
            }
        }
        $filtered = array_intersect_key($ContractArray, array_unique(array_column($ContractArray, 'platform')));
        $chunks =  array_chunk($filtered,10);
        $t = 0;
        foreach ($chunks as $key => $chunk) {
            $job = (new StoreIconImageForContractIconJob($chunk))->onQueue('moon-sniper-worker')->delay(now()->addseconds($t));
            $t = $t+60;
            dispatch($job);
        }
    }
}

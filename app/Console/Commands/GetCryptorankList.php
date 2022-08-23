<?php

namespace App\Console\Commands;

use App\Http\Controllers\Cryptorank;
use App\Jobs\GetCryptorankListJob;
use Illuminate\Console\Command;

class GetCryptorankList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'moon:crypto_list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
            $coinsList = Cryptorank::getAllAssets(["offset"=>0,"limit" => 100000]);
            $countCoins= count($coinsList['data']);

            for($offset = 0; $offset < $countCoins; $offset +=1000) {
                    $job = (new GetCryptorankListJob($offset))->onQueue('moon-sniper-worker');
                    dispatch($job);
            }

        return true;
    }
}

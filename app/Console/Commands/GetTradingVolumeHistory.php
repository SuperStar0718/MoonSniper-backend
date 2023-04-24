<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\GetTradingVolumeHistoryJob;
use App\Models\TradingVolumeHistory;
use App\Models\CoinsList;
use Illuminate\Support\Facades\Log;

class GetTradingVolumeHistory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'moon:trading_volume_history';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Trading Volume History from CoinGecko API';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Only Get Trading Volume History for the coins with flag set to true
        $coins = CoinsList::where("trading_history_flag", true)->get();
        // $coins = CoinsList::get();
        foreach($coins as $c)
        {
            $job = (new GetTradingVolumeHistoryJob($c->coin_id, $c->symbol))->onQueue('moon-sniper-worker');
            dispatch($job);
        }
        return true;
      
    }
}

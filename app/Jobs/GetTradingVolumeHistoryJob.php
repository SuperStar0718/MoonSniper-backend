<?php

namespace App\Jobs;

use App\Models\TradingVolumeHistory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GetTradingVolumeHistoryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $symbol;
    private $coin_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($coin_id, $symbol)
    {
        $this->symbol = $symbol;
        $this->coin_id = $coin_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Retrieve Trading Volume History in JSON (Last 3 months, hourly interval)
        $url = 'https://api.coingecko.com/api/v3/coins/'.$this->coin_id.'/market_chart?vs_currency=usd&days=90&interval=hour';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL,$url);
        $json_history_response = curl_exec($ch);
        curl_close($ch);


        // Update/Create Record
        TradingVolumeHistory::updateOrCreate(
            ['coin_id' => $this->coin_id, 'symbol' => $this->symbol],
            ['trading_volume_history_json' => $json_history_response]

        );

    
    }
}

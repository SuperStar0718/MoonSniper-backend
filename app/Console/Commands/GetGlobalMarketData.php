<?php

namespace App\Console\Commands;

use App\Jobs\GetGlobalMarketDataJob;
use Illuminate\Console\Command;

class GetGlobalMarketData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'moon:global';

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
        $job = (new GetGlobalMarketDataJob())->onQueue('moon-sniper-worker');
        dispatch($job);
    }
}

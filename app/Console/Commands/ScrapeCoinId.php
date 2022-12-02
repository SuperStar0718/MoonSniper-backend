<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\GetIdForCoinDataJob;
use App\Jobs\coinIdDataScrapingJob;

class ScrapeCoinId extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'moon:scrapecoinid';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command Scrape Coin Id';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        GetIdForCoinDataJob::dispatch()->onQueue('moon-sniper-worker-long');
        return Command::SUCCESS;
    }
}

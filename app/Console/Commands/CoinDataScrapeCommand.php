<?php

namespace App\Console\Commands;

use App\Jobs\CoinDataScrapJob;
use App\Jobs\CoinUnlockDataScrapJob;
use Illuminate\Console\Command;

class CoinDataScrapeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coin:scrape_unlock_data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'scraping data';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        CoinUnlockDataScrapJob::dispatch()->onQueue('moon-sniper-worker');
        return Command::SUCCESS;
    }
}

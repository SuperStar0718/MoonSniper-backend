<?php

namespace App\Console\Commands;

use App\Jobs\coinIdDataScrapingJob;
use Illuminate\Console\Command;

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
        coinIdDataScrapingJob::dispatch()->onQueue('moon-sniper-worker');
        return Command::SUCCESS;
    }
}

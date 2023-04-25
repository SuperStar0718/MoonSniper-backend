<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\VestingChartJobScrape;

class ScrapeVestingChartData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coin:scrape_vestintg_data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape vestintg data';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        VestingChartJobScrape::dispatch()->onQueue('moon-sniper-worker-long');
        return Command::SUCCESS;
    }
}

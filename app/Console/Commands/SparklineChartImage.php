<?php

namespace App\Console\Commands;

use App\Jobs\ScrapeSparklineChartJob;
use Illuminate\Console\Command;

class SparklineChartImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'moon:sparklineimage';

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
        ScrapeSparklineChartJob::dispatch()->onQueue('moon-sniper-worker-long');
        return Command::SUCCESS;
    }
}

<?php

namespace App\Console\Commands;

use App\Jobs\CoinSeasonDataJob;
use Illuminate\Console\Command;

class CoinSeasonData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'moon:coinseasondata';

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
        CoinSeasonDataJob::dispatch()->onQueue('moon-sniper-worker');
        return Command::SUCCESS;
    }
}

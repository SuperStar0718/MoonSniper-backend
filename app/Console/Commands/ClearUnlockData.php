<?php

namespace App\Console\Commands;

use App\Jobs\ClearUnlockDataJob;
use Illuminate\Console\Command;

class ClearUnlockData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'moon:clearunlockdata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleared unlock data';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        ClearUnlockDataJob::dispatch()->onQueue('moon-sniper-worker');
        return Command::SUCCESS;
    }
}

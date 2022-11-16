<?php

namespace App\Console\Commands;

use App\Jobs\ExchangeDataJob;
use Illuminate\Console\Command;

class ExchangesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'moon:exchanges';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Exchange Data';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        ExchangeDataJob::dispatch()->onQueue('moon-sniper-worker');
        return Command::SUCCESS;
    }
}

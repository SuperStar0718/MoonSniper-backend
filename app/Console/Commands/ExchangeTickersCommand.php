<?php

namespace App\Console\Commands;

use App\Jobs\ExchangeTickersJob;
use Illuminate\Console\Command;

class ExchangeTickersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'moon:exchangestickers';

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
        ExchangeTickersJob::dispatch()->onQueue('moon-sniper-worker');
        return Command::SUCCESS;
    }
}

<?php

namespace App\Console\Commands;

use App\Jobs\GetCryptorankRIOJob;
use Illuminate\Console\Command;

class GetCryptorankRIO extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'moon:getcryptoROI';

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
        GetCryptorankRIOJob::dispatch()->onQueue('moon-sniper-worker');
        return Command::SUCCESS;
    }
}

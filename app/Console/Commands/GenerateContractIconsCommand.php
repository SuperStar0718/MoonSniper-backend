<?php

namespace App\Console\Commands;

use App\Jobs\GenerateUniqueContractsJob;
use Illuminate\Console\Command;
use App\Jobs\GetCoinsListJob;

class GenerateContractIconsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'moon:generatecontracticons';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Contract icons generated';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $job = (new GenerateUniqueContractsJob())->onQueue('moon-sniper-worker');
        dispatch($job);
    }
}

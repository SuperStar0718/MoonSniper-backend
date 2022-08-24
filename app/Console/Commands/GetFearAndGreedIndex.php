<?php

namespace App\Console\Commands;

use App\Jobs\GetFearAndGreedIndexJob;
use Illuminate\Console\Command;
use App\Models\Dashboard;
use Illuminate\Support\Facades\Log;

class GetFearAndGreedIndex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'moon:fear-greed';

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
        $job = (new GetFearAndGreedIndexJob())->onQueue('moon-sniper-worker');
        dispatch($job);

        return true;
    }


}

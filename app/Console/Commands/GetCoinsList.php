<?php

namespace App\Console\Commands;

use App\Jobs\GetCoinsListJob;
use Illuminate\Console\Command;

class GetCoinsList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'moon:coins_list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $job = (new GetCoinsListJob())->onQueue('moon-sniper-worker-long');
        dispatch($job);
        return true;
    }
}

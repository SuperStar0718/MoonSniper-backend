<?php

namespace App\Console\Commands;

use App\Models\CoinsList;
use App\Jobs\GetCoinsLinksJob;
use Illuminate\Console\Command;

class GetCoinsLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'moon:coins_links';

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
        $coins = ceil(CoinsList::count()/500);

        for ($i=0;$i<=$coins;$i++){
            $job = (new GetCoinsLinksJob($i+1))->onQueue('moon-sniper-worker');
            dispatch($job);
        }
    }
}

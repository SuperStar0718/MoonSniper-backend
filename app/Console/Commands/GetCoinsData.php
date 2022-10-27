<?php

namespace App\Console\Commands;

use App\Jobs\GetCoinsDataJob;
use App\Models\CoinsList;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GetCoinsData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'moon:coins_data';

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
        Log::info("GetCoinsDataNow");
        $i=0;
        for($pageno = 1; $pageno < (CoinsList::count()/250)+1; $pageno ++)
        {
            $job = (new GetCoinsDataJob($pageno))->onQueue('moon-sniper-worker')->delay(now()->addseconds($i));
            $i=$i+5;
            dispatch($job);
        }

        return 0;
    }
}

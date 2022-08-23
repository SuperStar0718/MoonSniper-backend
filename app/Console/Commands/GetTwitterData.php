<?php

namespace App\Console\Commands;

use App\Models\CoinsList;
use App\Jobs\GetTwitterDataJob;

use Illuminate\Console\Command;

class GetTwitterData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'moon:twitter';

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
        //Get followers for Twitter:

        //First, lets read all accounts:
        //

        $twitter_list = CoinsList::all('twitter','coin_id')->whereNotNull('twitter')->pluck('twitter','coin_id');

        $i=1;

        foreach ($twitter_list as $id => $tweet){
            $job = (new GetTwitterDataJob($tweet,$id))->onQueue('moon-sniper-worker')->delay(now()->addseconds($i));
            dispatch($job);

            $i=$i+5;
        }

        }






}

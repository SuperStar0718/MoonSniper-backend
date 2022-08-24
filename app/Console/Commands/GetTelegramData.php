<?php

namespace App\Console\Commands;

use App\Jobs\GetTelegramDataJob;
use App\Models\CoinsList;
use Illuminate\Console\Command;

class GetTelegramData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'moon:telegram';

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
        $telegram_list = CoinsList::all('telegram','coin_id')->whereNotNull('telegram')->pluck('telegram','coin_id');

        $i=1;

        foreach ($telegram_list as $id => $group){
            if(str_contains($group, 't.me') && !str_contains($group, 'joinchat/')) {
                $job = (new GetTelegramDataJob($group, $id))->onQueue('moon-sniper-worker')->delay(now()->addseconds($i));
                dispatch($job);
                $i=$i+5;
            }
        }
    }
}

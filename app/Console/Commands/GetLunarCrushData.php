<?php

namespace App\Console\Commands;

use App\Jobs\GetLunarCrushDataJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GetLunarCrushData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'moon:lunarcrush';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Queries LunarCrush API for coin data.';

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
        $job = (new GetLunarCrushDataJob())->onQueue('moon-sniper-worker');

        dispatch($job);
    }
}

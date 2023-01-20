<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\CoinsData;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ClearUnlockDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $clearUnlock =  CoinsData::where('next_unlock_date', '<', Carbon::now())
        ->update([
            'next_unlock_date' => null,
            'next_unlock_date_text' => null,
            'total_locked_percent' => null,
            'next_unlock_percent' => null,
            'next_unlock_number_of_tokens' => null,
            'next_unlock_percent_of_tokens' => null,
            'next_unlock_size' => null,
            'end_vc_unlock' => null,
            'first_vc_unlock_text' => null,
            'end_vc_unlock_text' => null,
            'three_months_unlock_number_of_tokens' => null,
            'three_months_unlock_percent_of_tokens' => null,
            'three_months_unlock_size' => null,
            'six_months_unlock_number_of_tokens' => null,
            'six_months_unlock_percent_of_tokens' => null,
            'six_months_unlock_size' => null,
            ]);
    }
}

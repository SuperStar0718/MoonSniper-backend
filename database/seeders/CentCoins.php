<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CentCoins extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('preset_filters')->insert([
            'preset_name' => 'Cent Coins',
            'filter_json' => '{"filters":[["current_price","<=","1"]],"filters2":"","filter_name":"Cent Coins2"}',
            'default'=>'1',
            'user_id'=>'1',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        ]);
    }
}

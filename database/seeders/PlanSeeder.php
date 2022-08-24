<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    public function run()
    {
        DB::table('plans')->insert([
            'label' => 'Basic',
            'value'=>'basic',
           
        ]);
        DB::table('plans')->insert([
            'label' => 'Enterprise',
            'value'=>'enterprise',
           
        ]);
        DB::table('plans')->insert([
            'label' => 'Team',
            'value'=>'team',
        ]);
      
    }
}

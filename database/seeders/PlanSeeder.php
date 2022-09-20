<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\User;
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
        Plan::truncate();
        DB::table('plans')->insert([
            'label' => 'Free',
            'value'=>'free',
           
        ]);
        DB::table('plans')->insert([
            'label' => 'Subscriber',
            'value'=>'subscriber',
           
        ]);
        DB::table('plans')->insert([
            'label' => 'AlphaMember',
            'value'=>'alpha-member',
        ]);
        User::where('CurrentPlan', 'basic')->update(['CurrentPlan' => 'free']);
        User::where('CurrentPlan', 'enterprise')->update(['CurrentPlan' => 'subscriber']);
        User::where('CurrentPlan', 'team')->update(['CurrentPlan' => 'alpha-member']);
        User::where('role', 'Admin')->update(['CurrentPlan' => 'alpha-member']);
    }
}

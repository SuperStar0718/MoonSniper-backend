<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     
        DB::table('users')->insert([
            'username' => 'admin1',
            'fullName'=>'Demo1',
            'role' =>'admin',
            'status' =>'active',
            'currentPlan'=>'team',
            'company'=>'dswebapp',                
            'email' => 'admin@email.com',
                'password' => bcrypt('password'),
        ]);
        DB::table('users')->insert([
            'username' => 'admin2',
            'fullName'=>'Demo2',
            'role' =>'admin',
            'status' =>'active',
            'currentPlan'=>'team',
            'company'=>'dswebapp',                
            'email' => 'admin2@email.com',
                'password' => bcrypt('password'),
        ]);
        DB::table('users')->insert([
            'username' => 'admin',
            'fullName'=>'Demo3',
            'role' =>'admin',
            'status' =>'active',
            'currentPlan'=>'team',
            'company'=>'dswebapp',                
            'email' => 'admin@demo.com',
            'password' => bcrypt('admin'),
        ]);
    }
}

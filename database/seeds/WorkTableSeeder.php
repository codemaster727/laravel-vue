<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class WorkTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0 ; $i < 20 ; $i ++){
            DB::table('works')->insert([
                'user_id' => rand(1, 20),
                'status' => rand(0, 1),
                'name' => Str::random(4) . '作業',
                'temporary_start_date' => Carbon::now()->format('Y-m-d'),
                'temporary_finish_date' => Carbon::now()->format('Y-m-d'),
                'period_start_date' => Carbon::now()->format('Y-m-d'),
                'period_finish_date' => Carbon::now()->format('Y-m-d'),
                'postal' => Str::random(7),
                'address' => Str::random(50) . '現場住所',
                'client_id' => rand(1, 20),
                'member_id' => rand(1, 20),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }
    }
}

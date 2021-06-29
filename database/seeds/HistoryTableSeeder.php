<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class HistoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0 ; $i < 200 ; $i ++){
            DB::table('histories')->insert([
                'work_id'    => rand(1, 20),
                'charge_id'  => rand(1, 20),
                'charge_work_status'      => rand(1, 20),
                'work_date'       => Carbon::now()->format('Y-m-d'),
                'work_start_on'       => Carbon::now()->format('Y-m-d H:i:s'),
                'work_finish_on'       => Carbon::now()->format('Y-m-d H:i:s'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }
    }
}

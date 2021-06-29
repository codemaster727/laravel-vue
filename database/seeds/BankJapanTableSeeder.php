<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class BankJapanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bank_japans')->insert([
            'bank_id'     => 1,
            'mark'        => 67833,
            'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        DB::table('bank_japans')->insert([
            'bank_id'     => 3,
            'mark'        => 19321,
            'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'  => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class BankOtherTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bank_others')->insert([
            'bank_id'         => 2 ,
            'financial_name'  => '住信BISネット銀行',
            'branch_name'     => '町田支店',
            'branch_number'   => 329,
            'type'            => 0,
            'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'      => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}

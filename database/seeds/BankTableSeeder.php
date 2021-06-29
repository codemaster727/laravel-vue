<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class BankTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('banks')->insert([
            'user_id'    => 1,
            'type'       => 'japan',
            'number'     => 8901234,
            'name'       => 'ナカザワ カン',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        DB::table('banks')->insert([
            'user_id'    => 1,
            'type'       => 'other',
            'number'     => 1234567,
            'name'       => 'タナカ タツヤ',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        DB::table('banks')->insert([
            'user_id'    => 1,
            'type'       => 'japan',
            'number'     => 6789012,
            'name'       => 'シミズ ナオキ',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class ShortMessageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('short_messages')->insert([
            'type'       => 1,
            'user_id'    => 1,
            'work_id'    => 1,
            'client_id'  => 1,
            //'title'      => Str::random(20),
            //'text'       => Str::random(40),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}

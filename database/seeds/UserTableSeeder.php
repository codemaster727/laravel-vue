<?php

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'manager_id'        => 1,
            'price'             => 1,
            'email'             => 'chankan77@gmail.com',
            'password'          => Hash::make('ofp12345'),
            'company'           => '株式会社Atkid',
            'tel'               => '08099999999',
            'postal'            => '1003000',
            'address'           => '東京都新宿区東榎町5-5 プレールドゥーク神楽坂1402',
            'status'            => 0,
            'bank_id'           => 1,
            'manager_remark'    => '管理者備考管理者備考管理者備考管理者備考',
            'email_token'       => null,
            'email_verified_at' => Carbon::now(),
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now()
        ]);
        // for ($i = 0; $i < 10; $i++) {
        //     User::create([
        //         'manager_id'        => 1,
        //         'company'           => '株式会社Atkid',
        //         'tel'               => '08099999999',
        //         'postal'            => '1000000',
        //         'price'             => 1,
        //         'address'           => '東京都千代田区千代田1-1-1 千代田ビルディング1F',
        //         'status'            => config('const.user.status.active'),
        //         'bank_id'           => $i,
        //         'manager_remark'    => '管理者備考管理者備考管理者備考管理者備考',
        //         'email'             => 'test'.$i.'@test.com',
        //         'email_token'       => null,
        //         'email_verified_at' => Carbon::now(),
        //         'password'          => Hash::make('password')
        //     ]);
        // }
    }
}

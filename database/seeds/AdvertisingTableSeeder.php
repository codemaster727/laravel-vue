<?php

use App\Models\Advertising;
use Illuminate\Database\Seeder;

class AdvertisingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            Advertising::create([
                'manager_id'        => 1,
                'status'            => config('const.advertisings.status.active'),
                'company'           => '株式会社広告'.$i,
                'url'               => 'https://www.google.co.jp/',
                'img_url'           => null,
                'charge'            => '担当一郎'.$i,
                'email'             => 'advertising'.$i.'@advertising.com',
                'phone'             => '0901111000'.$i,
                'zip'               => '2000000',
                'address'           => '神奈川県川崎市麻生区麻生1-1-1 麻生ビルディング1F',
                'manager_remark'    => '備考備考備考備考備考備考備考備考備考備考備考備考備考備考備考備考備考備考備考備考',

            ]);
        }
    }
}

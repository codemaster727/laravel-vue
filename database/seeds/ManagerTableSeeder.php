<?php

use Carbon\Carbon;
use App\Models\Manager;
use Illuminate\Database\Seeder;

class ManagerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 管理者権限の管理者
        Manager::create([
            'email'         => 'admin1@admin.com',
            'password'      => bcrypt('password'),
            'name'          => '管理太郎',
            'authority'     => config('const.manager.authority.owner'),
        ]);
        // 代理店権限の管理者
        Manager::create([
            'email'         => 'admin2@admin.com',
            'password'      => bcrypt('password'),
            'name'          => '管理次郎',
            'authority'     => config('const.manager.authority.agency'),
        ]);
        // 代理店権限の管理者
        Manager::create([
            'email'         => 'admin3@admin.com',
            'password'      => bcrypt('password'),
            'name'          => '管理三郎',
            'authority'     => config('const.manager.authority.agency'),
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserTableSeeder::class,
            BankTableSeeder::class,
            BankJapanTableSeeder::class,
            BankOtherTableSeeder::class,
            // ProcessMasterTableSeeder::class,
            ProcessColorTableSeeder::class,
            // HistoryTableSeeder::class,
            // WorkerTableSeeder::class,
            // WorkTableSeeder::class,
            // WorkReportMasterTableSeeder::class,
            // WorkReportPhotoTableSeeder::class,
            ManagerTableSeeder::class,
            // MemoTableSeeder::class,
            // ShortMessageTableSeeder::class,
            // AdvertisingTableSeeder::class,
            // AdvertisingTermTableSeeder::class,
        ]);
    }
}

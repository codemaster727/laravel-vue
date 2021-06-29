<?php

use Carbon\Carbon;
use App\Models\AdvertisingTerm;
use Illuminate\Database\Seeder;

class AdvertisingTermTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        for ($i = 1; $i <= 10; $i++) {
            AdvertisingTerm::create([
                'advertising_id'    => $i,
                'period'            => $i,
                'schedule_ended_at' => $now->addMonth($i + 1),
                'price'             => 1,
                'started_at'        => $now,
                'ended_at'          => null,
                'approve_at'        => $now,
            ]);
        }
    }
}

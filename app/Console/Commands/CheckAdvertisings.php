<?php

namespace App\Console\Commands;

use DateTime;
use App\Models\AdvertisingTerm;
use Illuminate\Console\Command;

class CheckAdvertisings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:check-advertisings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks advertisings table and auto extend the contracts.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $today = date('Y-m-d H:i:s');
        $advertising_terms = AdvertisingTerm::where('approve_at', '!=', '')->get();
        foreach ($advertising_terms as $index => $term) {
            if ($today >= $term->ended_at) {
                // Extend
                print_r("ID : " . $term->id . "\n");
                $end_date = new DateTime($term->ended_at);
                $end_date = $end_date->add(date_interval_create_from_date_string('+' . $term->period . ' months'));
                $end_date = $end_date->format('Y-m-d H:i:s');

                print_r("EndDate : " . $end_date . "\n");

                $term->schedule_ended_at = $end_date;
                $term->ended_at = $end_date;
                $term->save();
            }
        }
    }
}

<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ReservationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Reservation::updateOrInsert([
            'id' => 1,
            'user_id' => 1,
            'location_id' => 1,
            'start_time' => Carbon::now(),
            'end_time' => Carbon::now()->addHour(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

    }
}

<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class LocationStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\LocationStatus::updateOrInsert([
            'id' => 1,
            'status' => 'Otvorene',
            'language_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        \App\LocationStatus::updateOrInsert([
            'id' => 1,
            'status' => 'Open',
            'language_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        \App\LocationStatus::updateOrInsert([
            'id' => 2,
            'status' => 'Zatvorene',
            'language_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        \App\LocationStatus::updateOrInsert([
            'id' => 2,
            'status' => 'Closed',
            'language_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        \App\LocationStatus::updateOrInsert([
            'id' => 3,
            'status' => 'Na kluc',
            'language_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        \App\LocationStatus::updateOrInsert([
            'id' => 3,
            'status' => 'Key',
            'language_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}

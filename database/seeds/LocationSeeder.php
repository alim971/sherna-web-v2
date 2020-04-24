<?php

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\Location::updateOrInsert([
            'id' => 1,
            'name' => 'Blok 4',
            'status_id' => 1,
            'language_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        \App\Location::updateOrInsert([
            'id' => 1,
            'name' => 'Block 4',
            'status_id' => 1,
            'language_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        \App\Location::updateOrInsert([
            'id' => 2,
            'name' => 'Blok 6',
            'status_id' => 2,
            'language_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        \App\Location::updateOrInsert([
            'id' => 2,
            'name' => 'Block 6',
            'status_id' => 2,
            'language_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}

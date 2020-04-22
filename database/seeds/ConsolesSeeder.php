<?php

use Illuminate\Database\Seeder;

class ConsolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\ConsoleType::updateOrInsert([
            'id' => 1,
            'name' => 'XBOX 360'
        ]);

        \App\Console::updateOrInsert([
            'id' => 1,
            'location_id' => 1,
            'console_type_id' => 1,
            'name' => 'XBox Blok 4'
        ]);
    }
}

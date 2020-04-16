<?php

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Setting::updateOrInsert([
            'id' => 1,
            'name' => 'duration',
            'value' => 8.0,
        ]);
    }
}

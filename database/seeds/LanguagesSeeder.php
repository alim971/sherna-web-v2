<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('languages')->updateOrInsert([
            'id' => 1,
            'code' => 'cz',
            'name' => 'český'
        ]);

        DB::table('languages')->updateOrInsert([
            'id' => 2,
            'code' => 'en',
            'name' => 'anglický'
        ]);
    }
}

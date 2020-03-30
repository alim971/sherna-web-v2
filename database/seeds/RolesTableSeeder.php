<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Vygeneruj základní uživatelské role.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->updateOrInsert([
            'name' => 'Administrátor',
            'slug' => 'admin',
        ], [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('roles')->updateOrInsert([
            'name' => 'Člen',
            'slug' => 'member',
        ], [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}

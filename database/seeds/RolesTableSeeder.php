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
        \App\Role::updateOrInsert([
            'id' => 1,
            'name' => 'user',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        \App\Role::updateOrInsert([
            'id' => 2,
            'name' => 'user_vr',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        \App\Role::updateOrInsert([
            'id' => 3,
            'name' => 'admin',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        \App\Role::updateOrInsert([
            'id' => 4,
            'name' => 'super_admin',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
//        DB::table('roles')->updateOrInsert([
//            'name' => 'Administrátor',
//            'slug' => 'admin',
//        ], [
//            'created_at' => Carbon::now(),
//            'updated_at' => Carbon::now(),
//        ]);
//        DB::table('roles')->updateOrInsert([
//            'name' => 'Člen',
//            'slug' => 'member',
//        ], [
//            'created_at' => Carbon::now(),
//            'updated_at' => Carbon::now(),
//        ]);
    }
}

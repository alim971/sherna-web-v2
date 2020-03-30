<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Vygeneruj testovací uživatelské účty.
     *
     * @return void
     */
    public function run()
    {
        /** @var User $admin */
        $admin = User::updateOrCreate([
            'name' => 'admin',
            'email' => 'admin@localhost',
        ], [
            'password' => Hash::make('password'),
            'email_verified_at' => Carbon::now(),
        ]);
        $admin->assignRoles(['admin']);

        User::updateOrCreate([
            'name' => 'user',
            'email' => 'user@localhost',
        ], [
            'password' => Hash::make('password'),
            'email_verified_at' => Carbon::now(),
        ]);
    }
}

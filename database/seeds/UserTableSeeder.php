<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@admin.nl',
            'password' => bcrypt('password'),
        ])->grantRole(Role::firstWhere('name', '=', Role::$ADMINISTRATOR));

        $deadlinemanager = User::create([
            'name' => 'deadlinemanager',
            'email' => 'manager@deadline.nl',
            'password' => bcrypt('password'),
        ])->grantRole(Role::firstWhere('name', '=', Role::$DEADLINE_MANAGER));
    }
}

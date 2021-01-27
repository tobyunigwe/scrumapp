<?php

use Illuminate\Database\Seeder;

class UserRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users_roles')->insert([
            'role' => 'Admin',
        ]);
        DB::table('users_roles')->insert([
            'role' => 'User',
        ]);
    }
}

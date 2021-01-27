<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => Str::random(10),
            'email' => Str::random(10).'@example.nl',
            'password' => bcrypt('password'),
            'user_role_id' => 2
        ]);
        DB::table('users')->insert([
            'name' => 'Rico',
            'email' => 'rico@example.nl',
            'password' => bcrypt('rico1234'),
            'user_role_id' => 2
        ]);
        DB::table('users')->insert([
            'name' => 'Baris',
            'email' => 'baris@example.nl',
            'password' => bcrypt('baris1234'),
            'user_role_id' => 2
        ]);
    }
}

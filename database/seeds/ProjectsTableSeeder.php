<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('projects')->insert([
            'title' => Str::random(10),
            'description' => Str::random(10),
            'deadline' => Carbon::create('2021', '01', '01')
        ]);
    }
}

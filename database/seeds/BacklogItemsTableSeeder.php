<?php

use Illuminate\Database\Seeder;


class BacklogItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('backlog_items')->insert([
            'role' => Str::random(10),
            'activity' => Str::random(10) . '@example.nl',
            'story_point' => "20",
            'project_id' => "1",
            'type' => "Feature"
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->insert([
            ['name' => 'easy'],
            ['name' => 'difficult'],
            ['name' => 'a lot of work'],
            ['name' => 'not a lot of work'],
            ['name' => 'fun'],
            ['name' => 'not fun']
        ]);
    }
}

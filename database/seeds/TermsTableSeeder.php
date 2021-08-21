<?php

use Illuminate\Database\Seeder;

class TermsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('terms')->insert([
            ['semester' => '1', 'quarter' => '1'],
            ['semester' => '1', 'quarter' => '2'],
            ['semester' => '2', 'quarter' => '3'],
            ['semester' => '2', 'quarter' => '4'],
            ['semester' => '3', 'quarter' => '5'],
            ['semester' => '3', 'quarter' => '6'],
            ['semester' => '4', 'quarter' => '7'],
            ['semester' => '4', 'quarter' => '8'],
            ['semester' => '5', 'quarter' => '9'],
            ['semester' => '5', 'quarter' => '10'],
            ['semester' => '6', 'quarter' => '11'],
            ['semester' => '6', 'quarter' => '12'],
            ['semester' => '7', 'quarter' => '13'],
            ['semester' => '7', 'quarter' => '14'],
            ['semester' => '8', 'quarter' => '15'],
            ['semester' => '8', 'quarter' => '16'],
        ]);
    }
}

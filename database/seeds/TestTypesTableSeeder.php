<?php

use App\TestType;
use Illuminate\Database\Seeder;

class TestTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('test_types')->insert([
            ['name' => TestType::$EXAMINATION],
            ['name' => TestType::$ASSESSMENT]
        ]);
    }
}

<?php

use App\Module;
use Illuminate\Database\Seeder;

class TestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Module::all()->each(function ($module) {
            $test = factory(App\Test::class)->create([
                'module_id' => $module->id
            ]);
        });
    }
}

<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        factory(App\Student::class, 100)->create()->each(function ($student) use ($faker) {
            $lectures = collect();
            \App\Module::all()->random(rand(5, 8))->each(function ($module) use ($lectures) {
                $lectures->add($module->lectures->random(1)->pluck('id')->first());
            });
            $student->lectures()->attach($lectures);

            $student->lectures()->each(function ($lecture) use ($student, $faker) {
                if ($faker->boolean) {
                    $student
                        ->lectures()
                        ->where('lecture_id', '=', $lecture->id)
                        ->update([
                            'grade' => $faker->randomFloat(2, 1, 10),
                            'graded_at' => $faker->dateTimeBetween('-2 weeks', 'now'),
                            'submitted_at' => $faker->dateTimeBetween('-4 weeks', '-2 weeks')
                        ]);
                }
            });
        });
    }
}

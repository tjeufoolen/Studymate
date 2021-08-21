<?php

use App\Lecture;
use App\Tag;
use App\Teacher;
use Illuminate\Database\Seeder;

class ModulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [
            'Software Engineering 1',
            'Software Engineering 2',
            'Software Engineering 3',
            'Software Engineering 4',
            'Software Engineering 5',
            'Software Architecture 1',
            'Software Architecture 2',
            'Software Architecture 3',
            'Programming 1',
            'Programming 2',
            'Programming 3',
            'Programming 4',
            'Programming 5',
            'Programming 6',
            'WEBSJS',
            'WEBS PHP',
            'Job applying',
            'English writing',
            'English presenting',
            'Project Agile 1',
            'Project Agile 2',
            'Project Sagrada - design',
            'Project Sagrada - building',
            'Project Festispec - design',
            'Project Festispec - building',
            'REGEX',
            'Databases 1',
            'Databases 2',
            'Databases 3',
            'Databases 4',
            'Reporting 1',
            'Reporting 2'
        ];

        foreach ($names as $name) {
            $module = factory(App\Module::class)->create([
                'name' => $name
            ]);

            Teacher::all()->random(rand(1, 4))->each(function ($teacher) use ($module) {
                $lecture = Lecture::create(['teacher_id' => $teacher->id, 'module_id' => $module->id]);
            });

            $module->tags()->attach(
                Tag::all()->random(rand(1, 3))->pluck('id')->toArray()
            );
        }
    }
}

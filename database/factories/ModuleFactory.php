<?php

/** @var Factory $factory */

use App\Module;
use App\Teacher;
use App\Term;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Module::class, function (Faker $faker) {
    return [
        'credits' => $faker->numberBetween(1, 6),
        'coordinator_id' => Teacher::all()->random()->id,
        'term_id' => Term::all()->random()->id
    ];
});

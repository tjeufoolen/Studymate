<?php

/** @var Factory $factory */

use App\Test;
use App\TestType;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Test::class, function (Faker $faker) {
    return [
        'test_type_id' => TestType::all()->random()->id,
        'deadline_at' => null
    ];
});

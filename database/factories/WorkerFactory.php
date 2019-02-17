<?php

use Faker\Generator as Faker;
use App\Worker;

$factory->define(Worker::class, function (Faker $faker) {
    return [
        'chief_id' => 0,
        'full_name' => $faker->name,
        'job' => $faker->jobTitle,
        'hire_date' => $faker->date(),
        'salary' => $faker->randomNumber(4),
    ];
});

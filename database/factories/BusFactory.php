<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Bus::class, function (Faker $faker) {
    return [
        'depart_loc' => $faker->text(8),
        'arrival_loc' => $faker->text(8),
        'depart_date' => $faker->dateTimeThisMonth(),
        'depart_time' => $faker->time(),
        'arrival_time' => $faker->time()
    ];
});

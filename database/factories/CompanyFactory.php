<?php

use Faker\Generator as Faker;

$factory->define(App\Company::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'name' => $faker->company
    ];
});

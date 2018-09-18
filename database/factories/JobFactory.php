<?php

use Faker\Generator as Faker;

$factory->define(App\Job::class, function (Faker $faker) {
    return [
        'company_id' => function () {
            return factory(\App\Company::class)->create()->id;
        },
        'title' => $faker->jobTitle,
        'description' => $faker->paragraph
    ];
});

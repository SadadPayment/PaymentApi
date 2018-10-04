<?php

use Faker\Generator as Faker;

$factory->define(App\Model\UserGroup::class, function (Faker $faker) {
    return [
        //
        'type' => $faker->name
    ];
});

<?php

use Faker\Generator as Faker;

$factory->define(App\Model\TransactionType::class, function (Faker $faker) {
    return [
        //
        "name" => "payment"
    ];
});

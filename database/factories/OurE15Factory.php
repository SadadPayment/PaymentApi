<?php

use Faker\Generator as Faker;

$factory->define(App\Model\OurE15::class, function (Faker $faker) {
    return [
        //
        'userName' => "sana",
        'password' => "Sana123",
        'appId' => "NIC-E15-PoS-1.0-1",
        'key' => "dpv9777S+NnGsNDZMi4t2VdCohuoN8JuTxbP9nZ+sy4="
    ];
});

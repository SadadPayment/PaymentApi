<?php

use Faker\Generator as Faker;

$factory->define(App\Model\Merchant\MerchantServices::class, function (Faker $faker) {
    //App\Model\Merchant\MerchantServices::truncate();
    DB::table("merchant_services")->delete();
    $totalFees = $faker->numberBetween(100,1000);
    $sadadFees = $totalFees / 10;
    $standerFees = $totalFees - $sadadFees;
    $merchants = App\Model\Merchant\Merchant::all()->pluck('id')->toArray();
    $type=App\Model\Merchant\MerchantType::all()->pluck('id')->toArray();
    return [
        //
        'name' => $faker->name(),
        'totalFees' => $totalFees,
        'sadadFess' => $sadadFees,
        'standardFess' => $standerFees,
        'merchant_id' => $faker->randomElement($merchants),
        'type_id' => $faker->randomElement($type)

    ];
});

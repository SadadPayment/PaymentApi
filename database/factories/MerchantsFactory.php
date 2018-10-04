<?php

use Faker\Generator as Faker;

$factory->define(App\Model\Merchant\Merchant::class, function (Faker $faker) {
    //App\Model\Merchant\MerchantServices::truncate();
    //App\Model\Merchant\Merchant::truncate();
//    $type=DB::table('merchant_types')->where('id' , '>=' , 0)->lists('id');
    $type=App\Model\Merchant\MerchantType::all()->pluck('id')->toArray();
    return [
        //
        'merchant_name' => $faker->name(),
        'status' => $faker->boolean(),
        'type_id' => $faker->randomElement($type),
        'payee_id' => $faker->randomNumber()
    ];
});

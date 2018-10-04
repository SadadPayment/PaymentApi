<?php

use Illuminate\Database\Seeder;
use App\Model\Merchant\MerchantServices;

class services extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(MerchantServices::class , 30)->create();
    }
}

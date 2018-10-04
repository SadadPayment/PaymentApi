<?php

use Illuminate\Database\Seeder;
use App\Model\Merchant\MerchantType as type;

class MerchantTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $gov = new type;
        $gov->name = 'goverment';
        $gov->save();
        $priv = new type;
        $priv->name = 'private';
        $priv->save();
        //factory(type::class , 3)->create();
    }
}

<?php

use Illuminate\Database\Seeder;
use App\Model\Merchant\Merchant;
class MerchantsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(Merchant::class , 30)->create();
    }
}

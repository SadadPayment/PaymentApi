<?php

use Illuminate\Database\Seeder;

class TransfersTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $card=new App\Model\TransferType();
        $card->name = "Card Transfer";
        $card->save();
    }
}

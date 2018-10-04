<?php

use Illuminate\Database\Seeder;

class TopUpBillerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $zain = new App\Model\Payment\TopUp\TopUpBiller();
        $zain->name = "Zain";
        $zain->save();
        $sudani = new App\Model\Payment\TopUp\TopUpBiller();
        $sudani->name = "Sudani";
        $sudani->save();
        $mtn = new App\Model\Payment\TopUp\TopUpBiller();
        $mtn->name = "MTN";
        $mtn->save();

    }
}

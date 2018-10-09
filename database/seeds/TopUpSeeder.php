<?php

use Illuminate\Database\Seeder;

class TopUpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $zain=App\Model\Payment\TopUp\TopUpBiller::where("name","Zain")->first();
        $sudani=App\Model\Payment\TopUp\TopUpBiller::where("name","Sudani")->first();
        $mtn=App\Model\Payment\TopUp\TopUpBiller::where("name","MTN")->first();

        $zain_top_up = new App\Model\Payment\payee();
        $zain_top_up->payee_id = "0010010001";
        $zain_top_up->name = "Zain";
        $zain_top_up->save();


        $mtn_top_up = new App\Model\Payment\Payee();
        $mtn_top_up->payee_id = "0010010003";
        $mtn_top_up->name = "MTN";
        $mtn_top_up->save();


        $sudani_top_up = new App\Model\Payment\Payee();
        $sudani_top_up->payee_id = "0010010005";
        $sudani_top_up->name = "Sudani";
        $sudani_top_up->save();

    }
}

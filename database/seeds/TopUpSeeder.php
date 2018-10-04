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
        //$top_up = App\Model\Payment\TopUp\TopUpType::where("name","TopUp")->first();
        //$bill_payment = App\Model\Payment\TopUp\TopUpType::where("name","BillPayment")->first();



        $zain_top_up = new App\Model\Payment\TopUp\TopUp();
        $zain_top_up->payee_id = "0010010001";
        $zain_top_up->biller()->associate($zain);
        $zain_top_up->save();


        $mtn_top_up = new App\Model\Payment\TopUp\TopUp();
        $mtn_top_up->payee_id = "0010010003";
        $mtn_top_up->biller()->associate($mtn);
        $mtn_top_up->save();



        $sudani_top_up = new App\Model\Payment\TopUp\TopUp();
        $sudani_top_up->payee_id = "0010010005";
        $sudani_top_up->biller()->associate($sudani);

        $sudani_top_up->save();


    }
}

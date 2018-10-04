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



        $zain_top_up = new App\Model\TopUp();
        $zain_top_up->payee_id = "0010010001";
        $zain_top_up->biller()->associate($zain);
        $zain_top_up->type()->associate($top_up);
        $zain_top_up->save();

        $zain_bill_payment = new App\Model\TopUp();
        $zain_bill_payment->payee_id = "0010010002";
        $zain_bill_payment->biller()->associate($zain);
        $zain_bill_payment->type()->associate($bill_payment);
        $zain_bill_payment->save();

        $mtn_top_up = new App\Model\TopUp();
        $mtn_top_up->payee_id = "0010010003";
        $mtn_top_up->biller()->associate($mtn);
        $mtn_top_up->type()->associate($top_up);
        $mtn_top_up->save();

        $mtn_bill_payment = new App\Model\TopUp();
        $mtn_bill_payment->payee_id = "0010010004";
        $mtn_bill_payment->biller()->associate($mtn);
        $mtn_bill_payment->type()->associate($bill_payment);
        $mtn_bill_payment->save();

        $sudani_top_up = new App\Model\TopUp();
        $sudani_top_up->payee_id = "0010010005";
        $sudani_top_up->biller()->associate($sudani);
        $sudani_top_up->type()->associate($top_up);
        $sudani_top_up->save();

        $sudani_bill_payment = new App\Model\TopUp();
        $sudani_bill_payment->payee_id = "0010010006";
        $sudani_bill_payment->biller()->associate($sudani);
        $sudani_bill_payment->type()->associate($bill_payment);
        $sudani_bill_payment->save();
    }
}

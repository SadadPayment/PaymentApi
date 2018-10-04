<?php

use Illuminate\Database\Seeder;

class TopUpTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $top_up = new App\Model\TopUpType();
        $top_up->name = "TopUp";
        $top_up->save();
        $bill_payment= new App\Model\TopUpType();
        $bill_payment->name = "BillPayment";
        $bill_payment->save();
    }
}

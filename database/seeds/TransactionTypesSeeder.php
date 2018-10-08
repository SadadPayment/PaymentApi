<?php

use Illuminate\Database\Seeder;

class TransactionTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(App\Model\TransactionType::class , 1)->create();
        $top_up=new App\Model\TransactionType();
        $top_up->name = "Top Up";
        $top_up->save();
        $top_u=new App\Model\TransactionType();
        $top_u->name = "Card Transfer";
        $top_u->save();//Electericity

        $electricity=new App\Model\TransactionType();
        $electricity->name = "Electericity";
        $electricity->save();

        $e15=new App\Model\TransactionType();
        $e15->name = "E15";
        $e15->save(); //Balance Inquiry

        $balance_inquery=new App\Model\TransactionType();
        $balance_inquery->name = "Balance Inquiry";
        $balance_inquery->save(); //

    }
}

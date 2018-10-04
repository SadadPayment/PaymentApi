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
        DB::table('top_up_billers')->insert([
            'name' => "Zain",
        ]);
        DB::table('top_up_billers')->insert([
            'name' => "Sudani",
        ]);
        DB::table('top_up_billers')->insert([
            'name' => "MTN"
        ]);
//        $zain = new App\Model\Payment\TopUp\TopUpBiller();
//        $zain->name = "Zain";
//        $zain->save();
//        $sudani = new App\Model\Payment\TopUp\TopUpBiller();
//        $sudani->name = "Sudani";
//        $sudani->save();
//        $mtn = new App\Model\Payment\TopUp\TopUpBiller();
//        $mtn->name = "MTN";
//        $mtn->save();

    }
}

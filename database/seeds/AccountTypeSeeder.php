<?php

use Illuminate\Database\Seeder;
use App\Model\Account\AccountType;

class AccountTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $bank =new AccountType;
        $bank->name = "bank";
        $bank->save();
        $mobile = new AccountType;
        $mobile->name = "mobile";
        $mobile->save();
    }
}

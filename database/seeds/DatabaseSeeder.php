<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(TransactionTypesSeeder::class);
        $this->call(OurE15Seeder::class);
        $this->call(UserGroupSeeder::class);
        $this->call(MerchantTypeSeeder::class);
        $this->call(MerchantsSeeder::class);
        $this->call(services::class);
        $this->call(AccountTypeSeeder::class);
        //$this->call(TopUpTypeSeeder::class);//TopUpBillerSeeder
        $this->call(TopUpBillerSeeder::class);//TopUpBillerSeeder
        $this->call(TopUpSeeder::class);//TopUpBillerSeeder
        $this->call(TransfersTypeSeeder::class);//TopUpBillerSeeder
    }
}

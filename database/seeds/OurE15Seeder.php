<?php

use Illuminate\Database\Seeder;

class OurE15Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(App\Model\OurE15::class , 1)->create();
    }
}

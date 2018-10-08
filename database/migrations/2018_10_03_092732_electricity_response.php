<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ElectricityResponse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('electricity_responses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('electricity_id')->unsigned();
            $table->foreign('electricity_id')->references('id')->on('electricites');
            $table->integer('payment_response_id')->unsigned();
            $table->foreign('payment_response_id')->references('id')->on('payment_responses');
            $table->string('meterFees');
            $table->string('netAmount');
            $table->string('unitsInKWh');
            $table->string('waterFees');
            $table->string('token');
            $table->string('customerName');
            $table->string('operatorMessage');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_responses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('response_id')->unsigned();
            $table->integer('payment_id')->unsigned();
            $table->string('balance');
            $table->string('acqTranFee');
            $table->string('issuerTranFee');
            $table->string('billInfo');
            $table->foreign('response_id')->references('id')->on('responses');
            $table->foreign('payment_id')->references('id')->on('payments');
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
        Schema::table('goverment_payment_responses' ,function (Blueprint $table){
           $table->dropForeign('goverment_payment_responses_payment_response_id_foreign');
        });
        Schema::dropIfExists('payment_responses');
    }
}

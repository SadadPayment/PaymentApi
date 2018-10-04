<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGovermentPaymentResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goverment_payment_responses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('payment_response_id')->unsigned();
            $table->string('invoiceExpiryDate');
            $table->string('invoiceStatus');
            $table->string('reciptNo');
            $table->string('unitName');
            $table->string('serviceName');
            $table->integer('totalAmountInt');
            $table->string('totalAmountInWord');
            $table->string('amountDue');
            $table->string('availableBalance');
            $table->string('legerBalance');
            $table->string('tranFee');
            $table->foreign('payment_response_id')->references('id')->on('payment_responses');
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
        Schema::dropIfExists('goverment_payment_responses');
    }
}

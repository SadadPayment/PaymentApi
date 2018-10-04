<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBalanceInquiryResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balance_inquiry_responses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('balance_inquery_id')->unsigned();
            $table->integer('response_id')->unsigned();
            $table->double('balance');
            $table->double('acqTranFee');
            $table->double('issuerTranFee');
            $table->foreign('balance_inquery_id')->references('id')->on('balance_inquiries');
            $table->foreign('response_id')->references('id')->on('responses');
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
        Schema::dropIfExists('balance_inquiry_responses');
    }
}

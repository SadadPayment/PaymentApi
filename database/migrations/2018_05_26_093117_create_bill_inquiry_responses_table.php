<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillInquiryResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill_inquiry_responses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bill_inquiry_id')->unsigned();
            $table->foreign('bill_inquiry_id')->references('id')->on('bill_inquiries');
            $table->integer('response_id')->unsigned();
            $table->foreign('response_id')->references('id')->on('responses');
            $table->string('billInfo');
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

        Schema::dropIfExists('bill_inquiry_responses');
    }
}

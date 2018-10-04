<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transaction_id')->unsigned();
            $table->foreign('transaction_id')->references('id')->on('transactions');
            $table->string('responseCode');
            $table->string('responseMessage');
            $table->string('responseStatus');
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
        //$table->foreign('response_id')->references('id')->on('responses');
        Schema::table('payment_responses' , function (Blueprint $table){
            $table->dropForeign('payment_responses_response_id_foreign');
        });
        Schema::table('balance_inquiry_responses' , function(Blueprint $table){
            $table->dropForeign('balance_inquiry_responses_balance_inquery_id_foreign');
        });
        Schema::table('bill_inquiry_responses' , function(Blueprint $table){
            $table->dropForeign('bill_inquiry_responses_response_id_foreign');
        });
        Schema::table('transfer_responses' , function(Blueprint $table){
            $table->dropForeign('transfer_responses_response_id_foreign');
        });
        Schema::dropIfExists('responses');
    }
}

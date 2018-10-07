<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            //$table->integer('service_id')->nullable()->unsigned();
            $table->integer('transaction_id')->unsigned();
            //$table->foreign('service_id')->references('id')->on('merchant_services');
            $table->foreign('transaction_id')->references('id')->on('transactions');
            $table->timestamps();
            $table->string('amount');
            //$table->integer('payment_method')->unsigned();//->default(null);
            //$table->foreign('payment_method')->references('id')->on('account_types');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('top_ups' , function(Blueprint $table){
            $table->dropForeign('top_ups_payment_id_foreign');
        });
        Schema::table('e15s' , function(Blueprint $table){
            $table->dropForeign('e15s_payment_id_foreign');
        });
        Schema::table('payment_responses' , function (Blueprint $table){
            $table->dropForeign('payment_responses_payment_id_foreign');
        });
        Schema::dropIfExists('payments');
    }
}

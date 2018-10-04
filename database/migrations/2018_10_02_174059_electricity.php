<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Electricity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('electricites', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('payment_id')->nullable()->unsigned();
            //$table->integer('transaction_id')->unsigned();
            $table->foreign('payment_id')->references('id')->on('payments');
            //$table->foreign('transaction_id')->references('id')->on('transactions');
            $table->timestamps();
            $table->string('meter');
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

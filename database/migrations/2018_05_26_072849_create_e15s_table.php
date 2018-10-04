<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateE15sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e15s', function (Blueprint $table) {
            $table->increments('id');
            $table->string('phone');
            $table->string('invoice_no');
            $table->integer('payment_id')->unsigned();
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
        Schema::table('e15_responses' , function (Blueprint $table){
            $table->dropForeign('e15_responses_e15_id_foreign');
        });
        Schema::dropIfExists('e15s');
    }
}

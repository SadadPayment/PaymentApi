<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopUpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('top_ups', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('payment_id')->unsigned();

            $table->integer('biller_id')->unsigned();

            $table->string('payee_id');

            $table->string('phone');


            $table->foreign('payment_id')->references('id')->on('payments');
            $table->foreign('biller_id')->references('id')->on('top_up_billers');
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
        Schema::table('pay_top_ups', function (Blueprint $table){
            $table->dropForeign('pay_top_ups_top_up_id_foreign');
        });
        Schema::dropIfExists('top_ups');
    }
}

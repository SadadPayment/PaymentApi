<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transaction_id')->unsigned();
            $table->foreign('transaction_id')->references('id')->on('transactions');
            $table->string('amount');
            $table->integer('type_id')->unsigned();
            $table->foreign('type_id')->references('id')->on('transfer_types');
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
        Schema::table('card_transfers' , function (Blueprint $table){
            $table->dropForeign('card_transfers_transfer_id_foreign');
        });
        Schema::table('account_transfers' , function (Blueprint $table){
            $table->dropForeign('account_transfers_transfer_id_foreign');
        });
        Schema::table('transfer_responses' , function (Blueprint $table){
            $table->dropForeign('transfer_responses_transfer_id_foreign');
        });
        Schema::dropIfExists('transfers');
    }
}

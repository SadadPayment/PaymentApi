<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('transDateTime');
            $table->uuid('uuid');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
            $table->integer('transaction_type')->unsigned();
            $table->foreign('transaction_type')->references('id')->on('transaction_types');
            $table->string("status");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payments' , function (Blueprint $table){
            $table->dropForeign('payments_transaction_id_foreign');
        });
        Schema::table('balance_inquiries',function (Blueprint $table) {

            $table->dropForeign('balance_inquiries_transaction_id_foreign');
            //$table->dropColumn('type');
        });
        Schema::table('bill_inquiries',function (Blueprint $table) {

            $table->dropForeign('bill_inquiries_transaction_id_foreign');
            //$table->dropColumn('type');
        });
        Schema::table('transfers' , function (Blueprint $table){
            $table->dropForeign('transfers_transaction_id_foreign');
        });

        Schema::table('mobile_accounts' , function (Blueprint $table){
            $table->dropForeign('mobile_accounts_transaction_id_foreign');
        });
        Schema::table('bank_accounts' , function (Blueprint $table){
            $table->dropForeign('bank_accounts_transaction_id_foreign');
        });
        Schema::dropIfExists('transactions');
    }
}

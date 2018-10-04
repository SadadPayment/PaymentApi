<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchants', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('payee_id');
            $table->string('merchant_name');
            $table->boolean('status');
            $table->timestamps();
            $table->integer('type_id')->unsigned();
            $table->foreign('type_id')->references('id')->on('merchant_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('merchant_services' , function (Blueprint $table){
            $table->dropForeign('merchant_services_merchant_foreign');
        });
        Schema::table('merchant_users' , function(Blueprint $table){
            $table->dropForeign('merchant_users_merchant_id_foreign');
        });
        Schema::table('merchant_bank_accounts' , function (Blueprint $table){
            $table->dropForeign('merchant_bank_accounts_merchant_id_foreign');
        });
        Schema::dropIfExists('merchants');
    }
}

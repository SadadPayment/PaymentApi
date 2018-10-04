<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique();
            $table->string('fullName');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->integer('user_group')->unsigned()->default('1');;
            $table->foreign('user_group')->references('id')->on('user_groups');
            $table->string("status")->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions' , function(Blueprint $table){
            $table->dropForeign('transactions_user_id_foreign');
            //$table->dropColumn('transactionType');
        });
        Schema::table('merchant_users' , function(Blueprint $table){
            $table->dropForeign('merchant_users_user_id_foreign');
        });
        Schema::dropIfExists('users');
    }
}

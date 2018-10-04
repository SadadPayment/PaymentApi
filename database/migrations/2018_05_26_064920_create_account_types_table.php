<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
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
        Schema::table('payments' , function (Blueprint $table){
            $table->dropForeign('payments_service_id_foreign');
        });
        Schema::table('balance_inquiries',function (Blueprint $table){

            $table->dropForeign('balance_inquiries_account_type_id_foreign');
        });
        Schema::dropIfExists('account_types');
    }
}

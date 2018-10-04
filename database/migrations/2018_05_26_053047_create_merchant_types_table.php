<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_types', function (Blueprint $table) {
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
        Schema::table('merchants',function (Blueprint $table) {

            $table->dropForeign('merchants_type_foreign');
            //$table->dropColumn('type');
        });
        Schema::table('merchant_services',function (Blueprint $table) {

            $table->dropForeign('merchant_services_type_foreign');
            $table->dropColumn('type');
        });

        Schema::dropIfExists('merchant_types');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->double('totalFees');
            $table->double('sadadFess');
            $table->double('standardFess');
            $table->integer('merchant_id')->unsigned();
            $table->foreign('merchant_id')->references('id')->on('merchants');
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
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign('payments_payment_method_foreign');
        });
        if (Schema::hasTable(('e15_services'))) {
            Schema::table('e15_services', function (Blueprint $table) {
                $table->dropForeign('e15_services_service_id_foreign');
            });
        }
        Schema::dropIfExists('merchant_services');
    }
}

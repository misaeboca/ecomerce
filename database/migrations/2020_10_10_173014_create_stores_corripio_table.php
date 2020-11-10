<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresCorripioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores_corripio', function (Blueprint $table) {
            $table->id('id_number');
            $table->string('id_store', 255)->nullable();
            $table->string('store', 255)->nullable();
            $table->longText('merchant_id')->nullable();
            $table->longText('merchant_key')->nullable();
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
        Schema::dropIfExists('stores_corripio');
    }
}

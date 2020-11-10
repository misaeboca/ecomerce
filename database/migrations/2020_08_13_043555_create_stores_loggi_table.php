<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresLoggiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores_loggi', function (Blueprint $table) {
            $table->id('id_number');
            $table->string('id_store',255)->nullable();
            $table->longText('user')->nullable();
            $table->longText('password')->nullable();
            $table->longText('api_key')->nullable();
            $table->longText('shop')->nullable();
            $table->integer('distance')->unsigned()->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stores_loggi');
    }
}

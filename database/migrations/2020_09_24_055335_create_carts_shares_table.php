<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsSharesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts_shares', function (Blueprint $table) {
            $table->id('id_number');
            $table->string('id',255)->unique()->nullable();
            $table->string('id_store',255)->nullable();
            $table->string('id_user',255)->nullable();
            $table->longText('json')->nullable();
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
        Schema::dropIfExists('carts_shares');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id('id_number');
            $table->string('id',255)->unique()->nullable();
            $table->string('id_client',255)->nullable();
            $table->string('sigla', 10)->nullable();
            $table->string('name',255)->nullable();
            $table->string('country',255)->nullable();
            $table->string('city',255)->nullable();
            $table->string('address',255)->nullable();
            $table->string('cep',255)->nullable();
            $table->string('email',255)->nullable();
            $table->string('phone',30)->nullable();
            $table->longText('logo')->nullable();
            $table->longText('domain')->nullable();
            $table->longText('coordinates')->nullable();
            $table->string('google_tag_manager',255)->nullable();
            $table->string('google_tag_manager_body',255)->nullable();
            $table->boolean('pickup')->default(true);
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
        Schema::dropIfExists('stores');
    }
}

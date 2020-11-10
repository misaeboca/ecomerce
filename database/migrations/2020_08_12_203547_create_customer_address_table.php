<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_address', function (Blueprint $table) {
            $table->id('id_number');
            $table->string('id', 255)->unique()->nullable();
            $table->string('id_customer',255)->nullable();
            $table->enum('type', ['address', 'delivery'])->default('address');
            $table->string('street', 255)->nullable();
            $table->string('number', 255)->nullable();
            $table->string('complement', 255)->nullable();
            $table->string('zip_code', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('state', 255)->nullable();
            $table->string('country', 255)->nullable();
            $table->string('district', 255)->nullable();
            $table->string('cep', 255)->nullable();
            $table->string('endereco', 255)->nullable();
            $table->string('neighborhood', 255)->nullable();
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
        Schema::dropIfExists('customer_address');
    }
}

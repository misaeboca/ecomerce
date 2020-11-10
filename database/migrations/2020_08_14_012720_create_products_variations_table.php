<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsVariationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_variations', function (Blueprint $table) {
            $table->id('id_number');
            $table->string('product',255)->nullable();
            $table->string('cod',255)->nullable();
            $table->string('sku',255)->nullable();
            $table->float('price',11,2)->nullable();
            $table->longText('description')->nullable();
            $table->longText('extra')->nullable();
            $table->longText('ean13')->nullable();
            $table->longText('itf14')->nullable();
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
        Schema::dropIfExists('products_variations');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_images', function (Blueprint $table) {
            $table->id('id_number');
            $table->string('id',255)->unique()->nullable();
            $table->string('product',255)->nullable();
            $table->string('cod',255)->nullable();
            $table->string('sku',255)->nullable();
            $table->longText('url')->nullable();
            $table->string('height')->nullable();
            $table->string('width')->nullable();
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
        Schema::dropIfExists('products_images');
    }
}

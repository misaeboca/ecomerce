<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_products', function (Blueprint $table) {
            $table->id('id_number');
            $table->string('id_order',255)->nullable();
            $table->string('cod', 255)->nullable();
            $table->string('product', 255)->nullable();
            $table->string('sku',255)->nullable();
            $table->float('price', 11, 4)->unsigned();
            $table->integer('quantity')->unsigned()->default(1);
            $table->float('task',11,4)->unsigned()->default(0.00);
            $table->float('discount',11,4)->unsigned()->default(0.00);
            $table->string('total',255)->default('0.00');
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
        Schema::dropIfExists('orders_products');
    }
}

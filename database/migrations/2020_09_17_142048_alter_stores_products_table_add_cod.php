<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterStoresProductsTableAddCod extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stores_products', function (Blueprint $table) {
            $table->string('cod',255)->after('id_number')->nullable();
            $table->string('product',255)->after('id_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stores_products', function (Blueprint $table) {
            $table->dropColumn('cod');
            $table->dropColumn('sku');
        });
    }
}

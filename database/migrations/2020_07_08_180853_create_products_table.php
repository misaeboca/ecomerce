<?php

use App\Models\GlobalStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('id_number');
            $table->string('id_client',255)->nullable();
            $table->string('name',255)->nullable();
            $table->string('sku',255)->nullable();
            $table->longText('html_description')->nullable();
            $table->longText('html_short_description')->nullable();
            $table->float('sale_price',11,2)->nullable();
            $table->float('old_price',11,2)->nullable();
            $table->longText('categories')->nullable();
            $table->longText('type')->nullable();
            $table->longText('material')->nullable();
            $table->longText('theme')->nullable();
            $table->longText('alternative_names')->nullable();
            $table->longText('tags')->nullable();
            $table->float('weight',11,4)->nullable();
            $table->float('height',11,4)->nullable();
            $table->float('width',11,4)->nullable();
            $table->float('length',11,4)->nullable();
            $table->string('title',255)->nullable();
            $table->string('desc',255)->nullable();
            $table->string('manufacturer',255)->nullable();
            $table->longText('ean13')->nullable();
            $table->longText('itf14')->nullable();
            $table->string('status', 255)->default(GlobalStatus::STATUS_ACTIVE);
            $table->longText('extra')->nullable();
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
        Schema::dropIfExists('products');
    }
}

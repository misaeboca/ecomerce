<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSharesTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shares_types', function (Blueprint $table) {
            $table->id('id_number');
            $table->string('id',255)->unique()->nullable();
            $table->string('id_store', 255)->nullable();
            $table->string('name')->nullable();
            $table->longText('description')->nullable();
            $table->longText('preview')->nullable();
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
        Schema::dropIfExists('shares_types');
    }
}

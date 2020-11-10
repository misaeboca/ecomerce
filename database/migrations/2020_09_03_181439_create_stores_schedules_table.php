<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores_schedules', function (Blueprint $table) {
            $table->id('id_number');
            $table->string('id_store',255)->nullable();
            $table->string('monday_opening')->nullable();
            $table->string('monday_closing')->nullable();
            $table->string('tuesday_opening')->nullable();
            $table->string('tuesday_closing')->nullable();
            $table->string('wednesday_opening')->nullable();
            $table->string('wednesday_closing')->nullable();
            $table->string('thursday_opening')->nullable();
            $table->string('thursday_closing')->nullable();
            $table->string('friday_opening')->nullable();
            $table->string('friday_closing')->nullable();
            $table->string('saturday_opening')->nullable();
            $table->string('saturday_closing')->nullable();
            $table->string('sunday_opening')->nullable();
            $table->string('sunday_closing')->nullable();
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
        Schema::dropIfExists('stores_schedules');
    }
}

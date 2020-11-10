<?php

use App\Models\GlobalStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients_deliveries', function (Blueprint $table) {
            $table->id('id_number');
            $table->string('id_client',255)->nullable();
            $table->string('id_delivery',255)->nullable();
            $table->string('status', 255)->default(GlobalStatus::STATUS_INACTIVE);
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
        Schema::dropIfExists('clients_deliveries');
    }
}

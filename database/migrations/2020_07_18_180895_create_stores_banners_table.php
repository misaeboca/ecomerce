<?php

use App\Models\GlobalStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores_banners', function (Blueprint $table) {
            $table->id('id_number');
            $table->string('id_banner',255)->nullable();
            $table->string('id_store',255)->nullable();
            $table->string('status', 255)->default(GlobalStatus::STATUS_ACTIVE);
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
        Schema::dropIfExists('stores_banners');
    }
}

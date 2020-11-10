<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterStoresClicksAddColumnIdSeller extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stores_clicks', function (Blueprint $table) {
            $table->string('register_date',15)->after('clicks')->nullable();
            $table->string('id_seller',255)->after('clicks')->nullable();
            $table->dropColumn('clicks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stores_clicks', function (Blueprint $table) {
            $table->longText('clicks')->after('id_store')->nullable();
            $table->dropColumn('id_seller');
            $table->dropColumn('register_date');
        });
    }
}

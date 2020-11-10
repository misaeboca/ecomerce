<?php

use App\Models\Common\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id('id_number');
            $table->string('id',255)->unique()->nullable();//unique order code
            $table->string('id_store',255)->nullable();//unique store code
            $table->string('id_seller',255)->nullable();//unique store code
            $table->string('id_share',255)->nullable();//unique share code
            $table->string('id_delivery',255)->nullable();//unique delivery code
            $table->string('id_payment',255)->nullable();//unique payment code
            $table->string('id_customer',255)->nullable();//unique customer code
            $table->string('id_customer_address', 255)->nullable();
            $table->longText('subtotal')->nullable();
            $table->string('total',255)->default('0.00');
            $table->string('status',255)->default(Order::STATUS_PENDING);
            $table->longText('observations')->nullable();
            $table->longText('payment_response')->nullable();
            $table->longText('delivery_cost')->nullable();
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
        Schema::dropIfExists('orders');
    }
}

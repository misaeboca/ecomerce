<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTablesAddIndexes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table)
        {
            $table->index('code');
        });

        Schema::table('stores', function(Blueprint $table)
        {
            $table->index('id_client');
            $table->index('sigla');
        });

        Schema::table('stores_users', function(Blueprint $table)
        {
            $table->index('id_user');
            $table->index('id_store');
        });

        Schema::table('products', function(Blueprint $table)
        {
            $table->index('id_client');
            $table->index('sku');
            $table->index('codProduct');
        });

        Schema::table('stores_products', function(Blueprint $table)
        {
            $table->index('id_store');
            $table->index('product');
            $table->index('cod');
            $table->index('sku');
        });

        Schema::table('products_images', function(Blueprint $table)
        {
            $table->index('product');
            $table->index('cod');
            $table->index('sku');
        });

        Schema::table('shares_types', function(Blueprint $table)
        {
            $table->index('id_store');
        });

        Schema::table('shares', function(Blueprint $table)
        {
            $table->index('id_share_type');
            $table->index('id_store');
            $table->index('id_user');
        });

        Schema::table('stores_clicks', function(Blueprint $table)
        {
            $table->index('id_store');
            $table->index('id_seller');
        });

        Schema::table('deliveries', function(Blueprint $table)
        {
            $table->index('slug');
        });

        Schema::table('payments', function(Blueprint $table)
        {
            $table->index('slug');
        });

        Schema::table('stores_customers', function(Blueprint $table)
        {
            $table->index('id_store');
            $table->index('id_customer');
        });

        Schema::table('orders', function(Blueprint $table)
        {
            $table->index('id_store');
            $table->index('id_seller');
            $table->index('id_share');
            $table->index('id_delivery');
            $table->index('id_payment');
            $table->index('id_customer');
            $table->index('id_customer_address');
            $table->index('register_date');
        });

        Schema::table('orders_products', function(Blueprint $table)
        {
            $table->index('id_order');
            $table->index('product');
            $table->index('cod');
            $table->index('sku');
        });

        Schema::table('customer_address', function(Blueprint $table)
        {
            $table->index('id_customer');
        });

        Schema::table('stores_loggi', function(Blueprint $table)
        {
            $table->index('id_store');
        });

        Schema::table('products_variations', function(Blueprint $table)
        {
            $table->index('product');
            $table->index('cod');
            $table->index('sku');
        });

        Schema::table('products_featureds', function(Blueprint $table)
        {
            $table->index('id_store');
            $table->index('sku');
        });

        Schema::table('clients', function(Blueprint $table)
        {
            $table->index('slug');
        });

        Schema::table('clients_payments', function(Blueprint $table)
        {
            $table->index('id_client');
            $table->index('id_payment');
        });

        Schema::table('clients_deliveries', function(Blueprint $table)
        {
            $table->index('id_client');
            $table->index('id_delivery');
        });

        Schema::table('categories', function(Blueprint $table)
        {
            $table->index('slug');
            $table->index('id_category');
        });

        Schema::table('materials', function(Blueprint $table)
        {
            $table->index('slug');
        });

        Schema::table('themes', function(Blueprint $table)
        {
            $table->index('slug');
        });

        Schema::table('customers_sellers', function(Blueprint $table)
        {
            $table->index('id_seller');
            $table->index('id_customer');
        });

        Schema::table('stores_schedules', function(Blueprint $table)
        {
            $table->index('id_store');
        });

        Schema::table('stores_braspag', function(Blueprint $table)
        {
            $table->index('id_store');
        });

        Schema::table('stores_cielo', function(Blueprint $table)
        {
            $table->index('id_store');
        });

        Schema::table('carts_shares', function(Blueprint $table)
        {
            $table->index('id_store');
            $table->index('id_user');
        });

        Schema::table('promotions', function(Blueprint $table)
        {
            $table->index('id');
            $table->index('id_client');
        });

        Schema::table('promotions_products', function(Blueprint $table)
        {
            $table->index('id_promotion');
            $table->index('id_store');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}

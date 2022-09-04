<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_seller_relations', function (Blueprint $table) {
            $table->id();
            $table->integer('seller_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->dateTime('sale_date')->nullable();
            $table->boolean('sale')->default(false);
            $table->dateTime('sell_date');
            $table->integer('quantity');
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
        Schema::dropIfExists('product_seller_relations');
    }
};

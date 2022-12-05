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
        Schema::create('digital_show_image_seller_relations', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('image_id');
            $table->boolean('heart')->default(false);
            $table->boolean('view_status')->default(false);
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
        Schema::dropIfExists('digital_show_image_seller_relations');
    }
};

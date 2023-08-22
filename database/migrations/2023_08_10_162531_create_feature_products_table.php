<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeatureProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feature_products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('title_id')->unsigned();
            $table->foreign('title_id')->references('id')->on('titles')->onDelete('cascade');
            $table->text('description');
            $table->string('master_image');
            $table->string('left_image');
            $table->string('right_image');
            $table->text('caption');
            $table->string('button_text');
            $table->string('button_link');
            $table->boolean('is_active')->default(true)->nullable();
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
        Schema::dropIfExists('feature_products');
    }
}

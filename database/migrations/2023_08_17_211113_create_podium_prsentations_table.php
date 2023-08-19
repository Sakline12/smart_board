<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePodiumPrsentationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('podium_prsentations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('title_id')->unsigned();
            $table->foreign('title_id')->references('id')->on('titles')->onDelete('cascade');
            $table->bigInteger('subtitle_id')->unsigned();
            $table->foreign('subtitle_id')->references('id')->on('sub_titles')->onDelete('cascade');
            $table->bigInteger('image_id_one')->unsigned();
            $table->foreign('image_id_one')->references('id')->on('podium_prsesntation_images')->onDelete('cascade');
            $table->bigInteger('image_id_two')->unsigned();
            $table->foreign('image_id_two')->references('id')->on('podium_prsesntation_images')->onDelete('cascade');
            $table->bigInteger('image_id_three')->unsigned();
            $table->foreign('image_id_three')->references('id')->on('podium_prsesntation_images')->onDelete('cascade');
            $table->text('name');
            $table->boolean('isActive')->default(true)->nullable();
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
        Schema::dropIfExists('podium_prsentations');
    }
}

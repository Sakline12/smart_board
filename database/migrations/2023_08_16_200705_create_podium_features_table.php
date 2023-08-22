<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePodiumFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('podium_features', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('title_id')->unsigned();
            $table->foreign('title_id')->references('id')->on('titles')->onDelete('cascade');
            $table->text('description');
            $table->string('background_image');
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
        Schema::dropIfExists('podium_features');
    }
}

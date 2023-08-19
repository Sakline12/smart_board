<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSignageSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('signage_sliders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('title_id')->unsigned()->nullable();
            $table->foreign('title_id')->references('id')->on('titles')->onDelete('cascade');
            $table->string('image_one');
            $table->string('image_two');
            $table->string('image_three');
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
        Schema::dropIfExists('signage_sliders');
    }
}

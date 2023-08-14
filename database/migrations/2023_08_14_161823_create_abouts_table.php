<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAboutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abouts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('header_title')->unsigned();
            $table->foreign('header_title')->references('id')->on('titles')->onDelete('cascade');
            $table->string('background_image');
            $table->string('question');
            $table->text('description');
            $table->string('image');
            $table->string('button_text');
            $table->string('button_link');
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
        Schema::dropIfExists('abouts');
    }
}

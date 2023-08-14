<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEducationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('educations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('header_title')->unsigned();
            $table->foreign('header_title')->references('id')->on('titles')->onDelete('cascade');
            $table->text('heading_description');
            $table->string('image');
            $table->string('title');
            $table->text('description');
            $table->string('button_text');
            $table->string('button_link');
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
        Schema::dropIfExists('educations');
    }
}

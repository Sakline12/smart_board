<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conferences', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('title_id')->unsigned();
            $table->foreign('title_id')->references('id')->on('titles')->onDelete('cascade');
            $table->text('description')->nullable();
            $table->string('master_image');
            $table->string('sub_image1');
            $table->string('sub_image2');
            $table->string('sub_image3');
            $table->string('sub_image4');
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
        Schema::dropIfExists('conferences');
    }
}

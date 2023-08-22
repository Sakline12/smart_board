<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHonorableClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('honorable_clients', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('title_id')->unsigned();
            $table->foreign('title_id')->references('id')->on('titles')->onDelete('cascade');
            $table->text('description')->nullable();
            $table->string('image');
            $table->string('link')->nullable();
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
        Schema::dropIfExists('honorable_clients');
    }
}

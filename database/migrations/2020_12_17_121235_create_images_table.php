<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            // $table->bigInteger('superhero_id')->unsigned();
            // $table->foreign('superhero_id')->references('id')->on('superheroes');
            $table->timestamps();
        });
        Schema::create('image_superhero', function (Blueprint $table) {
            $table->bigInteger('image_id')->unsigned();
            $table->bigInteger('superhero_id')->unsigned();
            $table->timestamps();
            $table->foreign('superhero_id')->references('id')->on('superheroes')->onDelete('cascade');
            $table->foreign('image_id')->references('id')->on('images');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('images_superheroes');
        Schema::dropIfExists('images');
    }
}

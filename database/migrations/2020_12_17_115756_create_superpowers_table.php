<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuperpowersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('superpowers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 128);
            $table->timestamps();
        });
        Schema::create('superpower_superhero', function (Blueprint $table) {
            $table->bigInteger('superhero_id')->unsigned();
            $table->bigInteger('superpower_id')->unsigned();
            $table->timestamps();
            $table->foreign('superhero_id')->references('id')->on('superheroes')->onDelete('cascade');
            $table->foreign('superpower_id')->references('id')->on('superpowers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('superpower_superhero');
        Schema::dropIfExists('superpowers');
    }
}

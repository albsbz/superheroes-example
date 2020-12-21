<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
        Schema::create('superhero_superpower', function (Blueprint $table) {
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
        Schema::dropIfExists('superhero_superpower');
        Schema::dropIfExists('superpowers');
    }
}

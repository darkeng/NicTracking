<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PosicionMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posiciones', function (Blueprint $table) {
            $table->increments('id');
            $table->double('velocidad');
            $table->integer('precision');
            $table->double('lat');
            $table->double('lon');
            $table->integer('altitud');
            $table->integer('precisionAlt');
            $table->double('direccion');
            $table->dateTime('fecha_registro');
            $table->integer('tracker_id')->unsigned();
            $table->timestamps();
            $table->foreign('tracker_id')->references('id')->on('trackers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posiciones');
    }
}

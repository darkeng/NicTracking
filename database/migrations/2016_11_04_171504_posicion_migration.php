<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

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
            $table->integer('precision')->default(2);
            $table->double('lat');
            $table->double('lon');
            $table->integer('altitud');
            $table->integer('precisionAlt')->default(4);
            $table->double('direccion');
            $table->dateTime('fecha_registro');
            $table->integer('tracker_id')->unsigned();
            $table->timestamps();
            $table->foreign('tracker_id')->references('id')->on('trackers')->onDelete('cascade');
        });
        DB::statement("ALTER TABLE posiciones MODIFY fecha_registro DATETIME(3) NOT NULL");
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTable73sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table73s', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('desa_id');

            $table->string('suspek')->nullable();
            $table->string('mikroskopis')->nullable();
            $table->string('rapid')->nullable();

            $table->string('l_positif')->nullable();
            $table->string('p_positif')->nullable();
            $table->string('pengobatan_standar')->nullable();

            $table->string('l_meninggal')->nullable();
            $table->string('p_meninggal')->nullable();

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
        Schema::dropIfExists('table73s');
    }
}

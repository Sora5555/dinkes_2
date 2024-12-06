<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTable86sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table86s', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('desa_id');

            $table->string('sasaran_6_11')->nullable();
            $table->string('hasil_vaksinasi_6_11')->nullable();

            $table->string('sasaran_12_17')->nullable();
            $table->string('hasil_vaksinasi_12_17')->nullable();

            $table->string('sasaran_18_59')->nullable();
            $table->string('hasil_vaksinasi_18_59')->nullable();

            $table->string('sasaran_60_up')->nullable();
            $table->string('hasil_vaksinasi_60_up')->nullable();

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
        Schema::dropIfExists('table86s');
    }
}

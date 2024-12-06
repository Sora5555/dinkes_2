<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTable83sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table83s', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('desa_id');

            $table->string('jasa_boga_terdaftar')->nullable();
            $table->string('jasa_boga_jumlah')->nullable();

            $table->string('restoran_terdaftar')->nullable();
            $table->string('restoran_jumlah')->nullable();

            $table->string('tpp_tertentu_terdaftar')->nullable();
            $table->string('tpp_tertentu_jumlah')->nullable();

            $table->string('depot_air_minum_terdaftar')->nullable();
            $table->string('depot_air_minum_jumlah')->nullable();

            $table->string('rumah_makan_terdaftar')->nullable();
            $table->string('rumah_makan_jumlah')->nullable();

            $table->string('kelompok_gerai_terdaftar')->nullable();
            $table->string('kelompok_gerai_jumlah')->nullable();

            $table->string('sentra_pangan_terdaftar')->nullable();
            $table->string('sentra_pangan_jumlah')->nullable();

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
        Schema::dropIfExists('table83s');
    }
}

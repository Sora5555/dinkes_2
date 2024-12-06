<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTable77sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table77s', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('desa_id');

            $table->string('kegiatan_deteksi')->nullable();
            $table->string('perempuan_30_50_tahun')->nullable();

            $table->string('jumlah_iva')->nullable();
            $table->string('jumlah_sadanis')->nullable();
            $table->string('jumlah_iva_positif')->nullable();
            $table->string('jumlah_curiga')->nullable();
            $table->string('jumlah_krioterapi')->nullable();
            $table->string('jumlah_iva_positif_dan_curiga_kanker_leher')->nullable();
            $table->string('jumlah_tumor')->nullable();
            $table->string('jumlah_kanker_payudara')->nullable();
            $table->string('jumlah_tumor_curiga_kanker_payudara_dirujuk')->nullable();

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
        Schema::dropIfExists('table77s');
    }
}

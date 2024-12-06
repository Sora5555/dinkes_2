<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTable71sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table71s', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_kejadian')->nullable();
            $table->string('jumlah_kec')->nullable();
            $table->string('jumlah_desa')->nullable();
            $table->string('diketahui')->nullable();
            $table->string('ditanggulangi')->nullable();
            $table->string('akhir')->nullable();
            $table->string('l_pen')->nullable();
            $table->string('p_pen')->nullable();

            $table->string('k_0_7_hari')->nullable();
            $table->string('k_8_28_hari')->nullable();
            $table->string('k_1_11_bulan')->nullable();
            $table->string('k_1_4_tahun')->nullable();
            $table->string('k_5_9_tahun')->nullable();
            $table->string('k_10_14_tahun')->nullable();
            $table->string('k_15_19_tahun')->nullable();
            $table->string('k_20_44_tahun')->nullable();
            $table->string('k_45_54_tahun')->nullable();
            $table->string('k_55_59_tahun')->nullable();
            $table->string('k_60_69_tahun')->nullable();
            $table->string('k_70_plus_tahun')->nullable();

            $table->string('l_mati')->nullable();
            $table->string('p_mati')->nullable();

            $table->string('l_penduduk')->nullable();
            $table->string('p_penduduk')->nullable();



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
        Schema::dropIfExists('table71s');
    }
}

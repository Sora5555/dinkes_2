<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTable74sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table74s', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('desa_id');

            $table->string('kronis_t_sebelumnya_l')->nullable();
            $table->string('kronis_t_sebelumnya_p')->nullable();

            $table->string('kronis_b_ditemukan_l')->nullable();
            $table->string('kronis_b_ditemukan_p')->nullable();

            $table->string('kronis_pindah_l')->nullable();
            $table->string('kronis_pindah_p')->nullable();

            $table->string('kronis_meninggal_l')->nullable();
            $table->string('kronis_meninggal_p')->nullable();

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
        Schema::dropIfExists('table74s');
    }
}

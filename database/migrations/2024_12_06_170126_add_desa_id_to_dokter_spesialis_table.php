<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDesaIdToDokterSpesialisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dokter_spesialis', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('desa_id')->nullable();
        });

        Schema::table('dokters', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('desa_id')->nullable();
        });

        Schema::table('dokter_gigis', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('desa_id')->nullable();
        });

        Schema::table('dokter_gigi_spesialis', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('desa_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dokter_spesialis', function (Blueprint $table) {
            //
        });
    }
}

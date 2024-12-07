<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDesaIdToPejabatStrukturalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pejabat_strukturals', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('desa_id')->nullable();
        });

        Schema::table('tenaga_pendidiks', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('desa_id')->nullable();
        });

        Schema::table('manajemens', function (Blueprint $table) {
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
        Schema::table('pejabat_strukturals', function (Blueprint $table) {
            //
        });
    }
}

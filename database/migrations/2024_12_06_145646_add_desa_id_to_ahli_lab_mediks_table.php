<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDesaIdToAhliLabMediksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ahli_lab_mediks', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('desa_id')->nullable();
        });

        Schema::table('tenaga_teknik_biomediks', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('desa_id')->nullable();
        });

        Schema::table('terapi_fisiks', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('desa_id')->nullable();
        });

        Schema::table('keteknisan_mediks', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('desa_id')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     *
     *
     *
     *
     *
     */
    public function down()
    {
        Schema::table('ahli_lab_mediks', function (Blueprint $table) {
            //
        });
    }
}

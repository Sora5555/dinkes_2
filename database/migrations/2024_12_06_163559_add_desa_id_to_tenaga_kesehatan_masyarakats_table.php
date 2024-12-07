<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDesaIdToTenagaKesehatanMasyarakatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tenaga_kesehatan_masyarakats', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('desa_id')->nullable();
        });

        Schema::table('tenaga_kesehatan_lingkungans', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('desa_id')->nullable();
        });

        Schema::table('tenaga_gizis', function (Blueprint $table) {
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
        Schema::table('tenaga_kesehatan_masyarakats', function (Blueprint $table) {
            //
        });
    }
}

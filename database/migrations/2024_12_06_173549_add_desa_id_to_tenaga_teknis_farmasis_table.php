<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDesaIdToTenagaTeknisFarmasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tenaga_teknis_farmasis', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('desa_id')->nullable();
        });

        Schema::table('apotekers', function (Blueprint $table) {
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
        Schema::table('tenaga_teknis_farmasis', function (Blueprint $table) {
            //
        });
    }
}

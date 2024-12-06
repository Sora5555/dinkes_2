<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTable69sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table69s', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('desa_id');

            $table->string('difteri_l');
            $table->string('difteri_p');
            $table->string('difteri_lp');
            $table->string('difteri_m');

            $table->string('pertusis_l');
            $table->string('pertusis_p');
            $table->string('pertusis_lp');

            $table->string('tetanus_neonatorum_l');
            $table->string('tetanus_neonatorum_p');
            $table->string('tetanus_neonatorum_lp');
            $table->string('tetanus_neonatorum_m');

            $table->string('hepatitis_l');
            $table->string('hepatitis_p');
            $table->string('hepatitis_lp');

            $table->string('suspek_campak_l');
            $table->string('suspek_campak_p');
            $table->string('suspek_campak_lp');

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
        Schema::dropIfExists('table69s');
    }
}

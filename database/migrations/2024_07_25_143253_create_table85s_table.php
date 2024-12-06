<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTable85sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table85s', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('desa_id');

            $table->string('l_0_4')->nullable();
            $table->string('p_0_4')->nullable();

            $table->string('l_5_6')->nullable();
            $table->string('p_5_6')->nullable();

            $table->string('l_7_14')->nullable();
            $table->string('p_7_14')->nullable();

            $table->string('l_15_59')->nullable();
            $table->string('p_15_59')->nullable();

            $table->string('l_60_up')->nullable();
            $table->string('p_60_up')->nullable();

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
        Schema::dropIfExists('table85s');
    }
}

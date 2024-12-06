<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTable82sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table82s', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('desa_id');
            $table->string('sd')->nullable();
            $table->string('smp')->nullable();
            $table->string('puskesmas')->nullable();
            $table->string('pasar')->nullable();

            $table->string('m_sd')->nullable();
            $table->string('m_smp')->nullable();
            $table->string('m_puskesmas')->nullable();
            $table->string('m_pasar')->nullable();
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
        Schema::dropIfExists('table82s');
    }
}

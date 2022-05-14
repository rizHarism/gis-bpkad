<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemeliharaanInventarisCTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemeliharaan_inventaris_c', function (Blueprint $table) {
            $table->id();
            $table->string('inventaris_id');
            $table->text('nama_pemeliharaan');
            $table->Integer('tahun_pemeliharaan');
            $table->bigInteger('nilai_aset');
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
        Schema::dropIfExists('pemeliharaan_inventaris_c');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventarisCTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventaris_c', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('id_inventaris');
            $table->string('jenis_inventaris')->default('C');
            $table->text('nama');
            $table->string('no_register')->nullable();
            $table->integer('tahun_perolehan');
            $table->bigInteger('nilai_aset');
            $table->integer('luas');
            $table->string('status');
            $table->string('kode_gedung')->nullable();
            $table->string('alamat');
            $table->integer('kelurahan_id');
            $table->integer('kecamatan_id');
            $table->string('kondisi_bangunan');
            $table->string('jenis_bangunan');
            $table->string('jenis_konstruksi');
            // $table->string('no_dokumen_sertifikat')->nullable();
            $table->integer('skpd_id');
            $table->integer('master_barang_id');
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
        Schema::dropIfExists('inventaris_c');
    }
}

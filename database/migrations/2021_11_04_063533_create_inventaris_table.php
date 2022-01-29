<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventarisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventaris', function (Blueprint $table) {
            // $table->integer('id_inventaris');
            $table->bigIncrements('id');
            $table->string('jenis_inventaris')->default('A');
            $table->string('nama');
            $table->integer('tahun_perolehan');
            $table->integer('nilai_aset');
            $table->integer('luas');
            $table->boolean('status');
            $table->string('alamat')->nullable();
            $table->string('no_dokumen_sertifikat')->nullable();
            $table->integer('skpd_id');
            $table->integer('master_barang_id');
            // $table->integer('galery_id');
            // $table->integer('document_id');
            // $table->integer('geometry_id')->nullable();
            // $table->string('nama_skpd');
            // $table->string('kode_master_barang');
            // $table->string('nama_master_barang');
            // $table->string('tgl_perolehan');
            // $table->integer('harga_beli');
            // $table->string('no_sertifikat')->nullable();
            // $table->string('tgl_sertifikat')->nullable();
            // $table->string('deskripsi')->nullable();
            // $table->string('sumber_dana');
            // $table->integer('nilai_buku');
            // $table->integer('penyusutan')->nullable();
            // $table->integer('nilai_sekarang');
            // $table->json('point')->nullable();
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
        Schema::dropIfExists('inventaris');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDatabaseAddKelurahanKecamatanAndSomeChangeColumnName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('kelurahan', function (Blueprint $table) {
            $table->increments('id_kelurahan');
            $table->string('nama_kelurahan');
            // $table->string('doc_path');
            $table->timestamps();
        });

        Schema::create('kecamatan', function (Blueprint $table) {
            $table->increments('id_kecamatan');
            $table->string('nama_kecamatan');
            // $table->string('doc_path');
            $table->timestamps();
        });

        Schema::table('inventaris', function (Blueprint $table) {
            $table->bigInteger('nilai_aset')->change();
        });

        Schema::table('inventaris', function (Blueprint $table) {
            $table->string('kelurahan_id')->after('alamat')->nullable();
            $table->string('kecamatan_id')->after('alamat')->nullable();
        });

        Schema::table('master_skpd', function (Blueprint $table) {
            $table->renameColumn('id', 'id_skpd');
            $table->renameColumn('nama', 'nama_skpd');
        });

        Schema::table('master_barang', function (Blueprint $table) {
            $table->renameColumn('id', 'id_barang');
            $table->renameColumn('nama', 'nama_barang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('kelurahan');
        Schema::drop('kecamatan');

        Schema::table('inventaris', function (Blueprint $table) {
            $table->Integer('nilai_aset')->change();
        });

        Schema::table('inventaris', function (Blueprint $table) {
            $table->dropColumn('kelurahan_id');
            $table->dropColumn('kecamatan_id');
        });

        Schema::table('master_skpd', function (Blueprint $table) {
            $table->renameColumn('id_skpd', 'id');
            $table->renameColumn('nama_skpd', 'nama');
        });

        Schema::table('master_barang', function (Blueprint $table) {
            $table->renameColumn('id_barang', 'id');
            $table->renameColumn('nama_barang', 'nama');
        });
    }
}

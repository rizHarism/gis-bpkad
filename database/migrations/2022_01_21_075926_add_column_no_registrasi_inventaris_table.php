<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnNoRegistrasiInventarisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //add column no_register
        Schema::table('inventaris', function (Blueprint $table) {
            $table->string('no_register')->after('nama');
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
        Schema::table('inventaris', function (Blueprint $table) {
            $table->dropColumn('no_register');
        });
    }
}

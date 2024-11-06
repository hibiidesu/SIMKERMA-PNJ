<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMitraKemitraanProdiToKerjasamasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kerjasamas', function (Blueprint $table) {
            // $table->string('kriteria_kemitraan_id');
            // $table->string('kriteria_mitra_id');
            $table->string('prodi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kerjasamas', function (Blueprint $table) {

            // $table->dropColumn('kriteria_kemitraan');
            $table->dropColumn('prodi_id');
            // $table->dropColumn('kriteria_mitra');
        });
    }
}

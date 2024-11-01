<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepositoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repositories', function (Blueprint $table) {
            $table->id();
            $table->string("mitra")->nullable();
            $table->integer("kerjasama_id");
            $table->integer("user_id");
            $table->string("kerjasama");
            $table->date("tanggal_mulai");
            $table->date("tanggal_selesai");
            $table->string("nomor");
            $table->text("kegiatan");
            $table->string("jenis_kerjasama_id");
            $table->string("kriteria_mitra_id");
            $table->string("kriteria_kemitraan_id");
            $table->string("sifat");
            $table->string("pks");
            $table->string("jurusan");
            $table->string("prodi");
            $table->string("pic_pnj")->nullable();
            $table->text("alamat_perusahaan")->nullable();
            $table->string("pic_industri")->nullable();
            $table->string("jabatan_pic_industri")->nullable()->default("");
            $table->string("telp_industri")->nullable();
            $table->string("email")->nullable();
            $table->text("file");
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
        Schema::dropIfExists('repositories');
    }
}

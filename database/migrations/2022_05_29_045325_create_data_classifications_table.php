<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_classifications', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('asal_sekolah');
            $table->string('usia');
            $table->string('pendidikan');
            $table->string('tipe_institusi');
            $table->string('keadaan_keuangan');
            $table->string('tipe_internet');
            $table->string('tipe_jaringan');
            $table->string('durasi_kelas');
            $table->string('perangkat');
            $table->string('nilai_prob_rendah');
            $table->string('nilai_prob_sedang');
            $table->string('nilai_prob_tinggi');
            $table->string('tingkat_adaptabilitas');
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
        Schema::dropIfExists('data_classifications');
    }
};

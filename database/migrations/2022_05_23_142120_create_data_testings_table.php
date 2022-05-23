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
        Schema::create('data_testings', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_kelamin');
            $table->string('umur');
            $table->string('pendidikan');
            $table->string('tipe_institusi');
            $table->string('keadaan_keuangan');
            $table->string('tipe_internet');
            $table->string('tipe_jaringan');
            $table->string('durasi_kelas');
            $table->string('perangkat');
            $table->string('tingkat_adaptabilitas');
            $table->string('nilai_prob_rendah')->nullable();
            $table->string('nilai_prob_sedang')->nullable();
            $table->string('nilai_prob_tinggi')->nullable();
            $table->string('hasil_prediksi')->nullable();
            $table->string('prediksi_valid')->nullable();
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
        Schema::dropIfExists('data_testings');
    }
};

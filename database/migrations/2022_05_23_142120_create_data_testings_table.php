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
            $table->enum('jenis_kelamin', ['Laki - laki', 'Perempuan']);
            $table->enum('usia', ['1-5', '6-10', '11-15', '16-20', '21-25', '26-30']);
            $table->enum('pendidikan', ['Perguruan Tinggi', 'Sekolah (SD,SMP,SMA)']);
            $table->enum('tipe_institusi', ['Negeri', 'Swasta']);
            $table->enum('keadaan_keuangan', ['Menengah Keatas', 'Menengah Kebawah', 'Mampu']);
            $table->enum('tipe_internet', ['Wifi', 'Paket Data']);
            $table->enum('tipe_jaringan', ['2G', '3G', '4G']);
            $table->enum('durasi_kelas', ['1-3', '3-6']);
            $table->enum('perangkat', ['Komputer', 'Tablet', 'Smartphone']);
            $table->enum('tingkat_adaptabilitas', ['Rendah', 'Sedang', 'Tinggi']);
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

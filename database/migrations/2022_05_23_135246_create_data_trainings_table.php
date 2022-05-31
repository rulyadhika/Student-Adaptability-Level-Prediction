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
        Schema::create('data_trainings', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis_kelamin', ['Boy', 'Girl']);
            $table->enum('usia', ['1-5', '6-10', '11-15', '16-20', '21-25', '26-30']);
            $table->enum('pendidikan', ['University', 'College', 'School']);
            $table->enum('tipe_institusi', ['Government', 'Non Government']);
            $table->enum('keadaan_keuangan', ['Mid', 'Poor', 'Rich']);
            $table->enum('tipe_internet', ['Wifi', 'Mobile Data']);
            $table->enum('tipe_jaringan', ['2G', '3G', '4G']);
            $table->enum('durasi_kelas', ['1-3', '3-6']);
            $table->enum('perangkat', ['Computer', 'Tab', 'Mobile']);
            $table->enum('tingkat_adaptabilitas', ['Low', 'Moderate', 'High']);
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
        Schema::dropIfExists('data_trainings');
    }
};

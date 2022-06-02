<?php

namespace App\Imports;

use App\Models\DataTraining;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DataTrainingImport implements ToModel, WithBatchInserts, WithStartRow, WithHeadingRow
{

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new DataTraining([
            'jenis_kelamin' => $row['jenis_kelamin'],
            'usia' => $row['usia'],
            'pendidikan' => $row['pendidikan'],
            'tipe_institusi' => $row['tipe_institusi'],
            'keadaan_keuangan' => $row['keadaan_keuangan'],
            'tipe_internet' => $row['tipe_internet'],
            'tipe_jaringan' => $row['tipe_jaringan'],
            'durasi_kelas' => $row['durasi_kelas'],
            'perangkat' => $row['perangkat'],
            'tingkat_adaptabilitas' => $row['tingkat_adaptabilitas']
        ]);
    }

    public function batchSize(): int
    {
        return 1000;
    }

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }
}

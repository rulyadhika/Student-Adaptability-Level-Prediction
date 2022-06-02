<?php

namespace App\Imports;

use App\Models\DataTesting;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DataTestingImport implements ToCollection, WithStartRow, WithHeadingRow
{

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            DataTesting::create([
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
    }

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }

}

<?php

namespace App\Imports;

use App\Models\DataTesting;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class DataTestingImport implements ToCollection, WithStartRow
{

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            DataTesting::create([
                'jenis_kelamin' => $row['0'],
                'umur' => $row['1'],
                'pendidikan' => $row['2'],
                'tipe_institusi' => $row['3'],
                'keadaan_keuangan' => $row['7'],
                'tipe_internet' => $row['8'],
                'tipe_jaringan' => $row['9'],
                'durasi_kelas' => $row['10'],
                'perangkat' => $row['12'],
                'tingkat_adaptabilitas' => $row['13']
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

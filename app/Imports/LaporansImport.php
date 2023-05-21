<?php

namespace App\Imports;

use App\Models\Laporan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Facades\Excel;

class LaporansImport implements ToModel, WithStartRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function startRow(): int
    {
        return 3;
    }
    public function model(array $row)
    {
        return new Laporan([
            'tanggal' => date('Y-m-d', strtotime(str_replace('/', '-', $row[1]))) . ' ' . $row[2],
            'waktu' => $row[2],
            'username' => $row[3],
            'profil' => $row[4],
            'komentar' => $row[5],
            'harga' => $row[6]
        ]);
    }
}

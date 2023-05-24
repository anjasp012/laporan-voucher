<?php

namespace App\Http\Controllers;

use App\Http\Resources\LaporanResource;
use App\Imports\LaporansImport;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index()
    {
        return view('pages.laporan.index');
    }

    public function dataTable()
    {
        $hari = request('h') == "Hari" ? false : request('h');
        $bulan = request('b') == "Bulan" ? false : request('b');
        $tahun = request('t') == "Tahun" ? false : request('t');
        $paginate = request('paginate') ?? '10';
        $live = request('live');
        $columns = [
            'tanggal',
            'waktu',
            'username',
            'profil',
            'komentar',
            'harga'
        ];

        if ($hari && !$bulan & !$tahun) {
            if ($live != '') {
                $query = Laporan::query();
                foreach ($columns as $column) {
                    $query->orWhere($column, 'LIKE', $live . '%')->whereDay('tanggal', $hari);
                }
                $total =  $query->get();
                $laporans = $query->paginate($paginate)->withQueryString();
            } else {
                $query = Laporan::query()->whereDay('tanggal', $hari);
                $total =  $query->get();
                $laporans = $query->paginate($paginate)->withQueryString();
            }
            $title = 'Laporan penjualan tanggal ' . $hari;
        } elseif ($hari && $bulan && !$tahun) {
            if ($live != '') {
                $query = Laporan::query();
                foreach ($columns as $column) {
                    $query->orWhere($column, 'LIKE', $live . '%')->whereDay('tanggal', $hari)->whereMonth('tanggal', $bulan);
                }
                $total =  $query->get();
                $laporans = $query->paginate($paginate)->withQueryString();
            } else {
                $query = Laporan::query()->whereDay('tanggal', $hari)->whereMonth('tanggal', $bulan);
                $total =  $query->get();
                $laporans = $query->paginate($paginate)->withQueryString();
            }
            $title = 'Laporan penjualan tanggal ' . $hari . ' bulan ' . date("F", mktime(0, 0, 0, $bulan, 10));
        } elseif ($hari && $bulan && $tahun) {
            if ($live != '') {
                $query = Laporan::query();
                foreach ($columns as $column) {
                    $query->orWhere($column, 'LIKE', $live . '%')->whereDay('tanggal', $hari)->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
                }
                $total =  $query->get();
                $laporans = $query->paginate($paginate)->withQueryString();
            } else {
                $query = Laporan::query()->whereDay('tanggal', $hari)->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
                $total =  $query->get();
                $laporans = $query->paginate($paginate)->withQueryString();
            }
            $title = 'Laporan penjualan tanggal ' . $hari . ' bulan ' . date("F", mktime(0, 0, 0, $bulan, 10)) . ' tahun ' . $tahun;
        } elseif (!$hari && $bulan && !$tahun) {
            if ($live != '') {
                $query = Laporan::query();
                foreach ($columns as $column) {
                    $query->orWhere($column, 'LIKE', $live . '%')->whereMonth('tanggal', $bulan);
                }
                $total =  $query->get();
                $laporans = $query->paginate($paginate)->withQueryString();
            } else {
                $query = Laporan::query()->whereMonth('tanggal', $bulan);
                $total =  $query->get();
                $laporans = $query->paginate($paginate)->withQueryString();
            }
            $title = 'Laporan penjualan bulan ' . date("F", mktime(0, 0, 0, $bulan, 10));
        } elseif (!$hari && !$bulan && $tahun) {
            if ($live != '') {
                $query = Laporan::query();
                foreach ($columns as $column) {
                    $query->orWhere($column, 'LIKE', $live . '%')->whereYear('tanggal', $tahun);
                }
                $total =  $query->get();
                $laporans = $query->paginate($paginate)->withQueryString();
            } else {
                $query = Laporan::query()->whereYear('tanggal', $tahun);
                $total =  $query->get();
                $laporans = $query->paginate($paginate)->withQueryString();
            }
            $title = 'Laporan penjualan tahun ' . $tahun;
        } elseif (!$hari && $bulan && $tahun) {
            if ($live != '') {
                $query = Laporan::query();
                foreach ($columns as $column) {
                    $query->orWhere($column, 'LIKE', $live . '%')->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
                }
                $total =  $query->get();
                $laporans = $query->paginate($paginate)->withQueryString();
            } else {
                $query = Laporan::query()->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
                $total =  $query->get();
                $laporans = $query->paginate($paginate)->withQueryString();
            }
            $title = 'Laporan penjualan bulan ' . date("F", mktime(0, 0, 0, $bulan, 10)) . ' tahun ' . $tahun;
        } elseif ($hari && !$bulan && $tahun) {
            if ($live != '') {
                $query = Laporan::query();
                foreach ($columns as $column) {
                    $query->orWhere($column, 'LIKE', $live . '%')->whereDay('tanggal', $hari)->whereYear('tanggal', $tahun);
                }
                $total =  $query->get();
                $laporans = $query->paginate($paginate)->withQueryString();
            } else {
                $query = Laporan::query()->whereDay('tanggal', $hari)->whereYear('tanggal', $tahun);
                $total =  $query->get();
                $laporans = $query->paginate($paginate)->withQueryString();
            }
            $title = 'Laporan penjualan hari ' . $hari . ' tahun ' . $tahun;
        } else {
            if ($live != '') {
                $query = Laporan::query();
                foreach ($columns as $column) {
                    $query->orWhere($column, 'LIKE', $live . '%');
                }
                $total =  $query->get();
                $laporans = $query->paginate($paginate)->withQueryString();
            } else {
                $query = Laporan::query();
                $total =  $query->get();
                $laporans = $query->paginate($paginate)->withQueryString();
            }
            $title = 'Laporan Semua Penjualan';
        }

        $jumlah = $total->count();
        $totals =  number_format($total->sum('harga'), '0', '.', '.');
        return LaporanResource::collection($laporans)->additional([
            'total' => $totals,
            'title' => $title,
            'jumlah' => $jumlah,
        ]);
    }

    public function import()
    {
        // dd(request()->all());
        Excel::import(new LaporansImport, request()->file('laporan'));
        return back();
    }

    public function edit(string $id)
    {
        $laporan = Laporan::find($id);
        return view('pages.laporan.edit', [
            'laporan' => $laporan
        ]);
    }

    public function update(Request $request, string $id)
    {
        $laporan = Laporan::find($id);
        $laporan->update($request->all());
        return redirect(route('home'));
    }

    public function destroy(string $id)
    {
        $laporan = Laporan::find($id);
        $laporan->delete();
        return back();
    }
}

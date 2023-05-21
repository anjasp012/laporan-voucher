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
        $column = [
            'username',
            'profile',
            'komentar',
            'harga'
        ];

        if ($hari && !$bulan & !$tahun) {
            if ($live != '') {
                $total =  Laporan::query()->whereDay('tanggal', $hari)->where('username', 'like', '%' . $live . '%')->orWhere('profil', 'like', '%' . $live . '%')->orWhere('komentar', 'like', '%' . $live . '%')->orWhere('harga', 'like', '%' . $live . '%')->get();
                $laporans =  Laporan::query()->whereDay('tanggal', $hari)->where('username', 'like', '%' . $live . '%')->orWhere('profil', 'like', '%' . $live . '%')->orWhere('komentar', 'like', '%' . $live . '%')->orWhere('harga', 'like', '%' . $live . '%')->paginate($paginate)->withQueryString();
            }
            $total =  Laporan::query()->whereDay('tanggal', $hari)->get();
            $laporans =  Laporan::query()->whereDay('tanggal', $hari)->paginate($paginate)->withQueryString();
            $title = 'Laporan penjualan tanggal ' . $hari;
        } elseif ($hari && $bulan && !$tahun) {
            if ($live != '') {
                $total =  Laporan::query()->whereDay('tanggal', $hari)->whereMonth('tanggal', $bulan)->where('username', 'like', '%' . $live . '%')->orWhere('profil', 'like', '%' . $live . '%')->orWhere('komentar', 'like', '%' . $live . '%')->orWhere('harga', 'like', '%' . $live . '%')->get();
                $laporans =  Laporan::query()->whereDay('tanggal', $hari)->whereMonth('tanggal', $bulan)->where('username', 'like', '%' . $live . '%')->orWhere('profil', 'like', '%' . $live . '%')->orWhere('komentar', 'like', '%' . $live . '%')->orWhere('harga', 'like', '%' . $live . '%')->paginate($paginate)->withQueryString();
            }
            $total =  Laporan::query()->whereDay('tanggal', $hari)->whereMonth('tanggal', $bulan)->get();
            $laporans =  Laporan::query()->whereDay('tanggal', $hari)->whereMonth('tanggal', $bulan)->paginate($paginate)->withQueryString();
            $title = 'Laporan penjualan tanggal ' . $hari . ' bulan ' . date("F", mktime(0, 0, 0, $bulan, 10));
        } elseif ($hari && $bulan && $tahun) {
            if ($live != '') {
                $total =  Laporan::query()->whereDay('tanggal', $hari)->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('username', 'like', '%' . $live . '%')->orWhere('profil', 'like', '%' . $live . '%')->orWhere('komentar', 'like', '%' . $live . '%')->orWhere('harga', 'like', '%' . $live . '%')->get();
                $laporans =  Laporan::query()->whereDay('tanggal', $hari)->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('username', 'like', '%' . $live . '%')->orWhere('profil', 'like', '%' . $live . '%')->orWhere('komentar', 'like', '%' . $live . '%')->orWhere('harga', 'like', '%' . $live . '%')->paginate($paginate)->withQueryString();
            }
            $total =  Laporan::query()->whereDay('tanggal', $hari)->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->get();
            $laporans =  Laporan::query()->whereDay('tanggal', $hari)->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->paginate($paginate)->withQueryString();
            $title = 'Laporan penjualan tanggal ' . $hari . ' bulan ' . date("F", mktime(0, 0, 0, $bulan, 10)) . ' tahun ' . $tahun;
        } elseif (!$hari && $bulan && !$tahun) {
            if ($live != '') {
                $total =  Laporan::query()->whereMonth('tanggal', $bulan)->where('username', 'like', '%' . $live . '%')->orWhere('profil', 'like', '%' . $live . '%')->orWhere('komentar', 'like', '%' . $live . '%')->orWhere('harga', 'like', '%' . $live . '%')->get();
                $laporans =  Laporan::query()->whereMonth('tanggal', $bulan)->where('username', 'like', '%' . $live . '%')->orWhere('profil', 'like', '%' . $live . '%')->orWhere('komentar', 'like', '%' . $live . '%')->orWhere('harga', 'like', '%' . $live . '%')->paginate($paginate)->withQueryString();
            }
            $total =  Laporan::query()->whereMonth('tanggal', $bulan)->get();
            $laporans =  Laporan::query()->whereMonth('tanggal', $bulan)->paginate($paginate)->withQueryString();
            $title = 'Laporan penjualan bulan ' . date("F", mktime(0, 0, 0, $bulan, 10));
        } elseif (!$hari && !$bulan && $tahun) {
            if ($live != '') {
                $total =  Laporan::query()->whereYear('tanggal', $tahun)->where('username', 'like', '%' . $live . '%')->orWhere('profil', 'like', '%' . $live . '%')->orWhere('komentar', 'like', '%' . $live . '%')->orWhere('harga', 'like', '%' . $live . '%')->get();
                $laporans =  Laporan::query()->whereYear('tanggal', $tahun)->where('username', 'like', '%' . $live . '%')->orWhere('profil', 'like', '%' . $live . '%')->orWhere('komentar', 'like', '%' . $live . '%')->orWhere('harga', 'like', '%' . $live . '%')->paginate($paginate)->withQueryString();
            }
            $total =  Laporan::query()->whereYear('tanggal', $tahun)->get();
            $laporans =  Laporan::query()->whereYear('tanggal', $tahun)->paginate($paginate)->withQueryString();
            $title = 'Laporan penjualan tahun ' . $tahun;
        } elseif (!$hari && $bulan && $tahun) {
            if ($live != '') {
                $total =  Laporan::query()->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('username', 'like', '%' . $live . '%')->orWhere('profil', 'like', '%' . $live . '%')->orWhere('komentar', 'like', '%' . $live . '%')->orWhere('harga', 'like', '%' . $live . '%')->get();
                $laporans =  Laporan::query()->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('username', 'like', '%' . $live . '%')->orWhere('profil', 'like', '%' . $live . '%')->orWhere('komentar', 'like', '%' . $live . '%')->orWhere('harga', 'like', '%' . $live . '%')->paginate($paginate)->withQueryString();
            }
            $total =  Laporan::query()->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->get();
            $laporans =  Laporan::query()->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->paginate($paginate)->withQueryString();
            $title = 'Laporan penjualan bulan ' . date("F", mktime(0, 0, 0, $bulan, 10)) . ' tahun ' . $tahun;
        } elseif ($hari && !$bulan && $tahun) {
            if ($live != '') {
                $laporans =  Laporan::query()->whereDay('tanggal', $hari)->whereYear('tanggal', $tahun)->where('username', 'like', '%' . $live . '%')->orWhere('profil', 'like', '%' . $live . '%')->orWhere('komentar', 'like', '%' . $live . '%')->orWhere('harga', 'like', '%' . $live . '%')->get();
                $laporans =  Laporan::query()->whereDay('tanggal', $hari)->whereYear('tanggal', $tahun)->where('username', 'like', '%' . $live . '%')->orWhere('profil', 'like', '%' . $live . '%')->orWhere('komentar', 'like', '%' . $live . '%')->orWhere('harga', 'like', '%' . $live . '%')->paginate($paginate)->withQueryString();
            }
            $total =  Laporan::query()->whereDay('tanggal', $hari)->whereYear('tanggal', $tahun)->get();
            $laporans =  Laporan::query()->whereDay('tanggal', $hari)->whereYear('tanggal', $tahun)->paginate($paginate)->withQueryString();
            $title = 'Laporan penjualan hari ' . $hari . ' tahun ' . $tahun;
        } else {
            if ($live != '') {
                $total =  Laporan::query()->where('username', 'like', '%' . $live . '%')->orWhere('profil', 'like', '%' . $live . '%')->orWhere('komentar', 'like', '%' . $live . '%')->orWhere('harga', 'like', '%' . $live . '%')->get();
                $laporans =  Laporan::query()->where('username', 'like', '%' . $live . '%')->orWhere('profil', 'like', '%' . $live . '%')->orWhere('komentar', 'like', '%' . $live . '%')->orWhere('harga', 'like', '%' . $live . '%')->paginate($paginate);
            }
            $total =  Laporan::query()->where('username', 'like', '%' . $live . '%')->get();
            $laporans =  Laporan::query()->where('username', 'like', '%' . $live . '%')->paginate($paginate);
            $title = 'Laporan Semua Penjualan';
        }

        $totals =  number_format($total->sum('harga'), '0', '.', '.');
        return LaporanResource::collection($laporans)->additional([
            'total' => $totals,
            'title' => $title,
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

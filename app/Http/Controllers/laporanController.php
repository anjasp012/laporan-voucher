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

        if ($hari && !$bulan & !$tahun) {
            $laporans =  Laporan::whereDay('tanggal', $hari)->get();
            $title = 'Laporan penjualan tanggal ' . $hari;
        } elseif ($hari && $bulan && !$tahun) {
            $laporans =  Laporan::whereDay('tanggal', $hari)->whereMonth('tanggal', $bulan)->get();
            $title = 'Laporan penjualan tanggal ' . $hari . ' bulan ' . date("F", mktime(0, 0, 0, $bulan, 10));
        } elseif ($hari && $bulan && $tahun) {
            $laporans =  Laporan::whereDay('tanggal', $hari)->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->get();
            $title = 'Laporan penjualan tanggal ' . $hari . ' bulan ' . date("F", mktime(0, 0, 0, $bulan, 10)) . ' tahun ' . $tahun;
        } elseif (!$hari && $bulan && !$tahun) {
            $laporans =  Laporan::whereMonth('tanggal', $bulan)->get();
            $title = 'Laporan penjualan bulan ' . date("F", mktime(0, 0, 0, $bulan, 10));
        } elseif (!$hari && !$bulan && $tahun) {
            $laporans =  Laporan::whereYear('tanggal', $tahun)->get();
            $title = 'Laporan penjualan tahun ' . $tahun;
        } elseif (!$hari && $bulan && $tahun) {
            $laporans =  Laporan::whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->get();
            $title = 'Laporan penjualan bulan ' . date("F", mktime(0, 0, 0, $bulan, 10)) . ' tahun ' . $tahun;
        } elseif ($hari && !$bulan && $tahun) {
            $laporans =  Laporan::whereDay('tanggal', $hari)->whereYear('tanggal', $tahun)->get();
            $title = 'Laporan penjualan hari ' . $hari . ' tahun ' . $tahun;
        } else {
            $laporans =  Laporan::get();
            $title = 'Laporan Semua Penjualan';
        }

        $total =  number_format($laporans->sum('harga'), '0', '.', '.');
        return LaporanResource::collection($laporans)->additional([
            'total' => $total,
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

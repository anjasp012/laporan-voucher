@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Home</div>

                    <div class="card-body">
                        <div class="d-flex mb-3 justify-content-between">
                            <form action="" class="">
                                <div class="input-group">


                                    <select name="day" id="day" class="form-select">
                                        <option selected disabled>Hari</option>
                                        @for ($i = 0; $i < 31; $i++)
                                            <option value="{{ $i + 1 }}">{{ $i + 1 }}</option>
                                        @endfor
                                    </select>

                                    <select name="month" id="month" class="form-select">

                                        <option selected disabled>Bulan</option>
                                        <option value="1">Januari</option>
                                        <option value="2">Februari</option>
                                        <option value="3">Maret</option>
                                        <option value="4">April</option>
                                        <option value="5">Mei</option>
                                        <option value="6">Juni</option>
                                        <option value="7">Juli</option>
                                        <option value="8">Agustus</option>
                                        <option value="9">September</option>
                                        <option value="10">Oktokber</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>
                                    </select>

                                    <select class="form-select" name="years" id="years">
                                        <option selected disabled>Tahun</option>
                                        @for ($i = 1997; $i < date('Y'); $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>

                                    <button class="btn btn-primary">filter</button>

                                </div>
                            </form>
                            <form action="{{ route('laporan') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="laporan" id="laporan" class="d-none" onchange="form.submit()">
                                <button type="button" class="btn btn-success" onclick="thisFileUpload()">import
                                </button>
                            </form>

                        </div>
                        @php
                            $totalPrice = (int) '';
                        @endphp
                        @foreach ($laporans as $laporan)
                            @php
                                $totalPrice += (int) $laporan->harga;
                            @endphp
                        @endforeach
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" style="width:100%" id="myTable">
                                <thead>
                                    <tr>
                                        <th colspan="6" class="text-end">Total :</th>
                                        <td colspan="2">Rp {{ number_format($totalPrice, '0', '.', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Waktu</th>
                                        <th>Username</th>
                                        <th>Profil</th>
                                        <th>Komentar</th>
                                        <th>Harga</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($laporans as $key => $laporan)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $laporan->tanggal }}</td>
                                            <td>{{ $laporan->waktu }}</td>
                                            <td>{{ $laporan->username }}</td>
                                            <td>{{ $laporan->profil }}</td>
                                            <td>{{ $laporan->komentar }}</td>
                                            <td>{{ $laporan->harga }}</td>
                                            <td>
                                                <form action="{{ route('laporan.destroy', $laporan->id) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <a href="{{ route('laporan.edit', $laporan->id) }}"
                                                        class="btn btn-sm btn-warning">Edit</a>
                                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Edit</div>

                    <div class="card-body">
                        <form action="" method="POST">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="tanggal" class="form-label">Tanggal</label>
                                    <input name="tanggal" type="text" class="form-control"
                                        value="{{ $laporan->tanggal }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="waktu" class="form-label">waktu</label>
                                    <input name="waktu" type="text" class="form-control" value="{{ $laporan->waktu }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="username" class="form-label">username</label>
                                    <input name="username" type="text" class="form-control"
                                        value="{{ $laporan->username }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="profil" class="form-label">profil</label>
                                    <input name="profil" type="text" class="form-control"
                                        value="{{ $laporan->profil }}">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="komentar" class="form-label">komentar</label>
                                    <textarea name="komentar" type="text" class="form-control" rows="10">{{ $laporan->komentar }}</textarea>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-dark">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

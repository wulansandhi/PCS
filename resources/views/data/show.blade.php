@extends('layouts.app')

@section('content')
    <div class="container-sm mt-5">
        <div class="row justify-content-center">
            <div class="p-5 bg-light rounded-3 border col-xl-12">
                <div class="mb-3 text-center">
                    <i class="bi bi-file-text-fill fs-1"></i>
                    <h4>Rincian Data</h4>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="nama" class="form-label">Nama Data</label>
                                <p>Ambil isi</p>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="nomorSurat" class="form-label">Nomor Surat</label>
                                <p>Ambil isi</p>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="divisi" class="form-label">Divisi</label>
                                <p>Ambil isi</p>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="kategori" class="form-label">Kategori</label>
                                <p>Ambil isi</p>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <p>Ambil isi</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex flex-column align-items-center mt-5">
                            <p>{{ $code }}</p>
                        </div>
                        <div class="row">
                            <a href="{{ url('download/' . $key) }}" class="btn btn-dark me-2"><i class="bi bi-download"></i> Download</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

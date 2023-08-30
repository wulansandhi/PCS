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
                            <div class="col-md-11 mb-3">
                                <label for="nama" class="form-label">Nama Data</label>
                                <input class="form-control" type="text"
                                name="nama" id="nama" value="{{ $editdata['nama'] }}" disabled>
                            </div>
                            <div class="col-md-11 mb-3">
                                <label for="nomorSurat" class="form-label">Nomor Surat</label>
                                <input class="form-control" type="text"
                                name="nomorSurat" id="nomorSurat" value="{{ $editdata['nomorSurat'] }}" disabled>
                            </div>
                            <div class="col-md-11 mb-3">
                                <label for="divisi" class="form-label">Divisi</label>
                                <input class="form-control" type="text"
                                name="divisi" id="divisi" value="{{ $editdata['divisi'] }}" disabled>
                            </div>
                            <div class="col-md-11 mb-3">
                                <label for="kategori" class="form-label">Kategori</label>
                                <input class="form-control" type="text"
                                name="kategori" id="kategori" value="{{ $editdata['kategori'] }}" disabled>
                            </div>
                            <div class="col-md-11 mb-3">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <input class="form-control" type="text"
                                name="keterangan" id="keterangan" value="{{ $editdata['keterangan'] }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex flex-column align-items-center my-5">
                            <p>{{ $code }}</p>
                        </div>
                        <div class="row">
                            <a href="{{ url('download/' . $key) }}" class="btn btn-dark me-2"><i class="bi bi-download"></i> Download</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 offset-md-5 d-grid mt-3">
                    <a href="{{ url('data') }}" class="btn btn-outline-dark btn-lg mt-3"><i
                            class="bi-arrow-left-circle me-2"></i>Kembali</a>
                </div>
            </div>
        </div>
    </div>
@endsection

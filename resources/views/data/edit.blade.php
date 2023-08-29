@extends('layouts.app')

@section('content')
    <div class="container-sm mt-5">
        <form action="{{ url('data.update' . $key) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row justify-content-center">
                <div class="p-5 bg-light rounded-3 border col-xl-6">
                    <div class="mb-3 text-center">
                        <i class="bi-person-circle fs-1"></i>
                        <h4>Edit Data</h4>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="id" class="form-label">ID</label>
                            <input class="form-control @error('id')
        is-invalid @enderror" type="text"
                                name="id" id="id" value="{{ $editdata['id'] }}" placeholder="Masukkan ID">
                            @error('id')
                                <div class="text-danger"><small>{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="nama" class="form-label">Nama Data</label>
                            <input class="form-control @error('nama')
        is-invalid @enderror" type="text"
                                name="nama" id="nama" value="{{ $editdata['nama'] }}"
                                placeholder="Masukkan Nama Data">
                            @error('nama')
                                <div class="text-danger"><small>{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <input class="form-control @error('keterangan') is-invalid
        @enderror" type="text"
                                name="keterangan" id="keterangan" value="{{ $editdata['keterangan'] }}"
                                placeholder="Masukkan Keterangan">
                            @error('keterangan')
                                <div class="text-danger"><small>{{ $message }}</small></div>
                            @enderror
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6 d-grid">
                                <a href="{{ url('data') }}" class="btn btn-outline-dark btn-lg mt-3"><i
                                        class="bi-arrow-left-circle me-2"></i>Cancel</a>
                            </div>
                            <div class="col-md-6 d-grid">
                                <button type="submit" class="btn btn-dark btn-lg
        mt-3"><i
                                        class="bi-check-circle me-2"></i> Save</button>
                            </div>
                        </div>
                    </div>
                </div>
        </form>
    </div>
@endsection

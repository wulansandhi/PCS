@extends('layouts.app')

@section('content')
    <div class="container-sm mt-5">
        <form action="{{ route('data.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row justify-content-center">
                <div class="p-5 bg-light rounded-3 border col-xl-6">
                    <div class="mb-3 text-center">
                        <i class="bi bi-archive-fill fs-1"></i>
                        <h4>Masukkan Data</h4>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="nama" class="form-label">Nama Data</label>
                            <input class="form-control @error('nama')
        is-invalid @enderror" type="text"
                                name="nama" id="nama" value="{{ old('nama') }}" placeholder="Masukkan Nama Data">
                            @error('nama')
                                <div class="text-danger"><small>{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <input class="form-control @error('keterangan') is-invalid
        @enderror" type="text"
                                name="keterangan" id="keterangan" value="{{ old('keterangan') }}"
                                placeholder="Masukkan Keterangan">
                            @error('keterangan')
                                <div class="text-danger"><small>{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <select name="kategori" id="kategori" class="form-select" aria-label="Default select example">
                                <option value="">Pilih Kategori</option>
                                <option value="1">Box</option>
                                <option value="2">Map</option>
                            </select>
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

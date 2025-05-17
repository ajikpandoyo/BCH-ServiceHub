@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Pendaftaran Event Baru') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('pendaftaran.event.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="nama_event" class="form-label">{{ __('Nama Event') }}</label>
                            <input type="text" class="form-control @error('nama_event') is-invalid @enderror" id="nama_event" name="nama_event" value="{{ old('nama_event') }}" required>
                            @error('nama_event')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="penyelenggara" class="form-label">{{ __('Penyelenggara') }}</label>
                            <input type="text" class="form-control @error('penyelenggara') is-invalid @enderror" id="penyelenggara" name="penyelenggara" value="{{ old('penyelenggara') }}" required>
                            @error('penyelenggara')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_pelaksanaan" class="form-label">{{ __('Tanggal Pelaksanaan') }}</label>
                            <input type="date" class="form-control @error('tanggal_pelaksanaan') is-invalid @enderror" id="tanggal_pelaksanaan" name="tanggal_pelaksanaan" value="{{ old('tanggal_pelaksanaan') }}" required>
                            @error('tanggal_pelaksanaan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="waktu" class="form-label">{{ __('Waktu') }}</label>
                            <input type="time" class="form-control @error('waktu') is-invalid @enderror" id="waktu" name="waktu" value="{{ old('waktu') }}" required>
                            @error('waktu')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="lokasi_ruangan" class="form-label">{{ __('Lokasi Ruangan') }}</label>
                            <input type="text" class="form-control @error('lokasi_ruangan') is-invalid @enderror" id="lokasi_ruangan" name="lokasi_ruangan" value="{{ old('lokasi_ruangan') }}" required>
                            @error('lokasi_ruangan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">{{ __('Deskripsi') }}</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3" required>{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="poster" class="form-label">{{ __('Poster Event') }}</label>
                            <input type="file" class="form-control @error('poster') is-invalid @enderror" id="poster" name="poster" accept="image/*" required>
                            @error('poster')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Daftar Event') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Formulir Kerjasama Event</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('user.kerjasama.event.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_event" class="form-label">Nama Event</label>
                            <input type="text" class="form-control @error('nama_event') is-invalid @enderror" 
                                   id="nama_event" name="nama_event" value="{{ old('nama_event') }}" required>
                            @error('nama_event')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi_event" class="form-label">Deskripsi Event</label>
                            <textarea class="form-control @error('deskripsi_event') is-invalid @enderror" 
                                      id="deskripsi_event" name="deskripsi_event" rows="3" required>{{ old('deskripsi_event') }}</textarea>
                            @error('deskripsi_event')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_pelaksanaan" class="form-label">Tanggal Pelaksanaan</label>
                            <input type="date" class="form-control @error('tanggal_pelaksanaan') is-invalid @enderror" 
                                   id="tanggal_pelaksanaan" name="tanggal_pelaksanaan" value="{{ old('tanggal_pelaksanaan') }}" required>
                            @error('tanggal_pelaksanaan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="lokasi" class="form-label">Lokasi</label>
                            <input type="text" class="form-control @error('lokasi') is-invalid @enderror" 
                                   id="lokasi" name="lokasi" value="{{ old('lokasi') }}" required>
                            @error('lokasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="proposal" class="form-label">Proposal (PDF)</label>
                            <input type="file" class="form-control @error('proposal') is-invalid @enderror" 
                                   id="proposal" name="proposal" accept=".pdf" required>
                            @error('proposal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nama_peserta" class="form-label">Nama Peserta</label>
                            <input type="text" class="form-control @error('nama_peserta') is-invalid @enderror" 
                                   id="nama_peserta" name="nama_peserta" value="{{ old('nama_peserta') }}" required>
                            @error('nama_peserta')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email_peserta" class="form-label">Email Peserta</label>
                            <input type="email" class="form-control @error('email_peserta') is-invalid @enderror" 
                                   id="email_peserta" name="email_peserta" value="{{ old('email_peserta') }}" required>
                            @error('email_peserta')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="telepon_peserta" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control @error('telepon_peserta') is-invalid @enderror" 
                                   id="telepon_peserta" name="telepon_peserta" value="{{ old('telepon_peserta') }}" required>
                            @error('telepon_peserta')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="instansi_peserta" class="form-label">Instansi</label>
                            <input type="text" class="form-control @error('instansi_peserta') is-invalid @enderror" 
                                   id="instansi_peserta" name="instansi_peserta" value="{{ old('instansi_peserta') }}" required>
                            @error('instansi_peserta')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Kirim Formulir</button>
                            <a href="{{ route('user.kerjasama.event.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
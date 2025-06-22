@extends('layouts.app')

@section('content')
<div class="formulir-header">
    <div class="container">
        <div class="text-center py-5">
            <h1 class="fw-bold">Formulir Peminjaman Ruangan</h1>
            <p class="text-muted">Silakan lengkapi form berikut dengan data yang valid</p>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-body p-5">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('peminjaman.ruangan.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Pilih Ruangan</label>
                                    <select class="form-select @error('ruangan_id') is-invalid @enderror" name="ruangan_id" required>
                                        <option value="">-- Pilih Ruangan --</option>
                                        @foreach($ruangans as $ruangan)
                                            <option value="{{ $ruangan->id }}" {{ old('ruangan_id') == $ruangan->id ? 'selected' : '' }}>
                                                {{ $ruangan->nama_ruangan }} - {{ $ruangan->lokasi }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('ruangan_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mt-3">
                                    <label class="form-label">Nama Peminjam</label>
                                    <input type="text" class="form-control @error('nama_peminjam') is-invalid @enderror" name="nama_peminjam" value="{{ old('nama_peminjam') }}" required>
                                    @error('nama_peminjam')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mt-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email_peminjam') is-invalid @enderror" name="email_peminjam" value="{{ old('email_peminjam') }}" required>
                                    @error('email_peminjam')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Nomor Telepon</label>
                                    <input type="text" class="form-control @error('telepon_peminjam') is-invalid @enderror" name="telepon_peminjam" value="{{ old('telepon_peminjam') }}" required>
                                    @error('telepon_peminjam')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mt-3">
                                    <label class="form-label">Instansi</label>
                                    <input type="text" class="form-control @error('instansi_peminjam') is-invalid @enderror" name="instansi_peminjam" value="{{ old('instansi_peminjam') }}" required>
                                    @error('instansi_peminjam')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <label class="form-label">Nama Kegiatan</label>
                            <input type="text" class="form-control @error('kegiatan') is-invalid @enderror" name="kegiatan" value="{{ old('kegiatan') }}" required>
                            @error('kegiatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label class="form-label">Deskripsi Kegiatan</label>
                            <textarea class="form-control @error('deskripsi_kegiatan') is-invalid @enderror" name="deskripsi_kegiatan" rows="4" required>{{ old('deskripsi_kegiatan') }}</textarea>
                            @error('deskripsi_kegiatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-4 mt-1">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Tanggal Peminjaman</label>
                                    <input type="date" class="form-control @error('tanggal_peminjaman') is-invalid @enderror" name="tanggal_peminjaman" value="{{ old('tanggal_peminjaman') }}" required>
                                    @error('tanggal_peminjaman')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Waktu Mulai</label>
                                    <input type="time" class="form-control @error('waktu_mulai') is-invalid @enderror" name="waktu_mulai" value="{{ old('waktu_mulai') }}" required>
                                    @error('waktu_mulai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Waktu Selesai</label>
                                    <input type="time" class="form-control @error('waktu_selesai') is-invalid @enderror" name="waktu_selesai" value="{{ old('waktu_selesai') }}" required>
                                    @error('waktu_selesai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row g-4 mt-1">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Jumlah Peserta</label>
                                    <input type="number" class="form-control @error('jumlah_peserta') is-invalid @enderror" name="jumlah_peserta" value="{{ old('jumlah_peserta') }}" required>
                                    @error('jumlah_peserta')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Surat Peminjaman (PDF)</label>
                                    <input type="file" class="form-control @error('surat_peminjaman') is-invalid @enderror" name="surat_peminjaman" accept=".pdf" required>
                                    @error('surat_peminjaman')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 d-flex justify-content-end gap-2">
                            <a href="{{ route('peminjaman.ruangan.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i>Kirim Formulir
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.formulir-header {
    background: linear-gradient(135deg, #0041C2, #0052cc);
    color: white;
    padding: 2rem 0;
    margin-top: 4rem;
}

.form-label {
    font-weight: 500;
    color: #333;
    margin-bottom: 0.5rem;
}

.form-control, .form-select {
    padding: 0.75rem 1rem;
    border-color: #e0e0e0;
    border-radius: 8px;
}

.form-control:focus, .form-select:focus {
    border-color: #0041C2;
    box-shadow: 0 0 0 0.2rem rgba(0,65,194,0.1);
}

.card {
    border-radius: 15px;
}

.btn-primary {
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    background: #0041C2;
    border-color: #0041C2;
}

.btn-primary:hover {
    background: #003399;
    border-color: #003399;
}
</style>

@push('scripts')
<script>
    // Bootstrap validation script
    (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
    })()
</script>
@endpush
@endsection

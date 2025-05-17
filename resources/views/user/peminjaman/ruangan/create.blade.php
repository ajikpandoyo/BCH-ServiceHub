@extends('layouts.app')

@section('content')
<div class="container mt-8">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-gradient-primary text-white py-3">
                    <h4 class="mb-0 font-weight-bold">
                        <i class="fas fa-clipboard-list me-2"></i>
                        Formulir Peminjaman Ruangan
                    </h4>
                </div>
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('peminjaman.ruangan.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label for="ruangan_id" class="form-label fw-bold">
                                        <i class="fas fa-door-open me-1"></i>
                                        Pilih Ruangan
                                    </label>
                                    <select class="form-select @error('ruangan_id') is-invalid @enderror" 
                                            id="ruangan_id" name="ruangan_id" required>
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

                                <div class="form-group mb-4">
                                    <label for="nama_peminjam" class="form-label fw-bold">
                                        <i class="fas fa-user me-1"></i>
                                        Nama Peminjam
                                    </label>
                                    <input type="text" class="form-control @error('nama_peminjam') is-invalid @enderror" 
                                           id="nama_peminjam" name="nama_peminjam" value="{{ old('nama_peminjam') }}" required>
                                    @error('nama_peminjam')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-4">
                                    <label for="email_peminjam" class="form-label fw-bold">
                                        <i class="fas fa-envelope me-1"></i>
                                        Email
                                    </label>
                                    <input type="email" class="form-control @error('email_peminjam') is-invalid @enderror" 
                                           id="email_peminjam" name="email_peminjam" value="{{ old('email_peminjam') }}" required>
                                    @error('email_peminjam')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label for="telepon_peminjam" class="form-label fw-bold">
                                        <i class="fas fa-phone me-1"></i>
                                        Nomor Telepon
                                    </label>
                                    <input type="text" class="form-control @error('telepon_peminjam') is-invalid @enderror" 
                                           id="telepon_peminjam" name="telepon_peminjam" value="{{ old('telepon_peminjam') }}" required>
                                    @error('telepon_peminjam')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-4">
                                    <label for="instansi_peminjam" class="form-label fw-bold">
                                        <i class="fas fa-building me-1"></i>
                                        Instansi
                                    </label>
                                    <input type="text" class="form-control @error('instansi_peminjam') is-invalid @enderror" 
                                           id="instansi_peminjam" name="instansi_peminjam" value="{{ old('instansi_peminjam') }}" required>
                                    @error('instansi_peminjam')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-4">
                                    <label for="kegiatan" class="form-label fw-bold">
                                        <i class="fas fa-calendar-event me-1"></i>
                                        Nama Kegiatan
                                    </label>
                                    <input type="text" class="form-control @error('kegiatan') is-invalid @enderror" 
                                           id="kegiatan" name="kegiatan" value="{{ old('kegiatan') }}" required>
                                    @error('kegiatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-4">
                                    <label for="deskripsi_kegiatan" class="form-label fw-bold">
                                        <i class="fas fa-align-left me-1"></i>
                                        Deskripsi Kegiatan
                                    </label>
                                    <textarea class="form-control @error('deskripsi_kegiatan') is-invalid @enderror" 
                                              id="deskripsi_kegiatan" name="deskripsi_kegiatan" rows="4" required>{{ old('deskripsi_kegiatan') }}</textarea>
                                    @error('deskripsi_kegiatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-4">
                                    <label for="tanggal_peminjaman" class="form-label fw-bold">
                                        <i class="fas fa-calendar me-1"></i>
                                        Tanggal Peminjaman
                                    </label>
                                    <input type="date" class="form-control @error('tanggal_peminjaman') is-invalid @enderror" 
                                           id="tanggal_peminjaman" name="tanggal_peminjaman" value="{{ old('tanggal_peminjaman') }}" required>
                                    @error('tanggal_peminjaman')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-4">
                                    <label for="waktu_mulai" class="form-label fw-bold">
                                        <i class="fas fa-clock me-1"></i>
                                        Waktu Mulai
                                    </label>
                                    <input type="time" class="form-control @error('waktu_mulai') is-invalid @enderror" 
                                           id="waktu_mulai" name="waktu_mulai" value="{{ old('waktu_mulai') }}" required>
                                    @error('waktu_mulai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-4">
                                    <label for="waktu_selesai" class="form-label fw-bold">
                                        <i class="fas fa-clock me-1"></i>
                                        Waktu Selesai
                                    </label>
                                    <input type="time" class="form-control @error('waktu_selesai') is-invalid @enderror" 
                                           id="waktu_selesai" name="waktu_selesai" value="{{ old('waktu_selesai') }}" required>
                                    @error('waktu_selesai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label for="jumlah_peserta" class="form-label fw-bold">
                                        <i class="fas fa-users me-1"></i>
                                        Jumlah Peserta
                                    </label>
                                    <input type="number" class="form-control @error('jumlah_peserta') is-invalid @enderror" 
                                           id="jumlah_peserta" name="jumlah_peserta" value="{{ old('jumlah_peserta') }}" required>
                                    @error('jumlah_peserta')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label for="surat_peminjaman" class="form-label fw-bold">
                                        <i class="fas fa-file-pdf me-1"></i>
                                        Surat Peminjaman (PDF)
                                    </label>
                                    <input type="file" class="form-control @error('surat_peminjaman') is-invalid @enderror" 
                                           id="surat_peminjaman" name="surat_peminjaman" accept=".pdf" required>
                                    @error('surat_peminjaman')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('peminjaman.ruangan.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i>
                                Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-1"></i>
                                Kirim Formulir
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.mt-8 {
    margin-top: 6rem !important;
}

.bg-gradient-primary {
    background: linear-gradient(45deg, #4e73df 0%, #224abe 100%);
}

.card {
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
}

.btn-primary {
    background-color: #4e73df;
    border-color: #4e73df;
}

.btn-primary:hover {
    background-color: #224abe;
    border-color: #224abe;
}

.form-label {
    color: #4e73df;
}

.invalid-feedback {
    font-size: 80%;
}
</style>

@push('scripts')
<script>
    // Form validation
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
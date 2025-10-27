@extends('layouts.app')

@section('content')
<div class="container kunjungan-visit-index">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Pengajuan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Kunjungan Visit</li>
        </ol>
    </nav>

    {{-- Header --}}
    <div class="ruangan-header">
        <h1>Formulir Pengajuan Kunjungan Visit</h1>
        <p>
            Lengkapi data dengan benar untuk memproses permohonan kunjungan ke Bandung Creative Hub.
        </p>
    </div>

    <!-- Form Section -->
    <div class="row justify-content-center">
        <div class="col-lg-20">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                <div class="card-body p-5">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('kunjungan.visit.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf

                        <!-- Informasi Pemohon -->
                        <h4 class="fw-bold mb-4 text-primary">Informasi Pemohon</h4>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label">Nama Pemohon</label>
                                <input type="text" class="form-control @error('nama_pemohon') is-invalid @enderror" name="nama_pemohon" value="{{ old('nama_pemohon') }}" placeholder="Nama lengkap sesuai identitas" required>
                                @error('nama_pemohon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="contoh@email.com" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Instansi</label>
                                <input type="text" class="form-control @error('instansi') is-invalid @enderror" name="instansi" value="{{ old('instansi') }}" placeholder="Nama instansi atau komunitas" required>
                                @error('instansi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Nomor Telepon</label>
                                <input type="tel" class="form-control @error('telepon') is-invalid @enderror" name="telepon" value="{{ old('telepon') }}" placeholder="08xxxxxxxxxx" required>
                                @error('telepon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Detail Kunjungan -->
                        <h4 class="fw-bold mt-5 mb-4 text-primary">Detail Kunjungan</h4>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Kunjungan</label>
                                <input type="date" class="form-control @error('tanggal_kunjungan') is-invalid @enderror" name="tanggal_kunjungan" value="{{ old('tanggal_kunjungan') }}" required>
                                @error('tanggal_kunjungan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Waktu Kunjungan</label>
                                <input type="time" class="form-control @error('waktu_kunjungan') is-invalid @enderror" name="waktu_kunjungan" value="{{ old('waktu_kunjungan') }}" required>
                                @error('waktu_kunjungan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Jumlah Peserta</label>
                                <input type="number" class="form-control @error('jumlah_peserta') is-invalid @enderror" name="jumlah_peserta" value="{{ old('jumlah_peserta') }}" placeholder="Jumlah peserta kunjungan" required>
                                @error('jumlah_peserta')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group mt-4 mb-4">
                            <label class="form-label">Tujuan Kunjungan</label>
                            <textarea class="form-control @error('tujuan') is-invalid @enderror" name="tujuan" rows="4" placeholder="Tuliskan tujuan dan detail kegiatan kunjungan..." required>{{ old('tujuan') }}</textarea>
                            @error('tujuan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Lampiran -->
                        <h4 class="fw-bold mt-5 mb-4 text-primary">Lampiran</h4>
                        <div class="form-group">
                            <label class="form-label">Upload Proposal (PDF)</label>
                            <input type="file" class="form-control @error('proposal') is-invalid @enderror" name="proposal" accept=".pdf" required>
                            @error('proposal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted d-block mt-1">Unggah file proposal dalam format PDF (maksimal 5MB).</small>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="mt-5 d-flex justify-content-end gap-3">
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary px-4 py-2 rounded-3">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary px-4 py-2 rounded-3">
                                <i class="fas fa-paper-plane me-2"></i>Ajukan Kunjungan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* ======== Struktur & Padding ======== */
.container.kunjungan-visit-index {
    margin-top: 100px !important;
    margin-bottom: 80px;
    max-width: 1200px;
}

/* ======== Breadcrumb ======== */
.breadcrumb {
    margin-bottom: 2rem;
    background-color: transparent;
    padding: 0;
}

.breadcrumb a {
    color: #0041C2;
    text-decoration: none;
    font-weight: 500;
}

.breadcrumb a:hover {
    text-decoration: underline;
}

/* ======== Header ======== */
.ruangan-header {
    text-align: center;
    margin-bottom: 40px;
    margin-top: 0px;
}

.ruangan-header h1 {
    font-size: 32px;
    color: #1a1a1a;
    margin-bottom: 16px;
}

.ruangan-header p {
    color: #666;
    line-height: 1.6;
}

.card {
    border-radius: 16px;
    transition: all 0.3s ease;
}
.card:hover {
    box-shadow: 0 8px 24px rgba(0,0,0,0.05);
}
.form-label {
    font-weight: 600;
    color: #333;
}
.form-control, .form-select {
    padding: 0.75rem 1rem;
    border-radius: 10px;
    border: 1px solid #e0e0e0;
    transition: all 0.2s ease;
}
.form-control:focus, .form-select:focus {
    border-color: #0041C2;
    box-shadow: 0 0 0 0.25rem rgba(0,65,194,0.15);
}
.btn-primary {
    background-color: #0041C2;
    border: none;
    transition: all 0.2s ease;
}
.btn-primary:hover {
    background-color: #003399;
    transform: translateY(-1px);
}
.btn-outline-secondary {
    border: 1px solid #ccc;
    transition: all 0.2s ease;
}
.btn-outline-secondary:hover {
    background-color: #f1f1f1;
}
h4.text-primary {
    color: #0041C2 !important;
    border-left: 4px solid #0041C2;
    padding-left: 12px;
}
</style>

@push('scripts')
<script>
(function () {
    'use strict'
    var forms = document.querySelectorAll('.needs-validation')
    Array.prototype.slice.call(forms).forEach(function (form) {
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

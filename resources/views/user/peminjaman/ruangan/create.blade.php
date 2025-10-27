@extends('layouts.app')

@section('content')
<div class="container peminjaman-ruangan-index">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('peminjaman.ruangan.index') }}">Pengajuan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Peminjaman Ruangan</li>
        </ol>
    </nav>

    {{-- Header --}}
    <div class="ruangan-header">
        <h1>Formulir Peminjaman Ruangan</h1>
        <p>
            Lengkapi data dengan benar untuk memproses permohonan peminjaman ruangan<br>
            di Bandung Creative Hub.
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

                    <form action="{{ route('peminjaman.ruangan.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        
                        {{-- Form fields (tidak diubah) --}}
                        <!-- Informasi Peminjam -->
                        <h4 class="fw-bold mb-4 text-primary">Informasi Peminjam</h4>
                        <div class="row g-4">
                            <div class="col-md-6">
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

                            <div class="col-md-6">
                                <label class="form-label">Nama Peminjam</label>
                                <input type="text" class="form-control @error('nama_peminjam') is-invalid @enderror" name="nama_peminjam" value="{{ old('nama_peminjam') }}" placeholder="Nama lengkap sesuai identitas" required>
                                @error('nama_peminjam')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control @error('email_peminjam') is-invalid @enderror" name="email_peminjam" value="{{ old('email_peminjam') }}" placeholder="contoh@email.com" required>
                                @error('email_peminjam')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Nomor Telepon</label>
                                <input type="text" class="form-control @error('telepon_peminjam') is-invalid @enderror" name="telepon_peminjam" value="{{ old('telepon_peminjam') }}" placeholder="08xxxxxxxxxx" required>
                                @error('telepon_peminjam')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Instansi</label>
                                <input type="text" class="form-control @error('instansi_peminjam') is-invalid @enderror" name="instansi_peminjam" value="{{ old('instansi_peminjam') }}" placeholder="Nama instansi atau komunitas" required>
                                @error('instansi_peminjam')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Informasi Kegiatan -->
                        <h4 class="fw-bold mt-5 mb-4 text-primary">Informasi Kegiatan</h4>
                        <div class="form-group mb-4">
                            <label class="form-label">Nama Kegiatan</label>
                            <input type="text" class="form-control @error('kegiatan') is-invalid @enderror" name="kegiatan" value="{{ old('kegiatan') }}" placeholder="Contoh: Workshop Desain Grafis" required>
                            @error('kegiatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label">Deskripsi Kegiatan</label>
                            <textarea class="form-control @error('deskripsi_kegiatan') is-invalid @enderror" name="deskripsi_kegiatan" rows="4" placeholder="Tuliskan detail kegiatan, tujuan, dan peserta..." required>{{ old('deskripsi_kegiatan') }}</textarea>
                            @error('deskripsi_kegiatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Waktu dan Jadwal -->
                        <h4 class="fw-bold mt-5 mb-4 text-primary">Waktu & Jadwal</h4>
                        <div class="row g-4">
                            <div class="col-md-4">
                                <label class="form-label">Tanggal Peminjaman</label>
                                <input type="date" class="form-control @error('tanggal_peminjaman') is-invalid @enderror" name="tanggal_peminjaman" value="{{ old('tanggal_peminjaman') }}" required>
                                @error('tanggal_peminjaman')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Waktu Mulai</label>
                                <input type="time" class="form-control @error('waktu_mulai') is-invalid @enderror" name="waktu_mulai" value="{{ old('waktu_mulai') }}" required>
                                @error('waktu_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Waktu Selesai</label>
                                <input type="time" class="form-control @error('waktu_selesai') is-invalid @enderror" name="waktu_selesai" value="{{ old('waktu_selesai') }}" required>
                                @error('waktu_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Lampiran -->
                        <h4 class="fw-bold mt-5 mb-4 text-primary">Lampiran</h4>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label">Jumlah Peserta</label>
                                <input type="number" class="form-control @error('jumlah_peserta') is-invalid @enderror" name="jumlah_peserta" value="{{ old('jumlah_peserta') }}" placeholder="Jumlah peserta kegiatan" required>
                                @error('jumlah_peserta')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Surat Peminjaman (PDF)</label>
                                <input type="file" class="form-control @error('surat_peminjaman') is-invalid @enderror" name="surat_peminjaman" accept=".pdf" required>
                                @error('surat_peminjaman')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted d-block mt-1">Unggah surat resmi dari instansi/komunitas (format PDF, maksimal 2MB).</small>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="mt-5 d-flex justify-content-end gap-3">
                            <a href="{{ route('peminjaman.ruangan.index') }}" class="btn btn-outline-secondary px-4 py-2 rounded-3">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary px-4 py-2 rounded-3">
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
/* ======== Struktur & Padding ======== */
.container.peminjaman-ruangan-index {
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
    margin-top: 0;
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

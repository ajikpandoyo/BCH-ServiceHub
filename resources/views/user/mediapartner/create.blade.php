@extends('layouts.app')

@section('content')
<div class="container mediapartner-index">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Pengajuan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Media Partner</li>
        </ol>
    </nav>

    {{-- Header --}}
    <div class="ruangan-header">
        <h1>Formulir Pengajuan Media Partner</h1>
        <p>
            Lengkapi data dengan benar untuk memproses permohonan kerja sama<br>
            sebagai Media Partner di Bandung Creative Hub.
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

                    <form action="{{ route('mediapartner.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf

                        <!-- Data Pemohon -->
                        <h4 class="fw-bold mb-4 text-primary">Data Pemohon</h4>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label">Nama Pemohon</label>
                                <input type="text" class="form-control" name="nama_pemohon" placeholder="Nama lengkap sesuai identitas" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="contoh@email.com" required>
                            </div>
                        </div>

                        <!-- Data Instansi -->
                        <h4 class="fw-bold mt-5 mb-4 text-primary">Data Instansi</h4>
                        <div class="row g-4">
                            <div class="col-12">
                                <label class="form-label">Nama Instansi</label>
                                <input type="text" class="form-control" name="instansi" placeholder="Nama instansi atau komunitas" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Instagram</label>
                                <div class="input-group">
                                    <span class="input-group-text">@</span>
                                    <input type="text" class="form-control" name="instagram" placeholder="Nama akun Instagram" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Website</label>
                                <input type="url" class="form-control" name="website" placeholder="https://contohwebsite.com">
                            </div>
                        </div>

                        <!-- Data Acara -->
                        <h4 class="fw-bold mt-5 mb-4 text-primary">Data Acara</h4>
                        <div class="row g-4">
                            <div class="col-12">
                                <label class="form-label">Tema Acara</label>
                                <input type="text" class="form-control" name="tema_acara" placeholder="Contoh: Festival Musik Bandung 2025" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Kategori Subsektor</label>
                                <select class="form-select" name="kategori" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category }}">{{ $category }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Acara</label>
                                <input type="date" class="form-control" name="tanggal_acara" required>
                            </div>
                        </div>

                        <!-- Kontak PIC -->
                        <h4 class="fw-bold mt-5 mb-4 text-primary">Kontak PIC</h4>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label">Nama PIC</label>
                                <input type="text" class="form-control" name="pic_nama" placeholder="Nama penanggung jawab" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">No. WhatsApp PIC</label>
                                <input type="tel" class="form-control" name="pic_whatsapp" placeholder="08xxxxxxxxxx" required>
                            </div>
                        </div>

                        <!-- Berkas Persyaratan -->
                        <h4 class="fw-bold mt-5 mb-4 text-primary">Berkas Persyaratan</h4>
                        <div class="form-group mb-4">
                            <label class="form-label">Surat Pengajuan (PDF)</label>
                            <input type="file" class="form-control" name="surat_pengajuan" accept=".pdf" required>
                            <small class="text-muted d-block mt-1">Unggah surat pengajuan resmi (format PDF, maksimal 5MB).</small>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="mt-5 d-flex justify-content-end gap-3">
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary px-4 py-2 rounded-3">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary px-4 py-2 rounded-3">
                                <i class="fas fa-paper-plane me-2"></i>Ajukan Media Partner
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
.container.mediapartner-index {
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
    margin-top: 20px;
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

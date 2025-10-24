@extends('layouts.app')

@section('content')
<div class="container pendaftaran-event-index">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('kerjasama.event.index') }}">Event</a></li>
            <li class="breadcrumb-item active" aria-current="page">Form Pendaftaran Event</li>
        </ol>
    </nav>

    {{-- Header --}}
    <div class="ruangan-header">
        <h1>Formulir Pendaftaran Event</h1>
        <p>
            Lengkapi data dengan benar untuk mendaftar pada event <br>
            <strong>{{ $event->nama_event }}</strong>
        </p>
    </div>

    {{-- Form Section --}}
    <div class="row justify-content-center">
        <div class="col-lg-20">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                <div class="card-body p-5">
                    <form method="POST" action="{{ route('peminjaman.event.store') }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        <input type="hidden" name="event_id" value="{{ $event->id }}">

                        {{-- Informasi Pemohon --}}
                        <h4 class="fw-bold mb-4 text-primary">Informasi Pemohon</h4>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label">Nama Pemohon</label>
                                <input type="text" class="form-control" name="nama_pemohon" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Instansi</label>
                                <input type="text" class="form-control" name="instansi" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Sosial Media Instansi</label>
                                <input type="text" class="form-control" name="sosmed_instansi" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Tema Acara</label>
                                <input type="text" class="form-control" name="tema_acara" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Waktu Loading</label>
                                <input type="datetime-local" class="form-control" name="waktu_loading" required>
                            </div>
                        </div>

                        {{-- Berkas Persyaratan --}}
                        <h4 class="fw-bold mt-5 mb-4 text-primary">Berkas Persyaratan</h4>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label">Surat Pengajuan (PDF)</label>
                                <input type="file" class="form-control" name="surat_pengajuan" accept=".pdf" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Upload KTP (JPG/PNG)</label>
                                <input type="file" class="form-control" name="ktp" accept=".jpg,.jpeg,.png" required>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Upload Softfile Screening (Optional)</label>
                                <input type="file" class="form-control" name="screening_file" accept=".pdf,.doc,.docx">
                                <small class="text-muted d-block mt-1">Format: PDF, DOC, atau DOCX</small>
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="mt-5 d-flex justify-content-end gap-3">
                            <a href="{{ route('kerjasama.event.show', $event->id) }}" class="btn btn-outline-secondary px-4 py-2 rounded-3">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary px-4 py-2 rounded-3">
                                <i class="fas fa-paper-plane me-2"></i>Kirim Pendaftaran
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
.container.pendaftaran-event-index {
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

/* ======== Form & Card ======== */
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
.form-control {
    padding: 0.75rem 1rem;
    border-radius: 10px;
    border: 1px solid #e0e0e0;
    transition: all 0.2s ease;
}
.form-control:focus {
    border-color: #0041C2;
    box-shadow: 0 0 0 0.25rem rgba(0,65,194,0.15);
}

/* ======== Buttons ======== */
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

@extends('layouts.app')

@section('content')
<div class="container pendaftaran-event-index">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pendaftaran.event.index') }}">Event</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pendaftaran Event</li>
        </ol>
    </nav>

    {{-- Header --}}
    <div class="event-header text-center mb-5">
        <h1 class="fw-bold">Formulir Pendaftaran Event</h1>
        <p class="text-muted">
            Silakan lengkapi formulir berikut untuk mendaftar ke event<br>
            <strong>{{ $event->nama_event }}</strong>
        </p>
    </div>

    {{-- Informasi Event --}}
    <div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-5">
        <div class="card-body p-4">
            <div class="row g-4 align-items-center">
                <div class="col-md-4">
                    @if($event->poster)
                        <div class="event-poster-container">
                            <img src="{{ $event->poster_url }}" 
                                 class="img-fluid rounded-3"
                                 alt="{{ $event->nama_event }}"
                                 onerror="this.onerror=null; this.src='{{ asset('images/default-event.jpg') }}';">
                        </div>
                    @else
                        <div class="no-poster">
                            <i class="fas fa-image"></i>
                            <span>Tidak ada poster</span>
                        </div>
                    @endif
                </div>
                <div class="col-md-8">
                    <h4 class="fw-bold text-primary mb-3">{{ $event->nama_event }}</h4>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><i class="fas fa-calendar me-2 text-primary"></i> {{ $event->tanggal_pelaksanaan }}</li>
                        <li class="mb-2"><i class="fas fa-clock me-2 text-primary"></i> {{ $event->waktu }}</li>
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2 text-primary"></i> {{ $event->lokasi_ruangan }}</li>
                        <li class="mb-2"><i class="fas fa-user-tie me-2 text-primary"></i> {{ $event->penyelenggara }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Form Section --}}
    <div class="row justify-content-center">
        <div class="col-lg-20">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                <div class="card-body p-5">

                    {{-- Notifikasi --}}
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @if(session('warning'))
                    <div class="alert alert-warning alert-dismissible fade show mb-4" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ session('warning') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    {{-- Form Pendaftaran --}}
                    <form method="POST" action="{{ route('pendaftaran.event.store') }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        <input type="hidden" name="event_id" value="{{ $event->id }}">

                        <h4 class="fw-bold mb-4 text-primary">Data Peserta</h4>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label">Nama Peserta</label>
                                <input type="text" class="form-control" name="nama_peserta" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nomor Telepon</label>
                                <input type="text" class="form-control" name="no_telepon" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Instansi</label>
                                <input type="text" class="form-control" name="instansi" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Bukti Pembayaran</label>
                                <input type="file" class="form-control" name="bukti_pembayaran" accept="image/*" required>
                                <small class="text-muted d-block mt-1">Format: JPG, PNG (Max. 2MB)</small>
                            </div>
                        </div>

                        <div class="mt-5 d-flex justify-content-end gap-3">
                            <a href="{{ route('pendaftaran.event.index') }}" class="btn btn-outline-secondary px-4 py-2 rounded-3">
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
/* ===== Struktur & Padding ===== */
.container.pendaftaran-event-index {
    margin-top: 100px !important;
    margin-bottom: 80px;
    max-width: 1200px;
}

/* ===== Breadcrumb ===== */
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

/* ===== Header ===== */
.event-header h1 {
    font-size: 32px;
    color: #1a1a1a;
    margin-bottom: 16px;
}

.event-header p {
    color: #666;
    line-height: 1.6;
}

/* ===== Poster ===== */
.event-poster-container {
    height: 220px;
    overflow: hidden;
    border-radius: 10px;
    background-color: #f8f9fa;
}

.event-poster-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.no-poster {
    height: 220px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background-color: #f8f9fa;
    border-radius: 10px;
    color: #6b7280;
}
.no-poster i {
    font-size: 2rem;
    margin-bottom: 0.5rem;
}

/* ===== Form & Card ===== */
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

/* ===== Button ===== */
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

/* ===== Judul Section ===== */
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

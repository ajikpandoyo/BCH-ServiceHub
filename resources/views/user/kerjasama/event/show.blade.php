@extends('layouts.app')

@section('content')
<div class="container event-detail py-5">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('kerjasama.event.index') }}">Event</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $event->nama_event }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        {{-- Kolom Kiri: Detail Event --}}
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="event-poster-container">
                    @if($event->poster)
                        <img src="{{ $event->poster_url }}" 
                             class="card-img-top" 
                             alt="{{ $event->nama_event }}"
                             onerror="this.onerror=null; this.src='{{ asset('images/default-event.jpg') }}';">
                    @else
                        <div class="no-poster">
                            <i class="fas fa-image fa-3x mb-2 text-muted"></i>
                            <span class="text-muted">Tidak ada poster</span>
                        </div>
                    @endif
                </div>

                <div class="card-body p-4">
                    <h1 class="card-title fw-semibold mb-4">{{ $event->nama_event }}</h1>
                    
                    {{-- Informasi Event --}}
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="info-item">
                                <i class="fas fa-calendar me-2 text-primary"></i>
                                <span class="text-secondary small d-block">Tanggal Pelaksanaan</span>
                                <p class="mb-0 fw-medium">{{ $event->tanggal_pelaksanaan }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <i class="fas fa-clock me-2 text-primary"></i>
                                <span class="text-secondary small d-block">Waktu</span>
                                <p class="mb-0 fw-medium">{{ $event->waktu }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                                <span class="text-secondary small d-block">Lokasi</span>
                                <p class="mb-0 fw-medium">{{ $event->lokasi_ruangan }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <i class="fas fa-users me-2 text-primary"></i>
                                <span class="text-secondary small d-block">Kapasitas</span>
                                <p class="mb-0 fw-medium">{{ $event->kapasitas }} orang</p>
                            </div>
                        </div>
                    </div>

                    {{-- Deskripsi Event --}}
                    <div class="mb-4">
                        <h5 class="fw-semibold mb-2">Deskripsi Event</h5>
                        <p class="text-muted mb-0">{{ $event->deskripsi }}</p>
                    </div>

                    {{-- Persyaratan --}}
                    <div class="mb-4">
                        <h5 class="fw-semibold mb-2">Persyaratan</h5>
                        <p class="text-muted mb-0">{{ $event->persyaratan }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Informasi Pendaftaran --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm sticky-top" style="top: 100px;">
                <div class="card-body p-4">
                    <h5 class="fw-semibold mb-4">Informasi Pendaftaran</h5>

                    <div class="d-grid gap-3">
                        <a href="{{ route('peminjaman.event.form', $event->id) }}" class="btn btn-primary">
                            <i class="fas fa-pencil-alt me-2"></i> Daftar Event
                        </a>
                        <a href="{{ route('kerjasama.event.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar Event
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* ======== Struktur & Padding ======== */
.container.event-detail {
    margin-top: 50px !important;
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

/* ======== Poster ======== */
.event-poster-container {
    height: 400px;
    overflow: hidden;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
    background-color: #f8f9fa;
}

.event-poster-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.no-poster {
    height: 400px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
}

/* ======== Info Item ======== */
.info-item {
    background-color: #f8f9fa;
    border-radius: 8px;
    padding: 12px 16px;
}

.info-item i {
    color: #0041C2;
}

/* ======== Button ======== */
.btn-primary {
    background-color: #0041C2;
    border: none;
    border-radius: 6px;
    font-weight: 500;
    transition: background 0.2s ease;
}

.btn-primary:hover {
    background-color: #003399;
}

.btn-outline-primary {
    border-color: #0041C2;
    color: #0041C2;
    border-radius: 6px;
    font-weight: 500;
    transition: background 0.2s ease;
}

.btn-outline-primary:hover {
    background-color: #0041C2;
    color: white;
}
</style>
@endsection

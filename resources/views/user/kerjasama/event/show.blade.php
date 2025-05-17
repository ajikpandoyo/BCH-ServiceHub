@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="event-poster-container">
                    @if($event->poster)
                        <img src="{{ $event->poster_url }}" 
                             class="card-img-top" 
                             alt="{{ $event->nama_event }}"
                             onerror="this.onerror=null; this.src='{{ asset('images/default-event.jpg') }}';">
                    @else
                        <div class="no-poster">
                            <i class="fas fa-image"></i>
                            <span>Tidak ada poster</span>
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <h1 class="card-title mb-4">{{ $event->nama_event }}</h1>
                    
                    <div class="event-info mb-4">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="info-item">
                                    <i class="fas fa-calendar me-2"></i>
                                    <span>Tanggal Pelaksanaan</span>
                                    <p class="mb-0">{{ $event->tanggal_pelaksanaan }}</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-item">
                                    <i class="fas fa-clock me-2"></i>
                                    <span>Waktu</span>
                                    <p class="mb-0">{{ $event->waktu }}</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-item">
                                    <i class="fas fa-map-marker-alt me-2"></i>
                                    <span>Lokasi</span>
                                    <p class="mb-0">{{ $event->lokasi_ruangan }}</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-item">
                                    <i class="fas fa-users me-2"></i>
                                    <span>Kapasitas</span>
                                    <p class="mb-0">{{ $event->kapasitas }} orang</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="event-description mb-4">
                        <h5 class="mb-3">Deskripsi Event</h5>
                        <p class="text-muted">{{ $event->deskripsi }}</p>
                    </div>

                    <div class="event-requirements mb-4">
                        <h5 class="mb-3">Persyaratan</h5>
                        <p class="text-muted">{{ $event->persyaratan }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm sticky-top" style="top: 20px;">
                <div class="card-body">
                    <h5 class="card-title mb-4">Informasi Pendaftaran</h5>
                    
                    <div class="d-grid gap-2">
                        <a href="{{ route('peminjaman.event.form', $event->id) }}" class="btn btn-primary w-100">
                            <i class="fas fa-pencil-alt me-2"></i>Daftar Event
                        </a>
                        <a href="{{ route('kerjasama.event.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Event
                        </a>
                    </div>

                    <hr>

                 
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border: none;
    border-radius: 12px;
}

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
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background-color: #f8f9fa;
    color: #6b7280;
}

.no-poster i {
    font-size: 3rem;
    margin-bottom: 1rem;
}

.info-item {
    background-color: #f8f9fa;
    padding: 1rem;
    border-radius: 8px;
}

.info-item span {
    font-size: 0.8rem;
    color: #6b7280;
}

.info-item p {
    font-weight: 500;
    color: #1a1a1a;
}

.btn-primary {
    background-color: #0041C2;
    border: none;
    padding: 10px;
    border-radius: 6px;
}

.btn-primary:hover {
    background-color: #003399;
}

.btn-outline-primary {
    border-color: #0041C2;
    color: #0041C2;
}

.btn-outline-primary:hover {
    background-color: #0041C2;
    color: white;
}

.fas {
    color: #0041C2;
}

.contact-info {
    background-color: #f8f9fa;
    padding: 1rem;
    border-radius: 8px;
}

.contact-info h6 {
    color: #1a1a1a;
    font-weight: 600;
}

.contact-info p {
    margin-bottom: 0.5rem;
    color: #4b5563;
}
</style>
@endsection
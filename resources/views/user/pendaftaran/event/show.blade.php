@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 100px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="event-detail-card">
                @if($event->poster)
                    <img src="{{ asset('storage/' . $event->poster) }}" class="event-poster" alt="{{ $event->nama_event }}">
                @endif
                <div class="event-content">
                    <h1>{{ $event->nama_event }}</h1>
                    
                    <div class="event-meta">
                        <div class="meta-item">
                            <i class="fas fa-calendar"></i>
                            <span>{{ \Carbon\Carbon::parse($event->tanggal_pelaksanaan)->format('d F Y') }}</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-clock"></i>
                            <span>{{ $event->waktu }} WIB</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $event->lokasi_ruangan }}</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-user-tie"></i>
                            <span>{{ $event->penyelenggara }}</span>
                        </div>
                    </div>

                    <div class="event-description">
                        <h4>Deskripsi Event</h4>
                        <p>{{ $event->deskripsi }}</p>
                    </div>

                    <div class="event-actions">
                        <a href="{{ route('pendaftaran.event.register', $event->id) }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-user-plus me-2"></i>Daftar Event
                        </a>
                        <a href="{{ route('pendaftaran.event.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.event-detail-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.1);
    overflow: hidden;
    margin-bottom: 30px;
}

.event-poster {
    width: 100%;
    height: 300px;
    object-fit: cover;
}

.event-content {
    padding: 30px;
}

.event-content h1 {
    color: #0041C2;
    margin-bottom: 20px;
    font-weight: 600;
}

.event-meta {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    margin-bottom: 30px;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 10px;
}

.meta-item i {
    color: #0041C2;
    font-size: 1.2rem;
}

.event-description {
    margin-bottom: 30px;
}

.event-description h4 {
    color: #0041C2;
    margin-bottom: 15px;
}

.event-description p {
    color: #555;
    line-height: 1.6;
}

.event-actions {
    display: flex;
    gap: 15px;
    margin-top: 30px;
}

.btn-primary {
    background: #0041C2;
    border: none;
}

.btn-primary:hover {
    background: #003399;
}

.btn-outline-secondary {
    border-color: #6c757d;
    color: #6c757d;
}

.btn-outline-secondary:hover {
    background: #6c757d;
    color: white;
}
</style>
@endsection
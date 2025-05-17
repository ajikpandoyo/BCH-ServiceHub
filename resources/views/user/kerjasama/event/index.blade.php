@extends('layouts.app')

@section('content')
<div class="container mt-5 py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">Daftar Event</h2>
            <p class="text-muted">Temukan event menarik untuk kerjasama</p>
        </div>
    </div>

    <div class="row">
        @forelse($events as $event)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
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
                        <h5 class="card-title">{{ $event->nama_event }}</h5>
                        <p class="card-text text-muted">
                            <small>
                                <i class="fas fa-calendar me-2"></i>{{ $event->tanggal_pelaksanaan }}<br>
                                <i class="fas fa-clock me-2"></i>{{ $event->waktu }}<br>
                                <i class="fas fa-map-marker-alt me-2"></i>{{ $event->lokasi_ruangan }}
                            </small>
                        </p>
                        <p class="card-text">{{ Str::limit($event->deskripsi, 100) }}</p>
                    </div>
                    <div class="card-footer bg-white">
                        <a href="{{ route('kerjasama.event.show', $event->id) }}" class="btn btn-primary w-100">
                            <i class="fas fa-info-circle me-2"></i>Detail Event
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>Tidak ada event yang tersedia saat ini.
                </div>
            </div>
        @endforelse
    </div>

    <div class="row mt-4">
        <div class="col-12">
            {{ $events->links() }}
        </div>
    </div>
</div>

<style>
.card {
    border: none;
    border-radius: 12px;
    transition: transform 0.2s;
}

.card:hover {
    transform: translateY(-5px);
}

.event-poster-container {
    height: 200px;
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
    height: 200px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background-color: #f8f9fa;
    color: #6b7280;
}

.no-poster i {
    font-size: 2rem;
    margin-bottom: 0.5rem;
}

.card-title {
    font-size: 1.1rem;
    font-weight: 600;
}

.card-text {
    font-size: 0.9rem;
}

.btn-primary {
    background-color: #0041C2;
    border: none;
    padding: 8px;
    border-radius: 6px;
}

.btn-primary:hover {
    background-color: #003399;
}

.fas {
    color: #0041C2;
}
</style>
@endsection
@extends('layouts.app')

@section('content')
<div class="event-header">
    <div class="container" style="margin-top: 100px;">
        <div class="text-center py-5">
            <h1 class="fw-bold">Semua Event</h1>
            <p class="text-muted">Daftar lengkap event yang tersedia</p>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row g-4">
        @foreach($events as $event)
            <div class="col-md-6">
                <div class="event-card">
                    @if($event->poster)
                        <img src="{{ asset('storage/' . $event->poster) }}" class="event-poster" alt="{{ $event->nama_event }}">
                    @endif
                    <div class="event-content">
                        <h3>{{ $event->nama_event }}</h3>
                        <div class="event-info">
                            <p><i class="fas fa-calendar me-2"></i>{{ \Carbon\Carbon::parse($event->tanggal_pelaksanaan)->format('d M Y') }}</p>
                            <p><i class="fas fa-clock me-2"></i>{{ $event->waktu }} WIB</p>
                            <p><i class="fas fa-map-marker-alt me-2"></i>{{ $event->lokasi_ruangan }}</p>
                            <p><i class="fas fa-user-tie me-2"></i>{{ $event->penyelenggara }}</p>
                        </div>
                        <p class="event-description">{{ Str::limit($event->deskripsi, 150) }}</p>
                        <div class="event-actions">
                            <a href="{{ route('pendaftaran.event.show', $event->id) }}" class="btn btn-primary">
                                <i class="fas fa-info-circle me-2"></i>Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $events->links() }}
    </div>
</div>

<style>
.event-header {
    background: linear-gradient(135deg, #0041C2, #0052cc);
    color: white;
    padding: 2rem 0;
}

.event-card {
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.1);
    overflow: hidden;
    transition: transform 0.3s;
    margin-bottom: 20px;
}

.event-poster {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.event-card:hover {
    transform: translateY(-5px);
}

.event-content {
    padding: 20px;
}

.event-content h3 {
    color: #0041C2;
    margin-bottom: 15px;
    font-weight: 600;
}

.event-info {
    margin-bottom: 15px;
}

.event-info p {
    color: #666;
    margin-bottom: 8px;
}

.event-description {
    color: #555;
    margin-bottom: 20px;
}

.btn-primary {
    background: #0041C2;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
}

.btn-primary:hover {
    background: #003399;
}

/* Pagination Styling */
.pagination {
    justify-content: center;
    gap: 5px;
}

.page-link {
    color: #0041C2;
    border: none;
    padding: 8px 16px;
    border-radius: 8px;
}

.page-item.active .page-link {
    background-color: #0041C2;
    border-color: #0041C2;
}

.page-item.disabled .page-link {
    background-color: #f8f9fa;
    color: #6c757d;
}
</style>
@endsection
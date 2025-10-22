@extends('layouts.app')

@section('content')
<div class="container ruangan-index">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Event</li>
        </ol>
    </nav>

    {{-- Header --}}
    <div class="ruangan-header">
        <h1>Daftar Event</h1>
        <p>
            Temukan berbagai event menarik di Bandung Creative Hub.<br>
            Bergabunglah dalam kegiatan kolaboratif dan inspiratif bersama komunitas kreatif.
        </p>
    </div>

    {{-- Search --}}
    <form action="{{ route('kerjasama.event.index') }}" method="GET" class="d-flex justify-content-center align-items-center gap-3 mb-5">
        <div class="position-relative" style="max-width: 400px; width: 100%;">
            <input type="text" name="search" class="form-control search-input" placeholder="Cari Event..." value="{{ request('search') }}">
            <button type="submit" class="btn position-absolute top-50 end-0 translate-middle-y text-secondary border-0 bg-transparent pe-3">
                <i class="fas fa-search"></i>
            </button>
        </div>
        <button type="submit" class="btn btn-primary px-4">Cari Event</button>
    </form>

    {{-- Grid Event --}}
    <div class="row g-4">
        @forelse($events as $event)
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                @if($event->poster)
                    <img src="{{ $event->poster_url }}" class="card-img-top" alt="{{ $event->nama_event }}" style="height: 200px; object-fit: cover;" onerror="this.onerror=null; this.src='{{ asset('images/default-event.jpg') }}';">
                @else
                    <div class="d-flex flex-column justify-content-center align-items-center text-muted" style="height: 200px; background-color: #f8f9fa;">
                        <i class="fas fa-image fa-2x mb-2"></i>
                        <small>Tidak ada poster</small>
                    </div>
                @endif

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fw-semibold mb-2">{{ $event->nama_event }}</h5>
                    <p class="card-text text-muted flex-grow-1">{{ Str::limit($event->deskripsi, 100) }}</p>

                    <div class="mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-calendar text-primary me-2"></i>
                            <span>{{ $event->tanggal_pelaksanaan }}</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-clock text-primary me-2"></i>
                            <span>{{ $event->waktu }}</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-map-marker-alt text-primary me-2"></i>
                            <span>{{ $event->lokasi_ruangan }}</span>
                        </div>
                    </div>

                    <a href="{{ route('kerjasama.event.show', $event->id) }}" class="btn btn-primary mt-auto">Lihat Detail</a>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-5 text-muted">
            <i class="fas fa-calendar-times fa-3x mb-3"></i>
            @if(request('search'))
                <p>Tidak ada event dengan nama "{{ request('search') }}"</p>
            @else
                <p>Tidak ada event yang tersedia saat ini</p>
            @endif
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="row mt-5">
        <div class="col-12 d-flex justify-content-center">
            {{ $events->links() }}
        </div>
    </div>
</div>

<style>
/* ======== Struktur & Padding ======== */
.container.ruangan-index {
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

/* ======== Search Section ======== */
.search-input {
    border-radius: 8px;
    height: 44px;
    padding-right: 40px;
}

/* ======== Button Style ======== */
.btn-primary {
    background-color: #0041C2;
    border: none;
    border-radius: 6px;
    font-weight: 500;
    transition: all 0.2s ease;
}

.btn-primary:hover {
    background-color: #003399;
}

/* ======== Card Style ======== */
.card {
    border-radius: 12px;
    overflow: hidden;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 16px rgba(0,0,0,0.1);
}

.card-title {
    color: #1a1a1a;
}

.card-text {
    font-size: 14px;
    line-height: 1.6;
}

/* ======== Icon ======== */
.text-primary {
    color: #0041C2 !important;
}
</style>
@endsection

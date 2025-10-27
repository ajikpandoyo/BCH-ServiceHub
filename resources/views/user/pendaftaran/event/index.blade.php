@extends('layouts.app')

@section('content')
<div class="container pendaftaran-event-index mt-5 pt-5">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pendaftaran Event</li>
        </ol>
    </nav>

    {{-- Header --}}
    <div class="event-header">
        <h1>Event yang tersedia</h1>
        <p>
            Bandung Creative Hub menyelenggarakan berbagai event untuk para pelaku industri kreatif.<br>
            Berupa workshop, seminar, pameran, dll.
        </p>
    </div>

    {{-- Search Section --}}
    <form action="{{ route('pendaftaran.event.cari') }}" method="GET" class="d-flex justify-content-center align-items-center gap-3 mb-5 flex-wrap">
        <div class="position-relative" style="max-width: 400px; width: 100%;">
            <input 
                type="text" 
                name="search" 
                class="form-control search-input" 
                placeholder="Cari Event..." 
                value="{{ request('search') }}"
            >
            <button type="submit" class="btn position-absolute top-50 end-0 translate-middle-y text-secondary border-0 bg-transparent pe-3">
                <i class="fas fa-search"></i>
            </button>
        </div>

        <input 
            type="date" 
            name="tanggal" 
            class="form-control date-input"
            value="{{ request('tanggal') }}"
            style="max-width: 200px;"
        >

        <button type="submit" class="btn btn-primary px-4">Cari Event</button>
    </form>

    {{-- Event Grid --}}
    <div class="row g-4">
        @forelse($events as $event)
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <img src="{{ Storage::url($event->gambar) }}" class="card-img-top" alt="{{ $event->nama_event }}" style="height: 200px; object-fit: cover;">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fw-semibold mb-2">{{ $event->nama_event }}</h5>
                    <p class="card-text text-muted flex-grow-1">{{ Str::limit($event->deskripsi, 100) }}</p>

                    <div class="mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-users text-primary me-2"></i>
                            <span>{{ $event->kuota }} orang</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-calendar text-primary me-2"></i>
                            <span>{{ $event->tanggal_pelaksanaan }}</span>
                        </div>
                    </div>

                    <a href="{{ route('pendaftaran.event.form', $event->id) }}" class="btn btn-primary mt-auto">Daftar</a>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-5 text-muted">
            <i class="fas fa-calendar-times fa-3x mb-3"></i>
            @if(request('search') || request('tanggal'))
                <p>Tidak ada event yang cocok dengan pencarian Anda.</p>
            @else
                <p>Tidak ada event yang tersedia saat ini</p>
            @endif
        </div>
        @endforelse
    </div>
</div>

<style>
/* ======== Struktur & Padding ======== */
.container.pendaftaran-event-index {
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
.event-header {
    text-align: center;
    margin-bottom: 40px;
}

.event-header h1 {
    font-size: 32px;
    color: #1a1a1a;
    margin-bottom: 16px;
}

.event-header p {
    color: #666;
    line-height: 1.6;
}

/* ======== Search Section ======== */
.search-input {
    border-radius: 8px;
    height: 44px;
    padding-right: 40px;
}

.date-input {
    border-radius: 8px;
    height: 44px;
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

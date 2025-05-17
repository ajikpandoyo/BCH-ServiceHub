@extends('layouts.app')

@section('content')
<div class="event-container">
    <div class="event-header">
        <h1>Event yang tersedia</h1>
        <p>Bandung Creative Hub menyelenggarakan berbagai event untuk para pelaku industri kreatif.<br>
           Berupa workshop, seminar, pameran, dll.</p>
    </div>

    <div class="search-section">
        <div class="search-box">
            <input type="text" placeholder="Cari Event" class="search-input">
            <button type="button" class="search-icon">
                <i class="fas fa-search"></i>
            </button>
        </div>
        <div class="date-filter">
            <input type="date" class="date-input">
        </div>
        <button class="btn-cari-event">Cari Event</button>
    </div>

    <div class="event-grid">
        @forelse($events as $event)
        <div class="event-card">
            <img src="{{ Storage::url($event->gambar) }}" alt="{{ $event->nama_event }}" class="event-image">
            <div class="event-content">
                <h3>{{ $event->nama_event }}</h3>
                <p>{{ Str::limit($event->deskripsi, 100) }}</p>
                <div class="event-info">
                    <span><i class="fas fa-users"></i> {{ $event->kuota }} orang</span>
                    <span><i class="fas fa-calendar"></i> {{ $event->tanggal_pelaksanaan }}</span>
                </div>
                <div class="event-actions">
                    <a href="{{ route('pendaftaran.event.form', $event->id) }}" class="btn-daftar">Daftar</a>
                </div>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <i class="fas fa-calendar-times"></i>
            <p>Tidak ada event yang tersedia saat ini</p>
        </div>
        @endforelse
    </div>
</div>

@push('styles')
<style>
.event-container {
    padding: 100px;
    max-width: 1200px;
    margin: 0 auto;
}

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

.search-section {
    display: flex;
    gap: 16px;
    margin-bottom: 40px;
    justify-content: center;
}

.search-box {
    position: relative;
    flex: 1;
    max-width: 400px;
}

.search-input {
    width: 100%;
    padding: 12px 40px 12px 16px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 14px;
}

.search-icon {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #64748b;
}

.date-input {
    padding: 12px 16px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 14px;
}

.btn-cari-event {
    background: #2563eb;
    color: white;
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    font-weight: 500;
    cursor: pointer;
    transition: background 0.2s;
}

.btn-cari-event:hover {
    background: #1d4ed8;
}

.event-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 24px;
}

.event-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: transform 0.2s;
}

.event-card:hover {
    transform: translateY(-4px);
}

.event-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.event-content {
    padding: 20px;
}

.event-content h3 {
    font-size: 18px;
    color: #1a1a1a;
    margin-bottom: 12px;
}

.event-content p {
    color: #666;
    font-size: 14px;
    margin-bottom: 16px;
    line-height: 1.5;
}

.event-info {
    display: flex;
    gap: 16px;
    margin-bottom: 16px;
    font-size: 14px;
    color: #64748b;
}

.event-info i {
    margin-right: 6px;
}

.event-actions {
    display: flex;
    justify-content: flex-end;
}

.btn-daftar {
    background: #2563eb;
    color: white;
    padding: 8px 16px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    transition: background 0.2s;
}

.btn-daftar:hover {
    background: #1d4ed8;
}

.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 60px 20px;
    color: #94a3b8;
}

.empty-state i {
    font-size: 48px;
    margin-bottom: 16px;
}

.empty-state p {
    font-size: 16px;
}
</style>
@endpush
@endsection
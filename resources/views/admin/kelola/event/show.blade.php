@extends('layouts.admin')

@section('content')
<div class="main-content">
    <div class="top-bar">
        <div class="page-title">
            <h2>Detail Event</h2>
            <p class="breadcrumb">
                <a href="{{ route('admin.kelola.event.index') }}" class="text-blue-600">Kelola Event</a> / Detail
            </p>
        </div>
    </div>

    <div class="detail-card">
        <div class="event-info">
            @if($event->gambar)
                <div class="event-image">
                    <img src="{{ asset('images/event/' . $event->gambar) }}" alt="{{ $event->nama_event }}">
                </div>
            @endif
            <h3>{{ $event->nama_event }}</h3>
            <div class="info-grid">
                <div class="info-item">
                    <label>Tanggal Pelaksanaan</label>
                    <p>{{ \Carbon\Carbon::parse($event->tanggal)->format('d M Y') }}</p>
                </div>
                <div class="info-item">
                    <label>Waktu</label>
                    <p>{{ $event->waktu }}</p>
                </div>
                <div class="info-item">
                    <label>Penyelenggara</label>
                    <p>{{ $event->penyelenggara }}</p>
                </div>
                <div class="info-item">
                    <label>Lokasi Ruangan</label>
                    <p>{{ $event->lokasi_ruangan }}</p>
                </div>
                <div class="info-item">
                    <label>Status</label>
                    <span class="status {{ strtolower($event->status) }}">{{ $event->status }}</span>
                </div>
            </div>
        </div>

        <div class="action-buttons">
            <a href="{{ route('admin.kelola.event.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
          
        </div>
    </div>
</div>

<style>
    .detail-card {
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .event-info h3 {
        font-size: 24px;
        color: #2d3748;
        margin-bottom: 20px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .info-item {
        padding: 15px;
        background: #f8f9fa;
        border-radius: 8px;
    }

    .info-item label {
        color: #666;
        font-size: 14px;
        display: block;
        margin-bottom: 5px;
    }

    .info-item p {
        color: #2d3748;
        font-size: 16px;
        margin: 0;
    }

    .action-buttons {
        margin-top: 30px;
        display: flex;
        gap: 10px;
        justify-content: flex-end;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 500;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-secondary {
        background: #f7fafc;
        color: #4a5568;
        border: 1px solid #e2e8f0;
    }

    .btn-primary {
        background: #0041C2;
        color: white;
        border: none;
    }

    .event-image {
        width: 100%;
        margin-bottom: 24px;
        border-radius: 10px;
        overflow: hidden;
    }

    .event-image img {
        width: 100%;
        height: auto;
        object-fit: cover;
        max-height: 400px;
    }
</style>
@endsection
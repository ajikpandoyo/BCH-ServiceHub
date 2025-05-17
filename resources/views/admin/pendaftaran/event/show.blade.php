@extends('layouts.admin')

@section('content')
<div class="main-content">
    <div class="content-header">
        <div class="header-left">
            <h2>Detail Pendaftaran Event</h2>
            <p class="text-muted">{{ $registration->event->name ?? 'Event tidak ditemukan' }}</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.pendaftaran.event.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="registration-details">
        <div class="detail-card">
            <div class="card-header">
                <h3>Informasi Pendaftar</h3>
                <span class="status-badge status-{{ $statusClass }}">
                    {{ $statusText }}
                </span>
            </div>
            
            <div class="card-body">
                <div class="info-grid">
                    <div class="info-item">
                        <label>Nama Lengkap</label>
                        <p>{{ $registration->nama_lengkap }}</p>
                    </div>
                    
                    <div class="info-item">
                        <label>Nomor WhatsApp</label>
                        <p>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $registration->whatsapp) }}" 
                               target="_blank" 
                               class="whatsapp-link">
                                <i class="fab fa-whatsapp"></i>
                                {{ $registration->whatsapp }}
                            </a>
                        </p>
                    </div>

                    <div class="info-item">
                        <label>Instagram</label>
                        <p>
                            <a href="https://instagram.com/{{ ltrim($registration->instagram, '@') }}" 
                               target="_blank" 
                               class="instagram-link">
                                <i class="fab fa-instagram"></i>
                                {{ $registration->instagram }}
                            </a>
                        </p>
                    </div>

                    <div class="info-item full-width">
                        <label>Alamat</label>
                        <p>{{ $registration->alamat }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="detail-card">
            <div class="card-header">
                <h3>Informasi Pendaftaran</h3>
                <span class="date-badge">
                    <i class="far fa-calendar"></i>
                    {{ $registration->created_at ? $registration->created_at->format('d F Y') : 'Tanggal tidak tersedia' }}
                </span>
            </div>
            
            <div class="card-body">
                <div class="info-grid">
                    <div class="info-item">
                        <label>Sumber Informasi</label>
                        <p>{{ $registration->sumber_informasi }}</p>
                    </div>

                    <div class="info-item full-width">
                        <label>Alasan Mengikuti Event</label>
                        <p class="reason-text">{{ $registration->alasan }}</p>
                    </div>

                    <div class="info-item full-width">
                        <label>Bukti Follow</label>
                        <div class="proof-image">
                            <img src="{{ asset('storage/' . $registration->bukti_follow) }}" 
                                 alt="Bukti Follow" 
                                 onclick="window.open(this.src)">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .content-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .header-left p {
        margin-top: 0.5rem;
        color: #6b7280;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background-color: #f3f4f6;
        border-radius: 0.5rem;
        color: #374151;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-back:hover {
        background-color: #e5e7eb;
    }

    .registration-details {
        display: grid;
        gap: 1.5rem;
    }

    .detail-card {
        background: white;
        border-radius: 0.75rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .card-header {
        padding: 1.5rem;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-body {
        padding: 1.5rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }

    .info-item.full-width {
        grid-column: span 2;
    }

    .info-item label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        color: #6b7280;
        margin-bottom: 0.5rem;
    }

    .info-item p {
        margin: 0;
        color: #111827;
        font-size: 1rem;
    }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .status-success {
        background-color: #ecfdf5;
        color: #059669;
    }

    .status-pending {
        background-color: #fffbeb;
        color: #d97706;
    }

    .whatsapp-link, .instagram-link {
        color: #374151;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .whatsapp-link:hover {
        color: #25d366;
    }

    .instagram-link:hover {
        color: #e1306c;
    }

    .proof-image img {
        max-width: 300px;
        border-radius: 0.5rem;
        cursor: pointer;
        transition: transform 0.2s;
    }

    .proof-image img:hover {
        transform: scale(1.02);
    }

    .reason-text {
        line-height: 1.6;
    }

    .date-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: #6b7280;
        font-size: 0.875rem;
    }
</style>
@endpush
@endsection
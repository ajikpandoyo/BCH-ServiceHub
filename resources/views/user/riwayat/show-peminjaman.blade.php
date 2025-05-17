@extends('layouts.app')

@section('content')
<div class="riwayat-detail-container">
    <div class="detail-card">
        <div class="card-header">
            <h1>Detail Peminjaman</h1>
            <div class="status-badge {{ strtolower($peminjaman->status) }}">
                {{ ucfirst($peminjaman->status) }}
            </div>
        </div>

        <div class="detail-content">
            <div class="detail-group">
                <label>Nama Peminjam</label>
                <p>{{ $peminjaman->nama_lengkap }}</p>
            </div>

            <div class="detail-group">
                <label>Email</label>
                <p>{{ $peminjaman->email }}</p>
            </div>

            <div class="detail-group">
                <label>No. Telepon</label>
                <p>{{ $peminjaman->no_telepon }}</p>
            </div>

            <div class="detail-group">
                <label>Instansi</label>
                <p>{{ $peminjaman->instansi }}</p>
            </div>

            <div class="detail-group">
                <label>Tanggal Pengajuan</label>
                <p>{{ $peminjaman->created_at->format('d F Y') }}</p>
            </div>

            @if($peminjaman->keterangan)
            <div class="detail-group">
                <label>Keterangan</label>
                <p>{{ $peminjaman->keterangan }}</p>
            </div>
            @endif
        </div>

        <div class="action-buttons">
            <a href="{{ route('riwayat.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

@push('styles')
<style>
.riwayat-detail-container {
    max-width: 800px;
    margin: 2rem auto;
    padding: 0 1rem;
}

.detail-card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.card-header {
    padding: 1.5rem;
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-header h1 {
    font-size: 1.5rem;
    font-weight: 600;
    color: #1e293b;
    margin: 0;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 9999px;
    font-weight: 500;
    font-size: 0.875rem;
}

.status-badge.pending {
    background: #fef3c7;
    color: #92400e;
}

.status-badge.approved {
    background: #dcfce7;
    color: #166534;
}

.status-badge.rejected {
    background: #fee2e2;
    color: #991b1b;
}

.detail-content {
    padding: 1.5rem;
}

.detail-group {
    margin-bottom: 1.5rem;
}

.detail-group:last-child {
    margin-bottom: 0;
}

.detail-group label {
    display: block;
    font-size: 0.875rem;
    font-weight: 500;
    color: #64748b;
    margin-bottom: 0.5rem;
}

.detail-group p {
    font-size: 1rem;
    color: #1e293b;
    margin: 0;
}

.action-buttons {
    padding: 1.5rem;
    background: #f8fafc;
    border-top: 1px solid #e2e8f0;
}

.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 0.5rem;
    color: #64748b;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-back:hover {
    background: #f8fafc;
    color: #1e293b;
}

@media (max-width: 640px) {
    .riwayat-detail-container {
        margin: 1rem auto;
    }

    .card-header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
}
</style>
@endpush
@endsection
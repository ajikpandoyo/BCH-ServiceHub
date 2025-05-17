@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 80px;">
    <div class="riwayat-detail-card">
        <div class="card-header">
            <h1>Detail Riwayat</h1>
            <span class="status-badge {{ strtolower($riwayat->status) }}">
                {{ ucfirst($riwayat->status) }}
            </span>
        </div>

        <div class="card-body">
            <div class="detail-item">
                <label>Jenis Pengajuan</label>
                <p>{{ $riwayat->jenis }}</p>
            </div>

            <div class="detail-item">
                <label>Tanggal Pengajuan</label>
                <p>{{ $riwayat->created_at->format('d F Y') }}</p>
            </div>

            @if($riwayat->keterangan)
            <div class="detail-item">
                <label>Keterangan</label>
                <p>{{ $riwayat->keterangan }}</p>
            </div>
            @endif
        </div>

        <div class="card-footer">
            <a href="{{ route('riwayat.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

@push('styles')
<style>
.riwayat-detail-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    margin: 24px 0;
}

.card-header {
    padding: 20px;
    border-bottom: 1px solid #eee;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-header h1 {
    font-size: 24px;
    color: #1E293B;
    margin: 0;
}

.status-badge {
    padding: 8px 16px;
    border-radius: 9999px;
    font-weight: 500;
    font-size: 14px;
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

.card-body {
    padding: 20px;
}

.detail-item {
    margin-bottom: 20px;
}

.detail-item:last-child {
    margin-bottom: 0;
}

.detail-item label {
    display: block;
    font-size: 14px;
    color: #64748b;
    margin-bottom: 8px;
}

.detail-item p {
    font-size: 16px;
    color: #1e293b;
    margin: 0;
}

.card-footer {
    padding: 20px;
    border-top: 1px solid #eee;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    border-radius: 6px;
    font-weight: 500;
    font-size: 14px;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-secondary {
    background: #f1f5f9;
    color: #64748b;
    border: 1px solid #e2e8f0;
}

.btn-secondary:hover {
    background: #e2e8f0;
    color: #1e293b;
}
</style>
@endpush
@endsection
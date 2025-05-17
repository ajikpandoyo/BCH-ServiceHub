@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="{{ route('riwayat.index') }}" class="breadcrumb-link">
            <i class="fas fa-history"></i> Riwayat Pengajuan
        </a>
        <i class="fas fa-chevron-right separator"></i>
        <span class="current-page">Detail Kunjungan Visit</span>
    </div>

    <div class="detail-card">
        <div class="card-header">
            <div class="header-content">
                <h1 class="card-title">
                    <i class="fas fa-building text-primary"></i>
                    Detail Kunjungan Visit
                </h1>
                <span class="status-badge status-{{ strtolower($kunjungan->status) }}">
                    <i class="fas fa-circle status-icon"></i>
                    {{ ucfirst($kunjungan->status) }}
                </span>
            </div>
        </div>

        <div class="card-body">
            <!-- Informasi Pemohon -->
            <div class="detail-section">
                <h2 class="section-title">
                    <i class="fas fa-user-circle"></i> Informasi Pemohon
                </h2>
                <div class="info-grid">
                    <div class="info-item">
                        <label>Nama Lengkap</label>
                        <p>{{ $kunjungan->nama_pemohon }}</p>
                    </div>
                    <div class="info-item">
                        <label>Email</label>
                        <p>{{ $kunjungan->email }}</p>
                    </div>
                    <div class="info-item">
                        <label>Instansi</label>
                        <p>{{ $kunjungan->instansi }}</p>
                    </div>
                    <div class="info-item">
                        <label>No. Telepon</label>
                        <p>{{ $kunjungan->no_telepon }}</p>
                    </div>
                </div>
            </div>

            <!-- Detail Kunjungan -->
            <div class="detail-section">
                <h2 class="section-title">
                    <i class="fas fa-info-circle"></i> Detail Kunjungan
                </h2>
                <div class="info-grid">
                    <div class="info-item">
                        <label>Tanggal Kunjungan</label>
                        <p>{{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->format('d F Y') }}</p>
                    </div>
                    <div class="info-item">
                        <label>Waktu</label>
                        <p>{{ \Carbon\Carbon::parse($kunjungan->waktu_kunjungan)->format('H:i') }} WIB</p>
                    </div>
                    <div class="info-item">
                        <label>Jumlah Peserta</label>
                        <p>{{ $kunjungan->jumlah_peserta }} orang</p>
                    </div>
                </div>
                <div class="info-item full-width">
                    <label>Tujuan Kunjungan</label>
                    <p class="purpose-text">{{ $kunjungan->tujuan_kunjungan }}</p>
                </div>
            </div>

            <!-- Status Info -->
            <div class="detail-section status-section">
                <h2 class="section-title">
                    <i class="fas fa-clock"></i> Status Pengajuan
                </h2>
                <div class="status-timeline">
                    <div class="timeline-item">
                        <div class="timeline-icon">
                            <i class="fas fa-paper-plane"></i>
                        </div>
                        <div class="timeline-content">
                            <h3>Pengajuan Dibuat</h3>
                            <p>{{ \Carbon\Carbon::parse($kunjungan->created_at)->format('d F Y H:i') }}</p>
                        </div>
                    </div>
                    @if($kunjungan->status_updated_at)
                    <div class="timeline-item">
                        <div class="timeline-icon {{ $kunjungan->status }}">
                            <i class="fas {{ $kunjungan->status === 'disetujui' ? 'fa-check' : 'fa-times' }}"></i>
                        </div>
                        <div class="timeline-content">
                            <h3>Status Diperbarui</h3>
                            <p>{{ \Carbon\Carbon::parse($kunjungan->status_updated_at)->format('d F Y H:i') }}</p>
                            @if($kunjungan->status === 'ditolak' && $kunjungan->rejection_reason)
                            <div class="rejection-box">
                                <strong>Alasan Penolakan:</strong>
                                <p>{{ $kunjungan->rejection_reason }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="action-buttons">
                <a href="{{ route('riwayat.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.content-wrapper {
    padding: 24px;
    background: #f1f5f9;
    min-height: 100vh;
}

.breadcrumb {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 24px;
    font-size: 14px;
}

.breadcrumb-link {
    color: #64748b;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 8px;
}

.separator {
    color: #94a3b8;
    font-size: 12px;
}

.current-page {
    color: #1e293b;
    font-weight: 500;
}

.detail-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    overflow: hidden;
}

.card-header {
    padding: 24px;
    border-bottom: 1px solid #e2e8f0;
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-title {
    font-size: 24px;
    color: #1e293b;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 12px;
}

.card-body {
    padding: 24px;
}

.detail-section {
    margin-bottom: 32px;
    background: #f8fafc;
    padding: 24px;
    border-radius: 8px;
}

.section-title {
    font-size: 18px;
    color: #1e293b;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 24px;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.info-item label {
    font-size: 14px;
    color: #64748b;
    font-weight: 500;
}

.info-item p {
    font-size: 15px;
    color: #1e293b;
    margin: 0;
}

.full-width {
    grid-column: 1 / -1;
}

.purpose-text {
    padding: 16px;
    background: white;
    border-radius: 8px;
    line-height: 1.6;
}

.status-timeline {
    position: relative;
    padding-left: 32px;
}

.timeline-item {
    position: relative;
    padding-bottom: 24px;
}

.timeline-item:not(:last-child):before {
    content: '';
    position: absolute;
    left: -24px;
    top: 30px;
    bottom: 0;
    width: 2px;
    background: #e2e8f0;
}

.timeline-icon {
    position: absolute;
    left: -32px;
    width: 24px;
    height: 24px;
    background: #e2e8f0;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.timeline-icon.disetujui {
    background: #059669;
}

.timeline-icon.ditolak {
    background: #dc2626;
}

.timeline-content {
    background: white;
    padding: 16px;
    border-radius: 8px;
    margin-left: 8px;
}

.timeline-content h3 {
    font-size: 16px;
    margin: 0 0 8px 0;
    color: #1e293b;
}

.rejection-box {
    margin-top: 16px;
    padding: 16px;
    background: #fee2e2;
    border-radius: 6px;
    color: #991b1b;
}

.status-badge {
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 8px;
}

.status-badge.status-disetujui {
    background: #dcfce7;
    color: #166534;
}

.status-badge.status-ditolak {
    background: #fee2e2;
    color: #991b1b;
}

.status-badge.status-pending {
    background: #fef3c7;
    color: #92400e;
}

.status-icon {
    font-size: 8px;
}

.action-buttons {
    margin-top: 32px;
    display: flex;
    gap: 16px;
}

.btn {
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-secondary {
    background: #e2e8f0;
    color: #475569;
}

.btn-secondary:hover {
    background: #cbd5e1;
    color: #1e293b;
}
</style>
@endsection
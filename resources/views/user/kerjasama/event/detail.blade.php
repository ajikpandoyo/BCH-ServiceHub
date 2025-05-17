@extends('layouts.app')

@section('content')
<div class="booking-detail-header">
    <div class="container">
        <div class="text-center py-5">
            <h1 class="fw-bold">Detail Booking Event</h1>
            <p class="text-muted">Status pengajuan kerja sama event Anda</p>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-body p-5">
                    <div class="status-badge mb-4 text-center">
                        <span class="badge bg-warning px-4 py-2">Menunggu Konfirmasi Admin</span>
                    </div>

                    <div class="booking-info">
                        <h3 class="mb-4">Informasi Booking</h3>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label>Nama Event</label>
                                    <p>{{ $booking->nama_event ?? 'Tech Conference 2024' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label>Tanggal Pengajuan</label>
                                    <p>{{ $booking->created_at ?? now()->format('d M Y') }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label>Status</label>
                                    <p class="text-warning">Menunggu Konfirmasi</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label>Nomor Booking</label>
                                    <p>#{{ $booking->id ?? 'BCH-2024001' }}</p>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="uploaded-documents">
                            <h4 class="mb-3">Dokumen Yang Diupload</h4>
                            <div class="document-list">
                                <div class="document-item">
                                    <i class="fas fa-file-pdf text-danger"></i>
                                    <span>Surat Pengajuan.pdf</span>
                                </div>
                                <div class="document-item">
                                    <i class="fas fa-file-image text-primary"></i>
                                    <span>KTP.jpg</span>
                                </div>
                                <div class="document-item">
                                    <i class="fas fa-file-image text-primary"></i>
                                    <span>Screenshot_Sosmed.jpg</span>
                                </div>
                            </div>
                        </div>

                        <div class="status-timeline mt-5">
                            <h4 class="mb-4">Status Timeline</h4>
                            <div class="timeline">
                                <div class="timeline-item active">
                                    <div class="timeline-dot"></div>
                                    <div class="timeline-content">
                                        <h5>Pengajuan Diterima</h5>
                                        <p class="text-muted">{{ now()->format('d M Y H:i') }}</p>
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <div class="timeline-content">
                                        <h5>Menunggu Review Admin</h5>
                                        <p class="text-muted">Dalam Proses</p>
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <div class="timeline-content">
                                        <h5>Keputusan Final</h5>
                                        <p class="text-muted">-</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.booking-detail-header {
    background: linear-gradient(135deg, #0041C2, #0052cc);
    color: white;
    padding: 2rem 0;
    margin-top: 4rem;
}

.info-item label {
    font-weight: 500;
    color: #666;
    margin-bottom: 0.5rem;
    display: block;
}

.info-item p {
    font-size: 1.1rem;
    margin: 0;
}

.document-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.document-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 8px;
}

.timeline {
    position: relative;
    padding-left: 2rem;
}

.timeline-item {
    position: relative;
    padding-bottom: 2rem;
}

.timeline-item::before {
    content: '';
    position: absolute;
    left: -1.5rem;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e0e0e0;
}

.timeline-dot {
    position: absolute;
    left: -1.85rem;
    width: 1rem;
    height: 1rem;
    border-radius: 50%;
    background: #e0e0e0;
}

.timeline-item.active .timeline-dot {
    background: #0041C2;
}

.timeline-content {
    padding-left: 1rem;
}

.timeline-content h5 {
    margin: 0;
    font-size: 1rem;
    font-weight: 500;
}

.timeline-content p {
    margin: 0.5rem 0 0;
    font-size: 0.9rem;
}
</style>
@endsection
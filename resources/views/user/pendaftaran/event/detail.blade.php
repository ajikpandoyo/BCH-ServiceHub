@extends('layouts.app')

@section('content')
<div class="registration-detail-header">
    <div class="container">
        <div class="text-center py-5">
            <h1 class="fw-bold">Detail Pendaftaran Event</h1>
            <p class="text-muted">Status pendaftaran event Anda</p>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-body p-5">
                    <div class="status-badge mb-4 text-center">
                        <span class="badge bg-warning px-4 py-2">Menunggu Konfirmasi</span>
                    </div>

                    <div class="registration-info">
                        <h3 class="mb-4">Informasi Pendaftaran</h3>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label>Nama Event</label>
                                    <p>Workshop UI/UX Design</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label>Tanggal Event</label>
                                    <p>20 Maret 2024</p>
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
                                    <label>No. Pendaftaran</label>
                                    <p>#REG-2024001</p>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="personal-info">
                            <h4 class="mb-3">Data Peserta</h4>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <label>Nama Lengkap</label>
                                        <p>John Doe</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <label>No. WhatsApp</label>
                                        <p>08123456789</p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="info-item">
                                        <label>Alamat</label>
                                        <p>Jl. Example No. 123, Bandung</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="status-timeline mt-5">
                            <h4 class="mb-4">Status Timeline</h4>
                            <div class="timeline">
                                <div class="timeline-item active">
                                    <div class="timeline-dot"></div>
                                    <div class="timeline-content">
                                        <h5>Pendaftaran Diterima</h5>
                                        <p class="text-muted">{{ now()->format('d M Y H:i') }}</p>
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <div class="timeline-content">
                                        <h5>Verifikasi Admin</h5>
                                        <p class="text-muted">Dalam Proses</p>
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <div class="timeline-content">
                                        <h5>Konfirmasi Final</h5>
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
.registration-detail-header {
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
</style>
@endsection
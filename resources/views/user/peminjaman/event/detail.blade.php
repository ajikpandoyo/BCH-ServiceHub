@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 100px;">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white py-3">
            <h4 class="mb-0"><i class="fas fa-calendar-check me-2"></i>Detail Pengajuan Peminjaman Event</h4>
        </div>
        <div class="card-body p-4">
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="info-section">
                        <h5 class="section-title"><i class="fas fa-user me-2"></i>Informasi Pemohon</h5>
                        <div class="info-content">
                            <p><strong>Nama:</strong> <span class="text-dark">{{ $peminjaman->nama_lengkap }}</span></p>
                            <p><strong>Alamat:</strong> <span class="text-dark">{{ $peminjaman->alamat }}</span></p>
                            <p><strong>WhatsApp:</strong> <span class="text-dark">{{ $peminjaman->whatsapp }}</span></p>
                            <p><strong>Instagram:</strong> <span class="text-dark">{{ $peminjaman->instagram }}</span></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-section">
                        <h5 class="section-title"><i class="fas fa-calendar-alt me-2"></i>Informasi Event</h5>
                        <div class="info-content">
                            <p><strong>Nama Event:</strong> <span class="text-dark">{{ $peminjaman->nama_event }}</span></p>
                            <p><strong>Tanggal:</strong> <span class="text-dark">{{ $peminjaman->tanggal }}</span></p>
                            <p><strong>Waktu:</strong> <span class="text-dark">{{ $peminjaman->waktu }}</span></p>
                            <p><strong>Lokasi:</strong> <span class="text-dark">{{ $peminjaman->lokasi_ruangan }}</span></p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mb-4">
                <div class="col-12">
                    <div class="info-section">
                        <h5 class="section-title"><i class="fas fa-info-circle me-2"></i>Detail Pendaftaran</h5>
                        <div class="info-content">
                            <p><strong>Alasan:</strong> <span class="text-dark">{{ $peminjaman->alasan }}</span></p>
                            <p><strong>Kategori:</strong> <span class="text-dark">{{ $peminjaman->kategori }}</span></p>
                            <p><strong>Sumber Informasi:</strong> <span class="text-dark">{{ $peminjaman->sumber_informasi }}</span></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <div class="info-section">
                        <h5 class="section-title"><i class="fas fa-clipboard-list me-2"></i>Detail Acara</h5>
                        <div class="info-content">
                            <p><strong>Tema:</strong> <span class="text-dark">{{ $peminjaman->tema_acara }}</span></p>
                            <p><strong>Waktu Loading:</strong> <span class="text-dark">{{ $peminjaman->waktu_loading }}</span></p>
                            <p><strong>Status:</strong> <span class="badge bg-warning px-3 py-2">{{ ucfirst($peminjaman->status) }}</span></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('riwayat.index') }}" class="btn btn-primary btn-lg px-5">
                    <i class="fas fa-history me-2"></i>Lihat di Riwayat
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 15px;
    border: none;
}

.card-header {
    border-top-left-radius: 15px !important;
    border-top-right-radius: 15px !important;
}

.info-section {
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 10px;
    height: 100%;
}

.section-title {
    color: #0041C2;
    font-weight: 600;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #0041C2;
}

.info-content p {
    margin-bottom: 12px;
    color: #666;
}

.info-content p strong {
    min-width: 150px;
    display: inline-block;
    color: #333;
}

.badge {
    font-size: 0.9rem;
    border-radius: 8px;
}

.btn-primary {
    background-color: #0041C2;
    border: none;
    padding: 12px 30px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background-color: #003399;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,65,194,0.3);
}

@media (max-width: 768px) {
    .info-section {
        margin-bottom: 20px;
    }
    
    .info-content p strong {
        min-width: 120px;
    }
}
</style>
@endsection
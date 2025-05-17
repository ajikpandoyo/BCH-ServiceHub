@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 80px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Detail Peminjaman Ruangan</h4>
                    <a href="{{ route('peminjaman.ruangan.index') }}" class="btn btn-light">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <img src="{{ asset('storage/' . $peminjaman->ruangan->gambar) }}" 
                                 class="img-fluid rounded" 
                                 alt="{{ $peminjaman->ruangan->nama_ruangan }}">
                        </div>
                        <div class="col-md-8">
                            <h5>Detail Ruangan:</h5>
                            <p><i class="fas fa-building me-2"></i>{{ $peminjaman->ruangan->nama_ruangan }}</p>
                            <p><i class="fas fa-users me-2"></i>Kapasitas: {{ $peminjaman->ruangan->kapasitas }} orang</p>
                            <p><i class="fas fa-map-marker-alt me-2"></i>Lokasi: {{ $peminjaman->ruangan->lokasi }}</p>
                            <p><i class="fas fa-clock me-2"></i>Jam Operasional: {{ $peminjaman->ruangan->jam_operasional }}</p>
                        </div>
                    </div>

                    <div class="detail-container">
                        <h5 class="mb-3">Informasi Peminjaman:</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Nama Peminjam:</strong><br>{{ $peminjaman->nama_peminjam }}</p>
                                <p><strong>Email:</strong><br>{{ $peminjaman->email_peminjam }}</p>
                                <p><strong>Telepon:</strong><br>{{ $peminjaman->telepon_peminjam }}</p>
                                <p><strong>Instansi:</strong><br>{{ $peminjaman->instansi_peminjam }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Tanggal Peminjaman:</strong><br>{{ \Carbon\Carbon::parse($peminjaman->tanggal_peminjaman)->format('d/m/Y') }}</p>
                                <p><strong>Waktu:</strong><br>{{ \Carbon\Carbon::parse($peminjaman->waktu_mulai)->format('H:i') }} - 
                                   {{ \Carbon\Carbon::parse($peminjaman->waktu_selesai)->format('H:i') }}</p>
                                <p><strong>Jumlah Peserta:</strong><br>{{ $peminjaman->jumlah_peserta }} orang</p>
                                <p><strong>Status:</strong><br>
                                    @if($peminjaman->status == 'pending')
                                        <span class="badge bg-warning">Menunggu</span>
                                    @elseif($peminjaman->status == 'approved')
                                        <span class="badge bg-success">Disetujui</span>
                                    @else
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="mt-4">
                            <p><strong>Nama Kegiatan:</strong><br>{{ $peminjaman->kegiatan }}</p>
                            <p><strong>Deskripsi Kegiatan:</strong><br>{{ $peminjaman->deskripsi_kegiatan }}</p>
                        </div>

                        <div class="mt-4">
                            <p><strong>Surat Peminjaman:</strong></p>
                            <a href="{{ asset('storage/' . $peminjaman->surat_peminjaman) }}" 
                               class="btn btn-info" target="_blank">
                                <i class="fas fa-file-pdf"></i> Lihat Surat
                            </a>
                        </div>

                        @if($peminjaman->catatan)
                            <div class="mt-4">
                                <p><strong>Catatan:</strong><br>{{ $peminjaman->catatan }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.detail-container {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
}

.detail-container p {
    margin-bottom: 15px;
}

.detail-container strong {
    color: #495057;
}

.badge {
    font-size: 0.9em;
    padding: 8px 12px;
}
</style>
@endsection 
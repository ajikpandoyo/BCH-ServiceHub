@extends('layouts.app')

@section('content')
<div class="container riwayat-index">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Riwayat Pengajuan</li>
        </ol>
    </nav>

    {{-- Notifikasi --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('warning'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i> {{ session('warning') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- Tabel Riwayat --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table custom-table align-middle">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 5%">NO</th>
                            <th style="width: 35%">NAMA</th>
                            <th style="width: 15%">JENIS</th>
                            <th style="width: 15%">TANGGAL</th>
                            <th style="width: 15%">STATUS</th>
                            <th style="width: 15%">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayat as $key => $item)
                        <tr>
                            <td class="text-center">{{ $key + 1 }}</td>
                            <td>
                                <span class="d-flex align-items-center">
                                    @if($item->jenis == 'kunjungan')
                                        <i class="fas fa-building text-warning me-2"></i>
                                    @elseif($item->jenis == 'peminjaman')
                                        <i class="fas fa-door-open text-success me-2"></i>
                                    @elseif($item->jenis == 'mediapartner')
                                        <i class="fas fa-handshake text-info me-2"></i>
                                    @elseif($item->jenis == 'event')
                                        <i class="fas fa-calendar-alt text-primary me-2"></i>
                                    @endif
                                    {{ $item->user->name }}
                                </span>
                            </td>
                            <td>{{ ucfirst($item->jenis) }}</td>
                            <td>{{ $item->created_at->format('d/m/Y') }}</td>
                            <td>
                                <span class="status {{ strtolower($item->status) }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('riwayat.show', $item->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye me-1"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="fas fa-folder-open fa-3x mb-3"></i>
                                <p class="mb-0">Belum ada riwayat pengajuan.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- STYLE --}}
<style>
/* ===== Struktur Layout ===== */
.container.riwayat-index {
    margin-top: 100px !important;
    margin-bottom: 80px;
    max-width: 1200px;
}

/* ===== Breadcrumb ===== */
.breadcrumb {
    margin-bottom: 2rem;
    background-color: transparent;
    padding: 0;
}
.breadcrumb a {
    color: #0041C2;
    text-decoration: none;
    font-weight: 500;
}
.breadcrumb a:hover {
    text-decoration: underline;
}

/* ===== Header ===== */
.riwayat-header h1 {
    font-size: 32px;
    color: #1a1a1a;
    margin-bottom: 16px;
}
.riwayat-header p {
    color: #666;
    line-height: 1.6;
}

/* ===== Card & Table ===== */
.card {
    border-radius: 12px;
}
.table thead {
    background-color: #f8f9fa;
}
.table th {
    font-size: 13px;
    color: #666;
    font-weight: 600;
    text-transform: uppercase;
    border-bottom: 2px solid #eee;
}
.table td {
    font-size: 14px;
    color: #333;
    border-bottom: 1px solid #eee;
}
.table tr:hover {
    background-color: #f8fafc;
}

/* ===== Status Badge ===== */
.status {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 500;
}
.status.disetujui,
.status.approved {
    color: #0041C2;
    background: #e6f0ff;
}
.status.pending {
    color: #b45309;
    background: #fef3c7;
}
.status.ditolak,
.status.rejected {
    color: #dc2626;
    background: #fee2e2;
}

/* ===== Button ===== */
.btn-primary {
    background-color: #0041C2;
    border: none;
    border-radius: 6px;
    font-weight: 500;
    transition: all 0.2s ease;
}
.btn-primary:hover {
    background-color: #003399;
}
.btn-sm {
    padding: 6px 12px;
    font-size: 13px;
}

/* ===== Alert ===== */
.alert {
    border-radius: 8px;
    padding: 14px 20px;
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 24px;
}
.alert-success {
    background-color: #dcfce7;
    color: #166534;
    border: 1px solid #bbf7d0;
}
.alert-warning {
    background-color: #fef3c7;
    color: #92400e;
    border: 1px solid #fde68a;
}
.btn-close {
    background: none;
    border: none;
    font-size: 1.2rem;
    opacity: 0.6;
}
.btn-close:hover {
    opacity: 1;
}
</style>
@endsection

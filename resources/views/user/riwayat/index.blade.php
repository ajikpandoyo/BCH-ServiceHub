@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Notifikasi --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('warning'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        {{ session('warning') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- Konten riwayat lainnya --}}
    <div x-data="{ searchQuery: '' }">
        @if(session('success'))
        <div class="alert alert-success" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
        </div>
        @endif

        <div class="content-wrapper">
            <!-- Header Riwayat -->
            <div class="section-header">
                <h1>Riwayat Pengajuan</h1>
            </div>

            <div class="table-container">
                <table class="custom-table">
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
                                    <a href="{{ route('riwayat.show', $item->id) }}" 
                                       class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-3">
                                    <i class="fas fa-folder-open text-muted mb-3" style="font-size: 48px;"></i>
                                    <p class="text-muted mb-0">Belum ada riwayat pengajuan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
    .content-wrapper {
        padding: 24px;
    }

    .section-header {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        margin-bottom: 24px;
    }

    .section-header h1 {
        font-size: 24px;
        color: #1E293B;
        margin: 0;
    }

    .table-container {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        margin-bottom: 24px;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
    }

    .custom-table th {
        color: #666;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        padding: 12px 20px;
        border-bottom: 1px solid #eee;
        background: #f8f9fa;
        text-align: left;
    }

    .custom-table td {
        padding: 16px 20px;
        border-bottom: 1px solid #eee;
        font-size: 14px;
        color: #333;
    }

    .custom-table tr:hover {
        background-color: #f8fafc;
    }

    .status {
        display: inline-flex;
        align-items: center;
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 13px;
        font-weight: 500;
    }

    .status.disetujui, .status.approved {
        color: #0041C2;
        background: #e6f0ff;
    }

    .status.pending {
        color: #b45309;
        background: #fef3c7;
    }

    .status.ditolak, .status.rejected {
        color: #dc2626;
        background: #fee2e2;
    }

    .btn {
        padding: 8px 15px;
        border-radius: 6px;
        font-weight: 500;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
    }

    .btn-sm {
        padding: 6px 12px;
        font-size: 13px;
    }

    .btn-info {
        background: #0041C2;
        color: white;
        border: none;
    }

    .btn-info:hover {
        background: #003399;
    }

    .alert {
        margin: 24px;
        padding: 16px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 12px;
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
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        font-size: 1.25rem;
        cursor: pointer;
        opacity: 0.5;
    }

    .btn-close:hover {
        opacity: 1;
    }
    </style>
    @endpush
    @endsection

@foreach($riwayat as $item)
    <tr>
        <td>{{ $item['id'] }}</td>
        <td>{{ $item['jenis'] }}</td>
        <td>{{ $item['status'] }}</td>
        <td>{{ $item['tanggal'] }}</td>
        <td>{{ $item['keterangan'] }}</td>
    </tr>
@endforeach


@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 100px;">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Riwayat Peminjaman Ruangan</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Ruangan</th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peminjaman as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->ruangan->nama_ruangan }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_peminjaman)->format('d/m/Y') }}</td>
                            <td>{{ $item->waktu_mulai }} - {{ $item->waktu_selesai }}</td>
                            <td>
                                <span class="badge bg-{{ $item->status == 'pending' ? 'warning' : ($item->status == 'approved' ? 'success' : 'danger') }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal{{ $item->id }}">
                                    <i class="fas fa-eye"></i> Detail
                                </button>
                            </td>
                        </tr>

                        <!-- Modal Detail -->
                        <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Detail Peminjaman</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Nama Pemohon:</strong> {{ $item->nama_pemohon }}</p>
                                        <p><strong>Nama Acara:</strong> {{ $item->nama_acara }}</p>
                                        <p><strong>Tujuan:</strong> {{ $item->tujuan }}</p>
                                        <p><strong>Surat Pengajuan:</strong> 
                                            <a href="{{ asset('storage/'.$item->surat_pengajuan) }}" target="_blank">Lihat File</a>
                                        </p>
                                        <p><strong>KTP:</strong> 
                                            <a href="{{ asset('storage/'.$item->ktp) }}" target="_blank">Lihat File</a>
                                        </p>
                                        @if($item->screening_file)
                                        <p><strong>File Screening:</strong> 
                                            <a href="{{ asset('storage/'.$item->screening_file) }}" target="_blank">Lihat File</a>
                                        </p>
                                        @endif
                                        @if($item->status == 'rejected')
                                        <p><strong>Alasan Penolakan:</strong> {{ $item->rejection_reason ?? '-' }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                <i class="fas fa-folder-open text-muted mb-3" style="font-size: 48px;"></i>
                                <p class="text-muted mb-0">Belum ada riwayat peminjaman ruangan.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
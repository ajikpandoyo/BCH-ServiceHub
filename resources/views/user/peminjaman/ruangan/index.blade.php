@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 80px;">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Daftar Peminjaman Ruangan</h4>
                    <a href="{{ route('peminjaman.ruangan.create') }}" class="btn btn-light">
                        <i class="fas fa-plus"></i> Ajukan Peminjaman
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($peminjamans->isEmpty())
                        <div class="text-center py-4">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada peminjaman ruangan</p>
                            <a href="{{ route('peminjaman.ruangan.create') }}" class="btn btn-primary">
                                Ajukan Peminjaman Baru
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Ruangan</th>
                                        <th>Tanggal</th>
                                        <th>Waktu</th>
                                        <th>Kegiatan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($peminjamans as $peminjaman)
                                        <tr>
                                            <td>{{ $peminjaman->ruangan->nama_ruangan }}</td>
                                            <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_peminjaman)->format('d/m/Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($peminjaman->waktu_mulai)->format('H:i') }} - 
                                                {{ \Carbon\Carbon::parse($peminjaman->waktu_selesai)->format('H:i') }}</td>
                                            <td>{{ $peminjaman->kegiatan }}</td>
                                            <td>
                                                @if($peminjaman->status == 'pending')
                                                    <span class="badge bg-warning">Menunggu</span>
                                                @elseif($peminjaman->status == 'approved')
                                                    <span class="badge bg-success">Disetujui</span>
                                                @else
                                                    <span class="badge bg-danger">Ditolak</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('peminjaman.ruangan.show', $peminjaman->id) }}" 
                                                   class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            {{ $peminjamans->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
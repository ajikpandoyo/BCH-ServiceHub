@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 100px;">
    <h2 class="mb-4">Daftar Ruangan</h2>
    
    <div class="row g-4">
        @foreach($ruangan as $room)
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-img-container">
                    @if($room->gambar)
                        <img src="{{ Storage::url('images/ruangan/'.$room->gambar) }}" 
                             alt="{{ $room->nama_ruangan }}"
                             class="card-img-top">
                    @else
                        <span class="text-muted">Tidak ada gambar</span>
                    @endif
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $room->nama_ruangan }}</h5>
                    <p class="card-text text-muted mb-2">
                        <i class="fas fa-map-marker-alt me-2"></i>{{ $room->lokasi }}
                    </p>
                    <p class="card-text text-muted mb-2">
                        <i class="fas fa-users me-2"></i>Kapasitas: {{ $room->kapasitas }} orang
                    </p>
                    <p class="card-text text-muted mb-2">
                        <i class="fas fa-clock me-2"></i>{{ $room->jam_operasional }}
                    </p>
                    <div class="mt-3">
                        <a href="{{ route('ruangan.show', $room->id) }}" class="btn btn-primary">
                            <i class="fas fa-info-circle me-2"></i>Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Add these styles -->
<style>
.card-img-container {
    height: 200px;
    overflow: hidden;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
    background-color: #f8f9fa;
}

.card-img-top {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
}

.card {
    transition: transform 0.2s;
    border: none;
    border-radius: 12px;
}

.card:hover {
    transform: translateY(-5px);
}

.card-img-top {
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
}

.btn-primary {
    background-color: #0041C2;
    border: none;
    padding: 8px 16px;
    border-radius: 6px;
}

.btn-primary:hover {
    background-color: #003399;
}

.card-title {
    color: #333;
    font-weight: 600;
}

.text-muted {
    font-size: 0.9rem;
}

.fas {
    color: #0041C2;
}
</style>
@endsection
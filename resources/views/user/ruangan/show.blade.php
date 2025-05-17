@extends('layouts.app')

@section('content')
<div class="container mt-5 pt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('ruangan.index') }}">Ruangan</a></li>
            <li class="breadcrumb-item active">{{ $ruangan->nama_ruangan }}</li>
        </ol>
    </nav>

    <div class="card shadow-sm">
        <div class="row g-0">
            <div class="col-md-6">
                <img src="{{ asset('storage/' . $ruangan->gambar) }}" class="img-fluid rounded-start" alt="{{ $ruangan->nama_ruangan }}" style="height: 100%; object-fit: cover;">
            </div>
            <div class="col-md-6">
                <div class="card-body p-4">
                    <h2 class="card-title mb-4">{{ $ruangan->nama_ruangan }}</h2>
                    
                    <div class="info-section mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-map-marker-alt fa-fw me-3"></i>
                            <span>{{ $ruangan->lokasi }}</span>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-users fa-fw me-3"></i>
                            <span>Kapasitas: {{ $ruangan->kapasitas }} orang</span>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-clock fa-fw me-3"></i>
                            <span>{{ $ruangan->jam_operasional }}</span>
                        </div>
                    </div>

                    <div class="fasilitas-section mb-4">
                        <h5 class="mb-3">Fasilitas:</h5>
                        <div class="fasilitas-list">
                            @foreach(explode(',', $ruangan->fasilitas) as $fasilitas)
                            <span class="badge bg-light text-dark mb-2 me-2">
                                <i class="fas fa-check-circle text-success me-1"></i>
                                {{ trim($fasilitas) }}
                            </span>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-4">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.breadcrumb {
    margin-bottom: 2rem;
}

.breadcrumb a {
    color: #0041C2;
    text-decoration: none;
}

.card {
    border: none;
    border-radius: 12px;
    overflow: hidden;
}

.info-section i {
    color: #0041C2;
    width: 20px;
}

.badge {
    padding: 8px 16px;
    font-weight: 500;
    border-radius: 20px;
}

.btn-primary {
    background-color: #0041C2;
    border: none;
    padding: 12px 24px;
    border-radius: 6px;
    font-weight: 500;
}

.btn-primary:hover {
    background-color: #003399;
}
</style>
@endsection
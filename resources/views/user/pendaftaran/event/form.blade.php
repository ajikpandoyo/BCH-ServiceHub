@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 100px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Form Pendaftaran Event - {{ $event->nama_event }}</h5>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            @if($event->poster)
                                <div class="event-poster-container">
                                    <img src="{{ $event->poster_url }}" 
                                         class="img-fluid rounded" 
                                         alt="{{ $event->nama_event }}"
                                         onerror="this.onerror=null; this.src='{{ asset('images/default-event.jpg') }}';">
                                </div>
                            @else
                                <div class="no-poster">
                                    <i class="fas fa-image"></i>
                                    <span>Tidak ada poster</span>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h6>Detail Event:</h6>
                            <p><i class="fas fa-calendar me-2"></i>{{ $event->tanggal_pelaksanaan }}</p>
                            <p><i class="fas fa-clock me-2"></i>{{ $event->waktu }}</p>
                            <p><i class="fas fa-map-marker-alt me-2"></i>{{ $event->lokasi_ruangan }}</p>
                            <p><i class="fas fa-user-tie me-2"></i>{{ $event->penyelenggara }}</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('pendaftaran.event.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="event_id" value="{{ $event->id }}">

                        <div class="mb-3">
                            <label class="form-label">Nama Peserta</label>
                            <input type="text" class="form-control" name="nama_peserta" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control" name="no_telepon" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Instansi</label>
                            <input type="text" class="form-control" name="instansi" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Bukti Pembayaran</label>
                            <input type="file" class="form-control" name="bukti_pembayaran" accept="image/*" required>
                            <small class="text-muted">Format: JPG, PNG (Max. 2MB)</small>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i>Kirim Pendaftaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border: none;
    border-radius: 12px;
}

.card-header {
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
}

.event-poster-container {
    height: 200px;
    overflow: hidden;
    border-radius: 8px;
    background-color: #f8f9fa;
}

.event-poster-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.no-poster {
    height: 200px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background-color: #f8f9fa;
    border-radius: 8px;
    color: #6b7280;
}

.no-poster i {
    font-size: 2rem;
    margin-bottom: 0.5rem;
}

.form-control {
    border-radius: 6px;
    border: 1px solid #d1d5db;
    padding: 8px 12px;
}

.form-control:focus {
    border-color: #0041C2;
    box-shadow: 0 0 0 0.2rem rgba(0, 65, 194, 0.25);
}

.btn-primary {
    background-color: #0041C2;
    border: none;
    padding: 10px;
    border-radius: 6px;
}

.btn-primary:hover {
    background-color: #003399;
}

.fas {
    color: #0041C2;
}
</style>
@endsection
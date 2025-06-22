@extends('layouts.app')

@section('content')
<div class="kunjungan-header">
    <div class="container">
        <div class="text-center py-5">
            <h1 class="fw-bold">Form Pendaftaran Event</h1>
            <p class="text-muted">Silakan lengkapi formulir berikut untuk mendaftar ke event <strong>{{ $event->nama_event }}</strong></p>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-body p-5">
                    <div class="row g-4 mb-4">
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
                            <h6 class="fw-bold mb-3">Detail Event:</h6>
                            <p><i class="fas fa-calendar me-2"></i>{{ $event->tanggal_pelaksanaan }}</p>
                            <p><i class="fas fa-clock me-2"></i>{{ $event->waktu }}</p>
                            <p><i class="fas fa-map-marker-alt me-2"></i>{{ $event->lokasi_ruangan }}</p>
                            <p><i class="fas fa-user-tie me-2"></i>{{ $event->penyelenggara }}</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('pendaftaran.event.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="event_id" value="{{ $event->id }}">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Nama Peserta</label>
                                    <input type="text" class="form-control" name="nama_peserta" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Nomor Telepon</label>
                                    <input type="text" class="form-control" name="no_telepon" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Instansi</label>
                                    <input type="text" class="form-control" name="instansi" required>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Bukti Pembayaran</label>
                                    <input type="file" class="form-control" name="bukti_pembayaran" accept="image/*" required>
                                    <small class="text-muted">Format: JPG, PNG (Max. 2MB)</small>
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-paper-plane me-2"></i>Kirim Pendaftaran
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.kunjungan-header {
    background: linear-gradient(135deg, #0041C2, #0052cc);
    color: white;
    padding: 2rem 0;
    margin-top: 4rem;
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

.form-label {
    font-weight: 500;
    color: #333;
    margin-bottom: 0.5rem;
}

.form-control {
    padding: 0.75rem 1rem;
    border-color: #e0e0e0;
    border-radius: 8px;
}

.form-control:focus {
    border-color: #0041C2;
    box-shadow: 0 0 0 0.2rem rgba(0,65,194,0.1);
}

.card {
    border-radius: 15px;
}

.btn-primary {
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    background: #0041C2;
    border-color: #0041C2;
}

.btn-primary:hover {
    background: #003399;
    border-color: #003399;
}
</style>
@endsection

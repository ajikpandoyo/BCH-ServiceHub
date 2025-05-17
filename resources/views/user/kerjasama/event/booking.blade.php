@extends('layouts.app')

@section('content')
<div class="booking-header">
    <div class="container">
        <div class="text-center py-5">
            <h1 class="fw-bold">Event Booking</h1>
            <p class="text-muted">Lengkapi data diri Anda untuk melanjutkan booking</p>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-body p-5">
                    <form action="{{ route('kerjasama.event.booking.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" name="nama" required>
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
                                    <label class="form-label">No. Telepon</label>
                                    <input type="tel" class="form-control" name="telepon" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Institusi</label>
                                    <input type="text" class="form-control" name="institusi" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Surat Pengajuan (PDF)</label>
                                    <input type="file" class="form-control" name="surat_pengajuan" accept=".pdf" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">KTP (JPG/PNG)</label>
                                    <input type="file" class="form-control" name="ktp" accept=".jpg,.jpeg,.png" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Screenshot Bukti Follow Social Media (Optional)</label>
                                    <input type="file" class="form-control" name="screenshot" accept=".jpg,.jpeg,.png">
                                </div>
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-check me-2"></i>Konfirmasi Booking
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
.booking-header {
    background: linear-gradient(135deg, #0041C2, #0052cc);
    color: white;
    padding: 2rem 0;
    margin-top: 4rem;
}

.form-label {
    font-weight: 500;
    color: #333;
}

.form-control {
    padding: 0.75rem 1rem;
    border-radius: 8px;
}
</style>
@endsection
@extends('layouts.app')

@section('content')
<div class="kunjungan-header">
    <div class="container">
        <div class="text-center py-5">
            <h1 class="fw-bold">Pengajuan Kunjungan Visit</h1>
            <p class="text-muted">Silakan lengkapi form pengajuan kunjungan di bawah ini</p>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-body p-5">
                    <form action="{{ route('kunjungan.visit.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Nama Pemohon</label>
                                    <input type="text" class="form-control" name="nama_pemohon" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Instansi</label>
                                    <input type="text" class="form-control" name="instansi" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Tanggal Kunjungan</label>
                                    <input type="date" class="form-control" name="tanggal_kunjungan" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Waktu Kunjungan</label>
                                    <input type="time" class="form-control" name="waktu_kunjungan" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Jumlah Peserta</label>
                                    <input type="number" class="form-control" name="jumlah_peserta" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">No. Telepon</label>
                                    <input type="tel" class="form-control" name="telepon" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Tujuan Kunjungan</label>
                                    <textarea class="form-control" name="tujuan" rows="4" required></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Upload Proposal (PDF)</label>
                                    <input type="file" class="form-control" name="proposal" accept=".pdf" required>
                                    <small class="text-muted">Maksimal 5MB</small>
                                </div>
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-paper-plane me-2"></i>Ajukan Kunjungan
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
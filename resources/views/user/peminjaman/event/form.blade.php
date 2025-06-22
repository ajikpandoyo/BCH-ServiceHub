@extends('layouts.app')

@section('content')
<div class="event-header">
    <div class="container">
        <div class="text-center py-5">
            <h1 class="fw-bold">Form Pendaftaran Event</h1>
            <p class="text-muted">Silakan lengkapi form pendaftaran untuk event <strong>{{ $event->nama_event }}</strong></p>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-body p-5">
                    <form method="POST" action="{{ route('peminjaman.event.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="event_id" value="{{ $event->id }}">

                        <div class="row g-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Nama Pemohon</label>
                                    <input type="text" class="form-control" name="nama_pemohon" required>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Instansi</label>
                                    <input type="text" class="form-control" name="instansi" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Sosial Media Instansi</label>
                                    <input type="text" class="form-control" name="sosmed_instansi" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Tema Acara</label>
                                    <input type="text" class="form-control" name="tema_acara" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Waktu Loading</label>
                                    <input type="datetime-local" class="form-control" name="waktu_loading" required>
                                </div>
                            </div>

                            <div class="col-12">
                                <h6 class="mb-3 mt-2">Berkas Persyaratan:</h6>
                                
                                <div class="form-group mb-3">
                                    <label class="form-label">Surat Pengajuan (PDF)</label>
                                    <input type="file" class="form-control" name="surat_pengajuan" accept=".pdf" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Upload KTP (JPG/PNG)</label>
                                    <input type="file" class="form-control" name="ktp" accept=".jpg,.jpeg,.png" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Upload Softfile Screening (Optional)</label>
                                    <input type="file" class="form-control" name="screening_file" accept=".pdf,.doc,.docx">
                                    <small class="text-muted">Format: PDF, DOC, atau DOCX</small>
                                </div>
                            </div>

                            <div class="col-12 mt-4 d-flex justify-content-between">
                                <a href="{{ route('kerjasama.event.show', $event->id) }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-arrow-right me-2"></i>Lanjut
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
.event-header {
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

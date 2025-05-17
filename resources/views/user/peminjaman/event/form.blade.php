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
                    <form method="POST" action="{{ route('peminjaman.event.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="event_id" value="{{ $event->id }}">
                        
                        <div class="mb-3">
                            <label class="form-label">Nama Pemohon</label>
                            <input type="text" class="form-control" name="nama_pemohon" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Instansi</label>
                            <input type="text" class="form-control" name="instansi" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Sosial Media Instansi</label>
                            <input type="text" class="form-control" name="sosmed_instansi" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tema Acara</label>
                            <input type="text" class="form-control" name="tema_acara" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Waktu Loading</label>
                            <input type="datetime-local" class="form-control" name="waktu_loading" required>
                        </div>

                        <div class="mb-4">
                            <h6 class="mb-3">Berkas Persyaratan:</h6>
                            
                            <div class="mb-3">
                                <label class="form-label">Surat Pengajuan (PDF)</label>
                                <input type="file" class="form-control" name="surat_pengajuan" accept=".pdf" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Upload KTP (JPG/PNG)</label>
                                <input type="file" class="form-control" name="ktp" accept=".jpg,.jpeg,.png" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Upload Softfile Screening (Optional)</label>
                                <input type="file" class="form-control" name="screening_file" accept=".pdf,.doc,.docx">
                                <small class="text-muted">Format: PDF, DOC, atau DOCX</small>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('kerjasama.event.show', $event->id) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-arrow-right me-2"></i>Lanjut
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.btn-primary {
    background-color: #0041C2;
    border: none;
    padding: 10px 24px;
}

.btn-primary:hover {
    background-color: #003399;
}

.card {
    border-radius: 12px;
}

.card-header {
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
}

.form-control {
    border-radius: 8px;
    padding: 10px 15px;
}

.form-control:focus {
    border-color: #0041C2;
    box-shadow: 0 0 0 0.2rem rgba(0,65,194,0.25);
}
</style>
@endsection
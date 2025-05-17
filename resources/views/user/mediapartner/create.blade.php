@extends('layouts.app')

@section('content')
<div class="mediapartner-header">
    <div class="container">
        <div class="text-center py-5">
            <h1 class="fw-bold">Pengajuan Media Partner</h1>
            <p class="text-muted">Silakan lengkapi form pengajuan media partner di bawah ini</p>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-body p-5">
                    <form action="{{ route('mediapartner.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-4">
                            <!-- Data Pemohon -->
                            <div class="col-12">
                                <h4 class="mb-3">Data Pemohon</h4>
                            </div>
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

                            <!-- Data Instansi -->
                            <div class="col-12">
                                <h4 class="mb-3 mt-4">Data Instansi</h4>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Nama Instansi</label>
                                    <input type="text" class="form-control" name="instansi" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Instagram</label>
                                    <div class="input-group">
                                        <span class="input-group-text">@</span>
                                        <input type="text" class="form-control" name="instagram" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Website</label>
                                    <input type="url" class="form-control" name="website">
                                </div>
                            </div>

                            <!-- Data Acara -->
                            <div class="col-12">
                                <h4 class="mb-3 mt-4">Data Acara</h4>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Tema Acara</label>
                                    <input type="text" class="form-control" name="tema_acara" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Kategori Subsektor</label>
                                    <select class="form-select" name="kategori" required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category }}">{{ $category }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Tanggal Acara</label>
                                    <input type="date" class="form-control" name="tanggal_acara" required>
                                </div>
                            </div>

                            <!-- Kontak PIC -->
                            <div class="col-12">
                                <h4 class="mb-3 mt-4">Kontak PIC</h4>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Nama PIC</label>
                                    <input type="text" class="form-control" name="pic_nama" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">No. WhatsApp PIC</label>
                                    <input type="tel" class="form-control" name="pic_whatsapp" required>
                                </div>
                            </div>

                            <!-- Berkas Persyaratan -->
                            <div class="col-12">
                                <h4 class="mb-3 mt-4">Berkas Persyaratan</h4>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Surat Pengajuan (PDF)</label>
                                    <input type="file" class="form-control" name="surat_pengajuan" accept=".pdf" required>
                                    <small class="text-muted">Format: PDF, Maksimal 5MB</small>
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-paper-plane me-2"></i>Ajukan Media Partner
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
.mediapartner-header {
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

.form-control, .form-select {
    padding: 0.75rem 1rem;
    border-color: #e0e0e0;
    border-radius: 8px;
}

.form-control:focus, .form-select:focus {
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

h4 {
    color: #0041C2;
    font-size: 1.2rem;
    font-weight: 600;
}
</style>
@endsection
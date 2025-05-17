@extends('layouts.admin')

@section('content')
<div class="contents">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <a href="{{ route('admin.verifikasi.peminjaman.index') }}" class="btn btn-light">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
    <form action="{{ route('admin.verifikasi.peminjaman.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="content-header">
            <div class="breadcrumb">
                <h4 class="mb-0">Tambah Peminjaman Ruangan</h4>
            </div>
            <div class="header-actions">
                <x-button.tertiary title="Cancel" onclick="history.back()"></x-button.secondary>
                <x-button.primary title="Save"></x-button.primary>
            </div>
        </div>
        <hr class="divider">

        <div class="form-container">
            <div class="section">
                <h2 class="section-title">Informasi Umum</h2>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="nama_peminjam">Nama Peminjamn</label>
                        <input type="text" id="nama_peminjam" name="nama_peminjam" class="form-control" placeholder="Masukkan nama event" required>
                    </div>
                    <div class="form-group">
                        <label for="telepon_peminjam">Telepon Peminjamm</label>
                        <input type="text" id="telepon_peminjam" name="telepon_peminjam" class="form-control" placeholder="Masukkan nama penyelenggara" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="instansi_peminjam">Instansi Peminjam</label>
                        <input type="text" id="instansi_peminjam" name="instansi_peminjam" class="form-control" placeholder="Masukkan nama penyelenggara" required>
                    </div>
                    <div class="form-group">
                        <label for="kegiatan">Kegiatan</label>
                        <input type="text" id="kegiatan" name="kegiatan" class="form-control" placeholder="Masukkan nama penyelenggara" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="deskripsi_kegiatan">Deskripsi Kegiatan</label>
                    <textarea id="deskripsi" name="deskripsi" class="form-control" rows="4" placeholder="Masukkan deskripsi event"></textarea>
                </div>

                <div class="form-group">
                    <label for="tanggal_peminjaman">Tanggal peminjaman</label>
                    <input type="text" id="tanggal_peminjaman" name="tanggal_peminjaman" class="form-control" placeholder="Masukkan lokasi ruangan" required>
                </div>

                <div class="form-group">
                    <label for="waktu_mulai">Waktu Mulai</label>
                    <input type="time" id="waktu_mulai" name="waktu_mulai" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="waktu_selesai">Waktu Selesai</label>
                    <input type="time" id="waktu_selesai" name="waktu_selesai" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="jumlah_peserta">Jumlah Peserta</label>
                    <textarea id="deskripsi" name="jumlah_peserta" class="form-control" rows="4" placeholder="Masukkan deskripsi event"></textarea>
                </div>
            </div>

            <hr class="divider">
            
            <div class="section">
                <h2 class="section-title">Surat Peminjaman</h2>
                <p class="section-desc">Pastikan file berbentuk .png atau .jpg</p>
                <div class="upload-area">
                    <input type="file" id="surat_peminjaman" name="surat_peminjaman" accept=".jpg,.png" class="file-input" hidden>
                    <div class="upload-content">
                        <div class="upload-icon">
                            <i class="fas fa-cloud-upload-alt"></i>
                        </div>
                        <p>Drag & drop files or <span class="browse-link">Browse</span></p>
                        <p class="upload-formats">Supported formats: png, jpg</p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
.contents {
    padding: 24px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.divider {
    border: none;
    border-top: 1px solid #e2e8f0;
    margin: 24px 0;
}

.content-header {
    margin-bottom: 24px;
}



.card-header a{
    color: #0041C2;
    text-decoration: none;
    gap:1rem;   
}

.page-title {
    font-size: 24px;
    font-weight: 600;
    color: #1e293b;
    margin: 0;
}

.form-container {
    max-width: 100%;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #1e293b;
    font-size: 14px;
}

.form-control {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 14px;
    color: #1e293b;
    transition: border-color 0.2s;
}

.form-control:focus {
    outline: none;
    border-color: #0041C2;
    box-shadow: 0 0 0 3px rgba(0, 65, 194, 0.1);
}

.form-actions {
    display: flex;
    gap: 12px;
    margin-top: 32px;
    padding-top: 20px;
    border-top: 1px solid #e2e8f0;
}

.btn {
    padding: 10px 20px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}

.btn-primary {
    background: #0041C2;
    color: white;
    border: none;
}

.btn-primary:hover {
    background: #003399;
}

.btn-outline-secondary {
    background: white;
    color: #64748b;
    border: 1px solid #e2e8f0;
}

.btn-outline-secondary:hover {
    background: #f8fafc;
}

/* Error states */
.form-control.is-invalid {
    border-color: #dc2626;
}

.invalid-feedback {
    color: #dc2626;
    font-size: 12px;
    margin-top: 4px;
}

.breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 20px;
}

.breadcrumb .separator {
    color: #94a3b8;
}

.breadcrumb .active {
    color: #0041C2;
}

.header-actions {
    display: flex;
    gap: 12px;
}

.content-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 32px;
}

.section {
    margin-bottom: 32px;
}

.section-title {
    font-size: 18px;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 16px;
}

.section-desc {
    font-size: 14px;
    color: #64748b;
    margin-bottom: 16px;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
    margin-bottom: 20px;
}

.upload-area {
    border: 2px dashed #e2e8f0;
    border-radius: 8px;
    padding: 32px;
    text-align: center;
    cursor: pointer;
    transition: border-color 0.2s;
}

.upload-area:hover {
    border-color: #0041C2;
}

.upload-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
}

.upload-icon {
    font-size: 32px;
    color: #0041C2;
    margin-bottom: 8px;
}

.browse-link {
    color: #0041C2;
    text-decoration: none;
    font-weight: 500;
}

.upload-formats {
    font-size: 12px;
    color: #64748b;
}

textarea.form-control {
    resize: vertical;
    min-height: 100px;
}
</style>

<script>
document.querySelector('.upload-area').addEventListener('click', () => {
    document.querySelector('#poster').click();
});

document.querySelector('#poster').addEventListener('change', (e) => {
    // Handle file selection
});
</script>
@endsection
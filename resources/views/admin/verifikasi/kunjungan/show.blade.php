@extends('layouts.admin')

@section('content')
<div class="detail-container">
    <div class="detail-header">
        <a href="{{ route('admin.verifikasi.kunjungan.index')}}" class="back-btn">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        @if($kunjungan->status === 'pending')
        <div class="action-buttons">
            <form action="{{ route('admin.verifikasi.kunjungan.approve', $kunjungan->id) }}" method="POST" class="inline">
                @csrf
                @method('POST')
                <x-button.primary  title="Setuju" icon="fas fa-check" type="submit"></x-button.primary>
            </form>
            <x-button.tertiary title="Tolak" icon="fas fa-times" onclick="openRejectModal()"></x-button.secondary>

        </div>
        @endif
    </div>

    <div class="detail-content">
        <div class="detail-section">
            <h3>Informasi Pemohon</h3>  
            <div class="info-grid">
                <div class="info-item">
                    <label>Nama Pemohon</label>
                    <p>{{ $kunjungan->nama_pemohon }}</p>
                </div>
                <div class="info-item">
                    <label>Alasan Penolakan</label>
                    <p>{{ $kunjungan->rejection_reason }}</p>
                </div>
                <div class="info-item">
                    <label>Status</label>
                    <span class="status {{ $kunjungan->status }}">
                        {{ ucfirst($kunjungan->status) }}
                    </span>
                </div>
            </div>

            <div class="detail-section">
                <h3>Detail Acara</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <label>Instansi</label>
                        <p>{{ $kunjungan->instansi }}</p>
                    </div>
                    <div class="info-item">
                        <label>Tujuan kunjungan</label>
                        <p>{{ $kunjungan->tujuan_kunjungan }}</p>
                    </div>
                    
                    <div class="info-item">
                        <label>Jumlah Peserta</label>
                        <p>{{ $kunjungan->jumlah_peserta }}</p>
                    </div>
                    <div class="info-item">
                        <label>Tanggal</label>
                        <p>{{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->format('d/m/Y') }}</p>
                    </div>
                    <div class="info-item">
                        <label>Waktu</label>
                        <p>{{ \Carbon\Carbon::parse($kunjungan->waktu_kunjungan)->format('H:i') }} - {{ \Carbon\Carbon::parse($kunjungan->waktu_selesai)->format('H:i') }}</p>
                    </div>
                </div>
            </div>

            <div class="detail-section">
                <h3>Dokumen</h3>
                <div class="info-grid">
                    @if($kunjungan->proposal_path)
                    <div class="form-group">
                        <label>Proposal</label>
                        <div class="file-container">
                            <div class="file-info">
                                <i class="far fa-file-pdf"></i>
                                <span>Proposal.pdf</span>
                            </div>
                            <a href="{{ asset('storage/' . $kunjungan->proposal_path) }}" class="download-btn" download>
                        <i class="fas fa-download"></i>
                    </a>
                        </div>
                    </div>
                    @endif
                    
                    @if($kunjungan->ktp)
                    <div class="form-group">
                        <label>KTP</label>
                        <div class="file-container">
                            <div class="file-info">
                                <i class="far fa-id-card"></i>
                                <span>KTP.pdf</span>
                            </div>
                            <a href="{{ asset('storage/' . $kunjungan->KTP) }}" class="download-btn" download>
                        <i class="fas fa-download"></i>
                    </a>
                        </div>
                    </div>
                    @endif

                    @if($kunjungan->screening_file)
                    <div class="form-group">
                        <label>File Screening</label>
                        <div class="file-container">
                            <div class="file-info">
                                <i class="far fa-file"></i>
                                <span>Screening.pdf</span>
                            </div>
                            <a href="{{ asset('storage/' . $kunjungan->screening_pengajuan) }}" class="download-btn" download>
                        <i class="fas fa-download"></i>
                    </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Add Reject Modal -->
    <div id="rejectModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Tolak Pengajuan</h2>
                <span class="close" onclick="closeRejectModal()">&times;</span>
            </div>
            <form action="{{ route('admin.verifikasi.kunjungan.reject', $kunjungan->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Alasan Penolakan:</label>
                        <select name="rejection_reason" class="form-control" required>
                            <option value="">Pilih alasan</option>
                            <option value="Dokumen tidak lengkap">Dokumen tidak lengkap</option>
                            <option value="Kegiatan tidak sesuai">Kegiatan tidak sesuai</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeRejectModal()">Batal</button>
                    <button type="submit" class="btn-reject">Tolak</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .detail-container {
        background: white;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        margin-top: 80px;
        padding: 40px;
    }

    .detail-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #666;
        text-decoration: none;
        font-size: 14px;
    }

    .back-btn:hover {
        color: #333;
    }

    .detail-section {
        margin-bottom: 32px;
    }

    .detail-section h3 {
        color: #333;
        font-size: 18px;
        margin-bottom: 16px;
        padding-bottom: 8px;
        border-bottom: 1px solid #eee;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 24px;
    }

    .info-item label {
        display: block;
        color: #666;
        font-size: 13px;
        margin-bottom: 4px;
    }

    .info-item p {
        color: #333;
        font-size: 15px;
    }

    .document-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 16px;
    }

    .doc-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        color: #333;
        text-decoration: none;
        transition: all 0.2s;
    }

    .doc-link:hover {
        border-color: #0041C2;
        color: #0041C2;
        background: #f8fafc;
    }

    .doc-link i {
        font-size: 24px;
    }

    .btn {
        padding: 8px 16px;
        border-radius: 6px;
        font-weight: 500;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-success {
        background: #059669;
        color: white;
    }

    .btn-danger {
        background: #dc2626;
        color: white;
    }

    .action-buttons {
        display: flex;
        gap: 12px;
    }

    .inline {
        display: inline;
    }

    /* Add Modal Styles */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 1000;
    }

    .modal-content {
        background: white;
        margin: 15% auto;
        padding: 20px;
        border-radius: 8px;
        width: 80%;
        max-width: 500px;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .modal-header h2 {
        font-size: 1.5rem;
        color: #333;
    }

    .close {
        cursor: pointer;
        font-size: 24px;
        color: #666;
    }

    .modal-body {
        margin-bottom: 20px;
    }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        padding-top: 16px;
        border-top: 1px solid #eee;
    }

    .btn-cancel {
        padding: 8px 16px;
        border-radius: 6px;
        border: 1px solid #ddd;
        background: white;
        color: #666;
        cursor: pointer;
    }

    .btn-reject {
        padding: 8px 16px;
        border-radius: 6px;
        border: none;
        background: #dc2626;
        color: white;
        cursor: pointer;
    }

    .form-control {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-top: 8px;
    }

    /* File styles */
    .file-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        margin-top: 8px;
    }

    .file-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .file-info i {
        font-size: 20px;
        color: #dc2626;
    }

    .download-btn {
        padding: 8px;
        border-radius: 6px;
        color: #0041C2;
        transition: all 0.2s;
    }

    .download-btn:hover {
        background: #e2e8f0;
    }

    .file-size {
        color: #64748b;
        font-size: 12px;
    }
</style>
@endpush

<script>
function openRejectModal() {
    document.getElementById('rejectModal').style.display = 'block';
}

function closeRejectModal() {
    document.getElementById('rejectModal').style.display = 'none';
}
</script>
@endsection
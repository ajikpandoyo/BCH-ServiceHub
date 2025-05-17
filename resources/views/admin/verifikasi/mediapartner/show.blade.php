@extends('layouts.admin')

@section('content')
<div class="content-wrapper">
    <div class="detail-container">
        <!-- Back Button and Title -->
        <div class="header-section">
            <a href="{{ route('admin.verifikasi.mediapartner.index') }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <h1>Detail Pengajuan Media Partner</h1>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <button class="btn-reject" onclick="openRejectModal()">Tolak</button>
            <button class="btn-approve">Setujui</button>
        </div>

        <!-- Reject Modal -->
        <!-- Add this near the top of your content section -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        <!-- Update the reject modal -->
        <div id="rejectModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Tolak Pengajuan Ini?</h2>
                    <span class="close" onclick="closeRejectModal()">&times;</span>
                </div>
                <div class="modal-body">
                    <p>Pilih alasan penolakan:</p>
                    <form id="rejectForm" action="{{ route('admin.verifikasi.mediapartner.reject', $mediapartner->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <select name="reason" class="form-control" required>
                                <option value="">Pilih alasan</option>
                                <option value="Kegiatan tidak sesuai dengan subsektor ekonomi kreatif">Kegiatan tidak sesuai dengan subsektor ekonomi kreatif</option>
                                <option value="Surat pengajuan tidak sesuai template">Surat pengajuan tidak sesuai template</option>
                                <option value="Data atau surat belum lengkap">Data atau surat belum lengkap</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn-cancel" onclick="closeRejectModal()">Batal</button>
                            <button type="submit" class="btn-reject">Tolak</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <style>
        /* Add these styles */
        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 0.375rem;
            position: relative;
        }

        .alert-success {
            background-color: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .alert-dismissible .close {
            position: absolute;
            top: 0;
            right: 0;
            padding: 1rem;
            background: transparent;
            border: none;
            cursor: pointer;
        }

        .form-control {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
            margin-top: 0.5rem;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 0.5rem;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #e2e8f0;
        }

        .btn-reject {
            background-color: #ef4444;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            border: none;
            cursor: pointer;
        }

        .btn-cancel {
            background-color: #e2e8f0;
            color: #475569;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            border: none;
            cursor: pointer;
        }
        </style>

        <script>
        function openRejectModal() {
            document.getElementById('rejectModal').style.display = 'block';
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').style.display = 'none';
        }
        </script>

        <!-- Form Content -->
        <div class="form-content">
            <div class="form-group">
                <label>Nama Pemohon</label>
                <input type="text" value="{{ $mediapartner->nama_pemohon }}" class="form-control" readonly>
            </div>

            <div class="form-group">
                <label>Instansi</label>
                <input type="text" value="{{ $mediapartner->nama_instansi }}" class="form-control" readonly>
            </div>

            <div class="form-group">
                <label>Tanggal Pengajuan</label>
                <input type="text" value="{{ \Carbon\Carbon::parse($mediapartner->tanggal_pengajuan)->format('d F Y') }}" class="form-control" readonly>
            </div>

            <div class="form-group">
                <label>Kontak PIC</label>
                <input type="text" value="{{ $mediapartner->pic_whatsapp }}" class="form-control" readonly>
            </div>

            <div class="form-group">
                <label>Surat Pengajuan</label>
                <div class="file-container">
                    <div class="file-info">
                        <i class="far fa-file-pdf"></i>
                        <span>Pengajuan.pdf</span>
                        <span class="file-size">200 KB</span>
                    </div>
                    <a href="{{ asset('storage/' . $mediapartner->surat_pengajuan) }}" class="download-btn" download>
                        <i class="fas fa-download"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.content-wrapper {
    padding: 24px;
    background-color: #f1f5f9;
    min-height: 100vh;
}

.detail-container {
    background: white;
    border-radius: 8px;
    padding: 24px;
    max-width: 800px;
    margin: 0 auto;
}

.header-section {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 24px;
}

.back-link {
    color: #2563eb;
    text-decoration: none;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.back-link:hover {
    text-decoration: underline;
}

h1 {
    font-size: 20px;
    color: #1e293b;
    margin: 0;
}

.action-buttons {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    margin-bottom: 24px;
}

.btn-reject, .btn-approve {
    padding: 8px 16px;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
}

.btn-reject {
    background: white;
    border: 1px solid #e2e8f0;
    color: #64748b;
}

.btn-approve {
    background: #2563eb;
    border: none;
    color: white;
}

.form-content {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.form-group label {
    font-size: 14px;
    color: #64748b;
}

.form-control {
    padding: 8px 12px;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    font-size: 14px;
    color: #1e293b;
    background: #f8fafc;
}

.file-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    background: #f8fafc;
}

.file-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.file-size {
    color: #64748b;
    font-size: 12px;
}

.download-btn {
    color: #2563eb;
    text-decoration: none;
}

.download-btn:hover {
    color: #1e40af;
}

.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
    z-index: 1000;
}

.modal-content {
    background-color: #fff;
    margin: 15% auto;
    padding: 24px;
    border-radius: 8px;
    width: 400px;
    position: relative;
}

.modal-header {
    margin-bottom: 16px;
}

.modal-header h2 {
    font-size: 18px;
    color: #1e293b;
    margin: 0;
}

.close {
    position: absolute;
    right: 24px;
    top: 24px;
    font-size: 20px;
    cursor: pointer;
    color: #64748b;
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    margin-top: 24px;
}

.btn-cancel {
    padding: 8px 16px;
    border: 1px solid #e2e8f0;
    background: white;
    color: #64748b;
    border-radius: 6px;
    cursor: pointer;
}

.btn-delete {
    padding: 8px 16px;
    background: #dc2626;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}
</style>
@endsection
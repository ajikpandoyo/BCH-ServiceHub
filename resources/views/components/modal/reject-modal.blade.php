@props([
    'url',
])

<!-- Add Reject Modal -->
<div id="rejectModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Tolak Pengajuan</h2>
            <span class="close" onclick="closeRejectModal()">&times;</span>
        </div>
        <form action="{{ $url ?? '' }}" method="POST">
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


<style>
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
</style>

<div class="status-info">
    <h4>Status Pengajuan</h4>
    <div class="status-details">
        <p>
            <strong>Status:</strong> 
            <span class="status-badge {{ $kunjungan->status }}">
                {{ ucfirst($kunjungan->status) }}
            </span>
        </p>
        
        @if($kunjungan->status_updated_at)
        <p>
            <strong>Diperbarui pada:</strong> 
            {{ \Carbon\Carbon::parse($kunjungan->status_updated_at)->format('d F Y H:i') }}
        </p>
        @endif

        @if($kunjungan->status === 'ditolak' && $kunjungan->rejection_reason)
        <div class="rejection-reason">
            <strong>Alasan Penolakan:</strong>
            <p class="reason-text">{{ $kunjungan->rejection_reason }}</p>
        </div>
        @endif
    </div>
</div>

<style>
.status-info {
    background: #f8fafc;
    padding: 20px;
    border-radius: 8px;
    margin-top: 20px;
}

.status-details {
    margin-top: 15px;
}

.rejection-reason {
    margin-top: 15px;
    padding: 15px;
    background: #fee2e2;
    border-radius: 6px;
}

.reason-text {
    margin-top: 8px;
    color: #991b1b;
}
</style>
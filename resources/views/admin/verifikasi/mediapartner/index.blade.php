@extends('layouts.admin')

@section('content')
<div x-data="{ searchQuery: '' }">
    <div class="content-wrapper">
        <!-- Header -->
        <div class="section-header">
            <h1>Verifikasi Pengajuan Media Partner</h1>
        </div>

        <!-- Search and Actions -->
        <div class="content-header">
            <div class="search-wrapper">
                <form method="GET" action="{{ route('admin.verifikasi.mediapartner.index') }}" class="search-box">
                    <input type="text" 
                           class="search-input" 
                           placeholder="Cari nama pemohon, ruangan, atau keperluan..." 
                           name="search" 
                           value="{{ request('search') }}"
                           onchange="this.form.submit()">
                    <i class="fas fa-search search-icon"></i>
                    
                    <!-- Preserve other query parameters if any -->
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                </form>
            </div>
            <div class="action-buttons">
                <x-button.secondary url="{{ route('admin.verifikasi.peminjaman.export', request()->query()) }}" title="Export" icon="fas fa-download"></x-button.secondary>
            </div>
        </div>

        <!-- Status Tabs -->
        <div class="status-tabs">
            <a href="{{ route('admin.verifikasi.mediapartner.index') }}" 
               class="status-tab {{ !request('status') ? 'active' : '' }}">
                Semua ({{ $countAll ?? $mediapartners->total() }})
            </a>
            <a href="{{ route('admin.verifikasi.mediapartner.index', ['status' => 'approved']) }}" 
               class="status-tab {{ request('status') === 'approved' ? 'active' : '' }}">
                Disetujui ({{ $countApproved ?? 0 }})
            </a>
            <a href="{{ route('admin.verifikasi.mediapartner.index', ['status' => 'pending']) }}" 
               class="status-tab {{ request('status') === 'pending' ? 'active' : '' }}">
                Menunggu ({{ $countPending ?? 0 }})
            </a>
            <a href="{{ route('admin.verifikasi.mediapartner.index', ['status' => 'rejected']) }}" 
               class="status-tab {{ request('status') === 'rejected' ? 'active' : '' }}">
                Ditolak ({{ $countRejected ?? 0 }})
            </a>
        </div>

        <!-- Table -->
        <div class="table-container">
            <table class="custom-table">
                <thead>
                    <tr>
                       
                        <th>NO</th>
                        <th>NAMA PEMOHON</th>
                        <th>INSTANSI</th>
                        <th>TANGGAL PENGAJUAN</th>
                        <th>KONTAK PIC</th>
                        <th>DOKUMEN</th>
                        <th>STATUS</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mediapartners as $i => $item)
                    <tr>
                       
                        <td>{{ $mediapartners->firstItem() + $i }}</td>
                        <td>{{ $item->nama_pemohon }}</td>
                        <td>{{ $item->nama_instansi }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d F Y') }}</td>
                        <td>{{ $item->pic_whatsapp }}</td>
                        <td>
                            @if($item->dokumen)
                                <a href="{{ asset('storage/' . $item->dokumen) }}" class="btn-pdf" target="_blank">
                                    [File]
                                </a>
                            @else
                                <span class="text-muted">[File]</span>
                            @endif
                        </td>
                        <td>
                            <span class="status-badge {{ 
                                $item->status === 'approved' ? 'status-success' : 
                                ($item->status === 'pending' ? 'status-warning' : 'status-danger') 
                            }}">
                                • {{ $item->status === 'approved' ? 'Disetujui' : 
                                   ($item->status === 'pending' ? 'Menunggu' : 'Ditolak') }}
                            </span>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn-action" onclick="toggleDropdown(this)">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a href="{{ route('admin.verifikasi.mediapartner.show', $item->id) }}" class="dropdown-item">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                    @if($item->status === 'pending')
                                    <form action="{{ route('admin.verifikasi.mediapartner.approve', $item->id) }}" method="POST">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-check"></i> Setujui
                                        </button>
                                    </form>
                                    <button type="button" class="dropdown-item text-danger" onclick="openRejectModal({{ $item->id }})">
                                        <i class="fas fa-times"></i> Tolak
                                    </button>
                                    @endif

                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <div class="empty-state">
                                <i class="fas fa-inbox text-gray-400"></i>
                                <p>Tidak ada data peminjaman ruangan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrapper">
            <div class="pagination-info">
                <span>Showing {{ $mediapartners->firstItem() }}-{{ $mediapartners->lastItem() }} of {{ $mediapartners->total() }}</span>
            </div>
            <!-- {{ $mediapartners->links() }} -->
            <div class="pagination">
                <!-- {{-- Tombol Prev --}} -->
                <button class="page-btn" {{ $mediapartners->onFirstPage() ? 'disabled' : '' }}
                    onclick="window.location='{{ $mediapartners->previousPageUrl() }}'">Prev</button>

                <!-- {{-- Tombol Halaman --}} -->
                @for ($i = 1; $i <= $mediapartners->lastPage(); $i++)
                    @if ($i == $mediapartners->currentPage())
                        <button class="page-btn active">{{ $i }}</button>
                    @elseif ($i == 1 || $i == $mediapartners->lastPage() || abs($i - $mediapartners->currentPage()) <= 1)
                        <button class="page-btn"
                            onclick="window.location='{{ $mediapartners->url($i) }}'">{{ $i }}</button>
                    @elseif ($i == 2 && $mediapartners->currentPage() > 4)
                        <span class="dots">...</span>
                    @elseif ($i == $mediapartners->lastPage() - 1 && $mediapartners->currentPage() < $mediapartners->lastPage() - 3)
                        <span class="dots">...</span>
                    @endif
                @endfor

                <!-- {{-- Tombol Next --}} -->
                <button class="page-btn" {{ $mediapartners->hasMorePages() ? '' : 'disabled' }}
                    onclick="window.location='{{ $mediapartners->nextPageUrl() }}'">Next</button>
            </div>
        </div>
    </div>
     <!-- Add Reject Modal -->
     <div id="rejectModal" class="modal">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h2>Tolak Pengajuan</h2>
                <span class="close" onclick="closeRejectModal()">&times;</span>
            </div>
            <form id="rejectForm" method="POST">
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
@if(session('approved'))
        <x-toast.approve title="Persetujuan Berhasil" condition="{{ session('approved') }}"></x-toast.approve>
    @endif
    @if(session('rejected'))
        <x-toast.reject title="Penolakan Berhasil" condition="{{ session('rejected') }}"></x-toast.reject>
    @endif

<style>
    .content-wrapper {
        padding: 24px;
        min-height: 100vh;
        background-color: #f1f5f9;
        margin: 0;
        border-radius: 0;
        flex: 1;
    }

    .section-header {
        margin-bottom: 24px;
    }

    .section-header h1 {
        font-size: 24px;
        font-weight: 600;
        color: #1e293b;
        margin: 0;
    }

    .content-header {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .search-wrapper {
        flex: 1;
        max-width: 480px;
    }

    .search-box {
        position: relative;
    }

    .search-input {
        width: 100%;
        padding: 12px 16px 12px 40px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 14px;
        background-color: white;
    }

    .search-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
    }

    .btn-export {
        padding: 12px 24px;
        background-color: #10b981;
        color: white;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
        border: none;
    }

    /* Status tabs style */
    .status-tabs {
        text-decoration: none;
        display: flex;
        gap: 30px;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 0;
        background: white;
        padding: 20px;
        border-radius: 8px 8px 0 0;
    }

    .status-tab {
        color: #64748b;
        text-decoration: none;
        padding: 12px 0;
        font-size: 14px;
        position: relative;
    }

    .status-tab.active {
        text-decoration: none;
        color: #0041C2;
        font-weight: 500;
    }

    .status-tab.active::after {
        text-decoration: none;
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        right: 0;
        height: 2px;
        background: #0041C2;
    }

    .table-container {
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        overflow: visible;
    }

    .custom-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .custom-table th {
        background-color: #f8fafc;
        padding: 16px;
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 1px solid #e2e8f0;
    }

    .custom-table td {
        padding: 16px;
        font-size: 14px;
        color: #334155;
        border-bottom: 1px solid #e2e8f0;
    }

    .custom-table tr:last-child td {
        border-bottom: none;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 12px;
        border-radius: 9999px;
        font-size: 13px;
        font-weight: 500;
    }

    .status-success {
        background-color: #dcfce7;
        color: #166534;
    }

    .status-warning {
        background-color: #fef9c3;
        color: #854d0e;
    }

    .status-danger {
        background-color: #fee2e2;
        color: #991b1b;
    }

    .btn-action {
        background: none;
        border: none;
        padding: 8px;
        cursor: pointer;
        color: #64748b;
    }

    .dropdown {
        position: relative;
    }

    .dropdown-menu {
    position: absolute;
    right: 0;
    background: white;
    border-radius: 8px;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
    min-width: 160px;
    z-index: 10;
    display: none;
    border: 1px solid #E2E8F0;
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        font-size: 14px;
        color: #475569;
        text-decoration: none;
        border: none;
        background: none;
        width: 100%;
        cursor: pointer;
    }

    .dropdown-item:hover {
        background: #F8FAFC;
    }

    .dropdown-item.text-danger {
        color: #DC2626;
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


    .empty-state {
        padding: 48px 0;
        text-align: center;
    }

    .empty-state i {
        font-size: 48px;
        color: #cbd5e1;
        margin-bottom: 16px;
    }

    .empty-state p {
        color: #64748b;
        font-size: 14px;
        margin: 0;
    }

    /* Pagination Style*/
    .pagination-wrapper {
        margin-top: 24px;
        background: white;
        padding: 16px;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .pagination-info {
        display: flex;
        align-items: center;
        gap: 16px;
        color: #64748b;
        font-size: 14px;
    }

    .form-select {
        padding: 6px 12px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        color: #64748b;
        font-size: 14px;
        background: white;
    }

    .page-numbers {
        color: #64748B;
    }
    
    .pagination {
        display: flex;
        gap: 8px;
        align-items: center;
        justify-content: center;
        padding: 20px 0;
        font-family: sans-serif;
    }

    .page-btn {
        border: none;
        padding: 8px 12px;
        border-radius: 6px;
        background-color: white;
        color: #333;
        cursor: pointer;
        transition: background-color 0.2s ease;
        box-shadow: 0 0 0 1px #ccc;
    }

    .page-btn:hover {
        background-color: #f0f0f0;
    }

    .page-btn.active {
        background-color: #1e88e5;
        color: white;
        font-weight: bold;
    }

    .page-btn:disabled {
        color: #aaa;
        background-color: #f9f9f9;
        cursor: not-allowed;
        box-shadow: none;
    }

    .dots {
        padding: 0 8px;
        color: #888;
    }

    .text-muted {
        color: #64748b;
        font-size: 13px;
    }

    input[type="checkbox"] {
        width: 16px;
        height: 16px;
        border-radius: 4px;
        border: 1px solid #cbd5e1;
        cursor: pointer;
    }
</style>

<script>
function toggleDropdown(button) {
    const dropdowns = document.querySelectorAll('.dropdown-menu');
    dropdowns.forEach(dropdown => {
        if (dropdown !== button.nextElementSibling) {
            dropdown.style.display = 'none';
        }
    });
    const dropdown = button.nextElementSibling;
    dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
}

document.addEventListener('click', function(event) {
    if (!event.target.closest('.btn-action')) {
        document.querySelectorAll('.dropdown-menu').forEach(dropdown => {
            dropdown.style.display = 'none';
        });
    }
});



// Approve and Reject functionality
document.querySelectorAll('.approve-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.dataset.id;
        if (confirm('Apakah Anda yakin ingin menyetujui peminjaman ini?')) {
            // Submit approval
            fetch(`/admin/verifikasi/mediapartner/${id}/approve`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(() => location.reload());
        }
    });
});

document.querySelectorAll('.reject-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.dataset.id;
        if (confirm('Apakah Anda yakin ingin menolak peminjaman ini?')) {
            // Submit rejection
            fetch(`/admin/verifikasi/mediapartner/${id}/reject`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(() => location.reload());
        }
    });
});

// Reject functionality
function openRejectModal(id) {
    const form = document.getElementById('rejectForm');
    form.action = `/admin/verifikasi/mediapartner/${id}/reject`; // Sesuaikan dengan route
    document.getElementById('rejectModal').style.display = 'block';
}

function closeRejectModal() {
    document.getElementById('rejectModal').style.display = 'none';
}

// Optional: tutup modal jika klik luar
window.addEventListener('click', function(e) {
    const modal = document.getElementById('rejectModal');
    if (e.target === modal) {
        closeRejectModal();
    }
});
</script>


@endsection

@extends('layouts.admin')

@section('content')
<div x-data="{ searchQuery: '' }">
    <div class="content-wrapper">
        <!-- Header -->
        <div class="section-header">
            <h1>Verifikasi Pengajuan Peminjaman Ruangan</h1>
        </div>

        <!-- Search and Actions -->
        <div class="content-header">
            <div class="search-wrapper">
                <form method="GET" action="{{ route('admin.verifikasi.peminjaman.index') }}" class="search-box">
                    <input type="text" 
                           class="search-input" 
                           placeholder="Cari nama pemohon atau acara..." 
                           name="search" 
                           value="{{ request('search') }}"
                           onkeydown="if(event.key === 'Enter') this.form.submit()">
                    <i class="fas fa-search search-icon"></i>
                    
                    <!-- Preserve other query parameters if any -->
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                </form>
            </div>
            <form method="GET" action="{{ route('admin.verifikasi.peminjaman.index') }}">
                <div class="dropdown-wrapper">
                    <div class="dropdown-label">
                        <span>Ruangan</span>
                        <!-- <i class="fas fa-chevron-down"></i> -->
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('admin.verifikasi.peminjaman.index') }}">Semua Ruangan</a></li>
                            @foreach ($ruanganList as $ruangan)
                                <li>
                                    <a href="{{ route('admin.verifikasi.peminjaman.index', ['filter_ruangan' => $ruangan->id]) }}">
                                        {{ $ruangan->nama_ruangan }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <select name="filter_ruangan" onchange="this.form.submit()" class="dropdown-selected">
                        <option value=""> Semua Ruangan</option>
                        @foreach ($ruanganList as $ruangan)
                            <option value="{{ $ruangan->id }}" {{ request('filter_ruangan') == $ruangan->id ? 'selected' : '' }}>
                                {{ $ruangan->nama_ruangan }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
            <div class="action-buttons">
                <!-- <form action="{{ route('admin.verifikasi.peminjaman.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" required>
                    <button type="submit">Import</button>
                </form> -->
                <x-button.secondary url="{{ route('admin.verifikasi.peminjaman.import') }}" title="Import Data" icon="fas fa-cloud-arrow-up"></x-button.secondary>
                <x-button.secondary url="{{ route('admin.verifikasi.peminjaman.export', request()->query()) }}" title="Export" icon="fas fa-download"></x-button.secondary>
                <x-button.primary url="{{ route('admin.verifikasi.peminjaman.create') }}" title="Tambah Peminjaman" icon="fas fa-plus"></x-button.primary>
            </div>
        </div>

        <!-- Status Tabs -->
        <div class="status-tabs">
            <a href="{{ route('admin.verifikasi.peminjaman.index') }}" 
               class="status-tab {{ !request('status') ? 'active' : '' }}">
                Semua ({{ $countAll ?? $peminjaman->total() }})
            </a>
            <a href="{{ route('admin.verifikasi.peminjaman.index', ['status' => 'approved']) }}" 
               class="status-tab {{ request('status') === 'approved' ? 'active' : '' }}">
                Disetujui ({{ $countApproved ?? 0 }})
            </a>
            <a href="{{ route('admin.verifikasi.peminjaman.index', ['status' => 'pending']) }}" 
               class="status-tab {{ request('status') === 'pending' ? 'active' : '' }}">
                Menunggu ({{ $countPending ?? 0 }})
            </a>
            <a href="{{ route('admin.verifikasi.peminjaman.index', ['status' => 'rejected']) }}" 
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
                        <th>RUANGAN</th>
                        <th>TANGGAL PEMINJAMAN</th>
                        <th>KEPERLUAN ACARA</th>
                        <th>STATUS</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjaman as $i => $item)
                    <tr>

                        <td>{{ $peminjaman->firstItem() + $i }}</td>
                        <td>
                            <div class="fw-bold">{{ $item->nama_peminjam }}</div>
                            <small class="text-muted">{{ $item->email_peminjam }}</small>
                        </td>
                        <td>{{ $item->ruangan->nama_ruangan ?? '-' }}</td>
                        <td>
                            <div>{{ \Carbon\Carbon::parse($item->tanggal_peminjaman)->format('d F Y') }}</div>
                            
                        </td>
                        <td>{{ $item->kegiatan }}</td>
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
                                    <a href="{{ route('admin.verifikasi.peminjaman.show', $item->id) }}" class="dropdown-item">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                    @if($item->status === 'pending')
                                    <form action="{{ route('admin.verifikasi.peminjaman.approve', $item->id) }}" method="POST">
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
                <span>Showing {{ $peminjaman->firstItem() }}-{{ $peminjaman->lastItem() }} of {{ $peminjaman->total() }}</span>
            </div>
            <!-- {{ $peminjaman->links() }} -->
            <div class="pagination">
                <!-- {{-- Tombol Prev --}} -->
                <button class="page-btn" {{ $peminjaman->onFirstPage() ? 'disabled' : '' }}
                    onclick="window.location='{{ $peminjaman->previousPageUrl() }}'">Prev</button>

                <!-- {{-- Tombol Halaman --}} -->
                @for ($i = 1; $i <= $peminjaman->lastPage(); $i++)
                    @if ($i == $peminjaman->currentPage())
                        <button class="page-btn active">{{ $i }}</button>
                    @elseif ($i == 1 || $i == $peminjaman->lastPage() || abs($i - $peminjaman->currentPage()) <= 1)
                        <button class="page-btn"
                            onclick="window.location='{{ $peminjaman->url($i) }}'">{{ $i }}</button>
                    @elseif ($i == 2 && $peminjaman->currentPage() > 4)
                        <span class="dots">...</span>
                    @elseif ($i == $peminjaman->lastPage() - 1 && $peminjaman->currentPage() < $peminjaman->lastPage() - 3)
                        <span class="dots">...</span>
                    @endif
                @endfor

                <!-- {{-- Tombol Next --}} -->
                <button class="page-btn" {{ $peminjaman->hasMorePages() ? '' : 'disabled' }}
                    onclick="window.location='{{ $peminjaman->nextPageUrl() }}'">Next</button>
            </div>
        </div>
         <!-- Modal Tolak Pengajuan -->
        <div id="rejectModal" class="modal">
            <div class="modal-content">
                <span class="modal-close" onclick="closeRejectModal()">&times;</span>

                <div class="modal-icon">
                    <div class="icon-circle">
                        <span class="icon-x">✕</span>
                    </div>
                </div>

                <h3 class="modal-title">Tolak Pengajuan Ini?</h3>
                <p class="modal-desc">
                    Apakah Anda yakin ingin menolak pengajuan ini? <br>
                    Tindakan ini tidak dapat dibatalkan.
                </p>

                <form id="rejectForm" method="POST">
                    @csrf
                    <label for="rejection_reason" class="label">Alasan Penolakan</label>
                    <div class="modal-body">
                        <div class="form-group">
                            <select name="rejection_reason" class="form-control" required>
                                <option value="">Pilih alasan</option>
                                <option value="Dokumen tidak lengkap">Dokumen tidak lengkap</option>
                                <option value="Kegiatan tidak sesuai">Kegiatan tidak sesuai</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn-outline" onclick="closeRejectModal()">Tidak</button>
                        <button type="submit" class="btn-danger">Yakin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @if(session('approved'))
        <x-toast.approve title="Persetujuan Berhasil" condition="{{ session('approved') }}"></x-toast.approve>
    @endif
    @if(session('import'))
        <x-toast.approve title="Data Berhasil Diimport" condition="{{ session('import') }}"></x-toast.approve>
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
        max-width: 16rem;
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

    .dropdown-wrapper {
        display: flex;
        border: 1px solid #D0D5DD;
        border-radius: 8px;
        overflow: hidden;
        font-size: 14px;
        width: fit-content;
        background: #fff;
        color: #1e293b;
    }

    .dropdown-label {
        position: relative;
        padding: 8px 16px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        background: white;
        border-right: 1px solid #D0D5DD;
    }

    .dropdown-label:hover .dropdown-menu {
        display: block;
    }

    .dropdown-menu {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        z-index: 10;
        background: white;
        border: 1px solid #D0D5DD;
        width: 100%;
        border-radius: 4px;
    }

    .dropdown-menu li a {
        display: block;
        padding: 8px 12px;
        color: #1e293b;
        text-decoration: none;
    }

    .dropdown-menu li a:hover {
        background-color: #f1f5f9;
    }

    .action-buttons{
        display: flex;
        gap: 1.5rem;
    }
    
    .dropdown-selected {
        /* appearance: none; /* Hilangkan default arrow di beberapa browser */
        border: none;
        background: transparent;
        padding: 8px 12px;
        font-size: 14px;
        color: #64748b;
        width: auto;
        cursor: pointer;
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
        z-index: 100;
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
        inset: 0;
        background: rgba(0,0,0,0.5);
        z-index: 1000;
    }

    .modal-content {
        background: #fff;
        margin: 5% auto;
        padding: 32px;
        border-radius: 12px;
        width: 90%;
        max-width: 400px;
        position: relative;
        text-align: center;
    }

    .modal-close {
        position: absolute;
        top: 16px;
        right: 16px;
        font-size: 24px;
        color: #666;
        cursor: pointer;
    }

    .modal-icon {
        display: flex;
        justify-content: center;
        margin-bottom: 16px;
    }

    .icon-circle {
        background: #fee2e2;
        border-radius: 9999px;
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .icon-x {
        color: #dc2626;
        font-size: 20px;
        font-weight: bold;
    }

    .modal-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 8px;
        color: #1f2937;
    }

    .modal-desc {
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 24px;
    }

    .label {
        display: block;
        font-size: 14px;
        color: #374151;
        text-align: left;
        margin-bottom: 6px;
    }

    .form-control {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
        margin-bottom: 24px;
    }

    .modal-footer {
        display: flex;
        justify-content: center;
        gap: 12px;
    }

    .btn-outline {
        background: white;
        border: 1px solid #dc2626;
        color: #dc2626;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-danger {
        background: #dc2626;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
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
            fetch(`/admin/verifikasi/peminjaman/${id}/approve`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(() => location.reload());
        }
    });
});


// Auto fade out after 5 seconds
setTimeout(() => {
    const popup = document.getElementById('successPopup');
    if (popup) {
      popup.style.opacity = '0';
      setTimeout(() => {
        popup.style.display = 'none';
      }, 500); // wait for fade transition
    }
  }, 5000);


// Reject functionality
function openRejectModal(id) {
    const form = document.getElementById('rejectForm');
    form.action = `/admin/verifikasi/peminjaman/${id}/reject`; // Sesuaikan dengan route
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

<!DOCTYPE html>
<meta charset="UTF-8">
<meta name="Kelola ruangan" content="Kelola data ruangan untuk keperluan administrasi dan manajemen fasilitas.">
@extends('layouts.admin')

@section('content')
<!-- Add this at the top of the content section -->
@if(session('success'))
<div id="successNotification" class="success-notification">
    <div class="success-notification-content">
        <div class="success-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <span>{{ session('success') }}</span>
        <button onclick="closeSuccessNotification()" class="close-success">
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>
@endif

<!-- Delete Confirmation Modal -->
<div id="deleteConfirmModal" class="delete-modal" style="display: none;">
    <div class="delete-modal-overlay"></div>
    <div class="delete-modal-content">
        <div class="delete-icon">
            <i class="fas fa-trash"></i>
        </div>
        <h3>Yakin Hapus Data Ini?</h3>
        <p>Apakah Anda yakin ingin menghapus data ini?<br>Tindakan ini tidak dapat dibatalkan.</p>
        <div class="delete-modal-actions">
            <button onclick="cancelDelete()" class="cancel-delete">Cancel</button>
            <button onclick="confirmDelete()" class="confirm-delete">Delete</button>
        </div>
    </div>
</div>



    

<div x-data="{ searchQuery: '' }">
    <div class="content-wrapper">
        <div class="section-header d-flex justify-content-between align-items-center mb-4">
            <h1 class="page-title">Kelola Ruangan</h1>
        </div>

        <!-- Search and Actions -->
        <div class="content-header">
            <div class="search-wrapper">
                <form method="GET" action="{{ route('admin.kelola.ruangan.index') }}" class="search-box">
                    <input type="text" 
                           class="search-input" 
                           placeholder="Cari nama ruangan atau fasilitas..." 
                           name="search" 
                           value="{{ request('search') }}"
                           onchange="this.form.submit()">
                    <i class="fas fa-search search-icon"></i>
                    
                    <!-- Preserve other query parameters if any -->
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                </form>
            </div class="action-buttons">
                <x-button.secondary url="{{ route('admin.kelola.ruangan.export', request()->query()) }}" title="Export" icon="fas fa-download"></x-button.secondary>
                <x-button.primary url="{{ route('admin.kelola.ruangan.create') }}" title="Tambah Ruangan" icon="fas fa-plus"></x-button.primary>
            </div>
        </div>
        <!-- Update the Floor Tabs section -->
        <div class="status-tabs">
            <a href="{{ route('admin.kelola.ruangan.index') }}" 
                class="status-tab {{ !request('lantai') ? 'active' : '' }}">
                Semua ({{ $countAll }})
            </a>
            <a href="{{ route('admin.kelola.ruangan.index', ['lantai' => 1]) }}" 
                class="status-tab {{ request('lantai') == 1 ? 'active' : '' }}">
                Lantai 1 ({{ $countLantai1 }})
            </a>
            <a href="{{ route('admin.kelola.ruangan.index', ['lantai' => 2]) }}" 
                class="status-tab {{ request('lantai') == 2 ? 'active' : '' }}">
                Lantai 2 ({{ $countLantai2 }})
            </a>
            <a href="{{ route('admin.kelola.ruangan.index', ['lantai' => 3]) }}" 
                class="status-tab {{ request('lantai') == 3 ? 'active' : '' }}">
                Lantai 3 ({{ $countLantai3 }})
            </a>
            <a href="{{ route('admin.kelola.ruangan.index', ['lantai' => 4]) }}" 
                class="status-tab {{ request('lantai') == 4 ? 'active' : '' }}">
                Lantai 4 ({{ $countLantai4 }})
            </a>
            <a href="{{ route('admin.kelola.ruangan.index', ['lantai' => 5]) }}" 
                class="status-tab {{ request('lantai') == 5 ? 'active' : '' }}">
                Lantai 5 ({{ $countLantai5 }})
            </a>
        </div>


        <div class="no-results" style="display: none; text-align: center; padding: 2rem;">
            <i class="fas fa-search" style="font-size: 2rem; margin-bottom: 1rem; display: block; color: #94a3b8;"></i>
            <p>Tidak ada ruangan yang sesuai dengan pencarian Anda</p>
        </div>

        <!-- Table -->
        <div class="table-container">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>NAMA RUANGAN</th>
                        <th>KAPASITAS</th>
                        <th>LOKASI</th>
                        <th>FASILITAS</th>
                        <th>JAM OPERASIONAL</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ruangans as $ruangan)
                    <tr x-show="activeTab === 'semua' || (activeTab === 'lantai1' && '{{ $ruangan->lokasi }}'.toLowerCase().includes('lantai 1')) || 
                                    (activeTab === 'lantai2' && '{{ $ruangan->lokasi }}'.toLowerCase().includes('lantai 2')) || 
                                    (activeTab === 'lantai3' && '{{ $ruangan->lokasi }}'.toLowerCase().includes('lantai 3'))"
                        x-transition>
                        <td>{{ $ruangan->id }}</td>
                        <td>{{ $ruangan->nama_ruangan }}</td>
                        <td>{{ $ruangan->kapasitas }}</td>
                        <td>{{ $ruangan->lokasi }}</td>
                        <td class="truncate-text">{{ $ruangan->fasilitas }}</td>
                        <td>{{ $ruangan->jam_operasional }}</td>
                        <td style="position: relative;">
                            
                            <div class="dropdown-action" style="position: relative; display: inline-block;">
                                <button class="action-btn btn-icon"  aria-label="Menu opsi lainnya" onclick="toggleDropdown(this)">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu-action" style="display: none; position: absolute; right: 0; top: 30px; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); min-width: 120px; z-index: 10;">
                                    <a href="{{ route('admin.kelola.ruangan.edit', $ruangan->id) }}" class="dropdown-item-action" style="display: block; padding: 10px 16px; color: #1e293b; text-decoration: none;">Edit</a>
                                    <form action="{{ route('admin.kelola.ruangan.destroy', $ruangan->id) }}" method="POST" style="margin:0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="showDeleteConfirmation(this.form)" class="dropdown-item-action" style="display: block; padding: 10px 16px; color: #dc2626; background: none; border: none; width: 100%; text-align: left;">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <div class="empty-state">
                                <i class="fas fa-inbox text-gray-400"></i>
                                <p>Tidak ada data ruangan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination-wrapper">
            <div class="pagination-info">
                <span>Showing {{ $ruangans->firstItem() }}-{{ $ruangans->lastItem() }} of {{ $ruangans->total() }}</span>
            </div>
            <!-- {{ $ruangans->links() }} -->
            <div class="pagination">
                <!-- {{-- Tombol Prev --}} -->
                <button class="page-btn" {{ $ruangans->onFirstPage() ? 'disabled' : '' }}
                    onclick="window.location='{{ $ruangans->previousPageUrl() }}'">Prev</button>

                <!-- {{-- Tombol Halaman --}} -->
                @for ($i = 1; $i <= $ruangans->lastPage(); $i++)
                    @if ($i == $ruangans->currentPage())
                        <button class="page-btn active">{{ $i }}</button>
                    @elseif ($i == 1 || $i == $ruangans->lastPage() || abs($i - $ruangans->currentPage()) <= 1)
                        <button class="page-btn"
                            onclick="window.location='{{ $ruangans->url($i) }}'">{{ $i }}</button>
                    @elseif ($i == 2 && $ruangans->currentPage() > 4)
                        <span class="dots">...</span>
                    @elseif ($i == $ruangans->lastPage() - 1 && $ruangans->currentPage() < $ruangans->lastPage() - 3)
                        <span class="dots">...</span>
                    @endif
                @endfor

                <!-- {{-- Tombol Next --}} -->
                <button class="page-btn" {{ $ruangans->hasMorePages() ? '' : 'disabled' }}
                    onclick="window.location='{{ $ruangans->nextPageUrl() }}'">Next</button>
            </div>
        </div>
    </div>
</div>

@if(session('added'))
        <x-toast.approve title="Ruangan berhasil ditambahkan" condition="{{ session('added') }}"></x-toast.approve>
    @endif
    @if(session('deleted'))
        <x-toast.reject title="Ruangan berhasil dihapus" condition="{{ session('rejected') }}"></x-toast.reject>
    @endif


<style>
    /* Main Layout */
    .main-content {
        padding: 24px;
        background: #F2F4F7;
    }

    .page-title {
        font-size: 24px;
        font-weight: 600;
        color: #1E293B;
        margin: 0;
    }

    /* Search and Actions */
    .content-wrapper {
        padding-top: 24px;
        padding-bottom: 24px;
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

    .action-buttons {
        display: flex;
        gap: 1.5rem;
    }

    .action-btn {
        height: 40px;
        padding: 0 16px;
        border: 1px solid #E2E8F0;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
        background: white;
        color: #64748B;
        cursor: pointer;
        transition: all 0.2s;
    }

    .action-btn:hover  {
        border-color: #CBD5E1;
        color: #475569;
    }

    /* Table Styles */
    .table-container {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        overflow: visible;
    }

    .custom-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .custom-table th {
        background: white;
        padding: 12px 16px;
        font-size: 12px;
        font-weight: 600;
        color: #64748B;
        text-align: left;
        border-bottom: 1px solid #E2E8F0;
    }

    .custom-table td {
        padding: 12px 16px;
        font-size: 14px;
        color: #1E293B;
        border-bottom: 1px solid #E2E8F0;
    }

    .truncate-text {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 300px; 
    }

    /* Delete Modal Styles */
    .delete-modal {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 1000;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .delete-modal-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
    }

    .delete-modal-content {
        position: relative;
        background: white;
        padding: 32px;
        border-radius: 12px;
        text-align: center;
        max-width: 400px;
        width: 90%;
        z-index: 1;
    }

    .delete-icon {
        color: #EF4444;
        font-size: 48px;
        margin-bottom: 16px;
    }

    .delete-modal-content h3 {
        color: #1F2937;
        font-size: 20px;
        margin-bottom: 8px;
    }

    .delete-modal-content p {
        color: #6B7280;
        font-size: 14px;
        margin-bottom: 24px;
    }

    .delete-modal-actions {
        display: flex;
        gap: 12px;
        justify-content: center;
    }

    .cancel-delete {
        padding: 8px 16px;
        background: white;
        border: 1px solid #E5E7EB;
        color: #6B7280;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
    }

    .cancel-delete:hover {
        background: #F3F4F6;
    }

    .confirm-delete {
        padding: 8px 16px;
        background: #EF4444;
        border: none;
        color: white;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
    }

    .confirm-delete:hover {
        background: #DC2626;
    }

    /* Status Badge */
    .status-badge {
        padding: 4px 12px;
        border-radius: 100px;
        font-size: 12px;
        font-weight: 500;
        display: inline-block;
    }

    .status-success {
        background: #DCFCE7;
        color: #166534;
    }

    .status-warning {
        background: #FEF3C7;
        color: #92400E;
    }

    .status-danger {
        background: #FEE2E2;
        color: #991B1B;
    }

    /* Action Column */
    .action-column {
        width: 60px;
    }

    .btn-action {
        width: 32px;
        height: 32px;
        border: none;
        background: none;
        color: #64748B;
        cursor: pointer;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-action:hover {
        background: #F1F5F9;
        color: #475569;
    }

    .dropdown-menu {
        position: absolute;
        right: 0;
        top: 100%;
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
        min-width: 160px;
        z-index: 10;
        display: none;
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        font-size: 14px;
        color: #475569;
        text-decoration: none;
        transition: all 0.2s;
    }

    .dropdown-item:hover {
        background: #F8FAFC;
    }

    .dropdown-item.text-danger {
        color: #DC2626;
    }

    .dropdown-item.text-danger:hover {
        background: #FEF2F2;
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
    /* Responsive Design */
    @media (max-width: 768px) {
        .content-header {
            flex-direction: column;
            gap: 16px;
        }

        .search-wrapper {
            width: 100%;
        }

        .action-buttons {
            width: 100%;
            justify-content: flex-end;
        }
    }

    /* Floor Tabs Styles */
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
    /* Update the success-notification style */
    .success-notification {
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 1000;
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        padding: 16px 24px;
        display: flex;
        align-items: center;
        gap: 12px;
        animation: slideDown 0.3s ease-out;
    }

    /* Update the animation for top-center appearance */
    @keyframes slideDown {
        from {
            transform: translateX(-50%) translateY(-100%);
            opacity: 0;
        }
        to {
            transform: translateX(-50%) translateY(0);
            opacity: 1;
        }
    }

    .success-notification-content {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .success-icon {
        color: #10B981;
        font-size: 20px;
    }

    .close-success {
        background: none;
        border: none;
        color: #64748B;
        cursor: pointer;
        padding: 4px;
    }

    .close-success:hover {
        color: #475569;
    }

    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
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

    function toggleDropdown(btn) {
    // Tutup dropdown lain
    document.querySelectorAll('.dropdown-menu-action').forEach(el => {
        if (el !== btn.nextElementSibling) el.style.display = 'none';
    });
    // Toggle dropdown ini
    const menu = btn.nextElementSibling;
    menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
}

    // Tutup dropdown jika klik di luar
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown-action')) {
            document.querySelectorAll('.dropdown-menu-action').forEach(el => el.style.display = 'none');
        }
    });

    let currentDeleteForm = null;

    function showDeleteConfirmation(form) {
        currentDeleteForm = form;
        document.getElementById('deleteConfirmModal').style.display = 'flex';
    }

    function cancelDelete() {
        document.getElementById('deleteConfirmModal').style.display = 'none';
        currentDeleteForm = null;
    }

    function confirmDelete() {
        if (currentDeleteForm) {
            currentDeleteForm.submit();
        }
    }

    function showSuccessNotification(message) {
        const notification = document.getElementById('successNotification');
        document.getElementById('successMessage').textContent = message;
        notification.style.display = 'block';
        
        setTimeout(() => {
            closeSuccessNotification();
        }, 3000);
    }

    function closeSuccessNotification() {
        document.getElementById('successNotification').style.display = 'none';
    }

   

    // Add Alpine.js data handling for tabs
    document.addEventListener('alpine:init', () => {
        Alpine.data('ruanganData', () => ({
            activeTab: 'semua',
            searchQuery: '',
            
            filterItems() {
                // Implementation for filtering items
            }
        }))
    })

   
</script>
@endsection



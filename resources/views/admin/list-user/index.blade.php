@extends('layouts.admin')

@section('content')
<div x-data="{ searchQuery: '' }">
    <div class="content-wrapper">
        <!-- Header -->
        <div class="section-header">
            <h1>List User</h1>
        </div>

        <!-- Search and Actions -->
        <div class="content-header">
            <div class="search-wrapper">
                <form method="GET" action="{{ route('admin.list-user.index') }}" class="search-box">
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
                <x-button.secondary url="{{ route('admin.list-user.export') }}" title="Export CSV" icon="fas fa-download"></x-button.secondary>
            </div>
        </div>

        

        <!-- Table -->
        <div class="table-container">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>NAMA LENGKAP</th>
                        <th>EMAIL</th>
                        <th>ROLE</th>
                        <th>TANGGAL DAFTAR</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                <tbody>
                    @forelse($users as $key => $user)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>{{ $user->created_at->format('d F Y') }}</td>
                        <td class="action-cell">
                            <div class="action-dropdown">
                                <a href="{{ route('admin.list-user.show', $user->id) }}" class="dropdown-item">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">No users found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrapper">
            <div class="pagination-info">
                <span>Showing {{ $users->firstItem() }}-{{ $users->lastItem() }} of {{ $users->total() }}</span>
            </div>
            <!-- {{ $users->links() }} -->
            <div class="pagination">
                <!-- {{-- Tombol Prev --}} -->
                <button class="page-btn" {{ $users->onFirstPage() ? 'disabled' : '' }}
                    onclick="window.location='{{ $users->previousPageUrl() }}'">Prev</button>

                <!-- {{-- Tombol Halaman --}} -->
                @for ($i = 1; $i <= $users->lastPage(); $i++)
                    @if ($i == $users->currentPage())
                        <button class="page-btn active">{{ $i }}</button>
                    @elseif ($i == 1 || $i == $users->lastPage() || abs($i - $users->currentPage()) <= 1)
                        <button class="page-btn"
                            onclick="window.location='{{ $users->url($i) }}'">{{ $i }}</button>
                    @elseif ($i == 2 && $users->currentPage() > 4)
                        <span class="dots">...</span>
                    @elseif ($i == $users->lastPage() - 1 && $users->currentPage() < $users->lastPage() - 3)
                        <span class="dots">...</span>
                    @endif
                @endfor

                <!-- {{-- Tombol Next --}} -->
                <button class="page-btn" {{ $users->hasMorePages() ? '' : 'disabled' }}
                    onclick="window.location='{{ $users->nextPageUrl() }}'">Next</button>
            </div>
        </div>
    </div>
</div>

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

    .status-tabs {
        display: flex;
        gap: 16px;
        margin-bottom: 24px;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 8px;
    }

    .status-tab {
        padding: 8px 16px;
        color: #64748b;
        font-weight: 500;
        text-decoration: none;
        border-radius: 6px;
    }

    .status-tab.active {
        color: #2563eb;
        background-color: #eff6ff;
    }

    .table-container {
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        overflow: hidden;
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

// Checkbox functionality
document.getElementById('checkAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.row-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
    updateBulkActionButtons();
});

document.querySelectorAll('.row-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', updateBulkActionButtons);
});

function updateBulkActionButtons() {
    const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
    const pendingSelected = Array.from(checkedBoxes).filter(checkbox => 
        checkbox.dataset.status === 'pending'
    ).length;
}

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
</script>


@endsection

<!DOCTYPE html>
<meta charset="UTF-8">
<meta name="Kelola ruangan" content="Kelola data ruangan untuk keperluan administrasi dan manajemen fasilitas.">
@extends('layouts.admin')

@section('content')
<div>
    <!-- Success Notification -->
    <div id="successNotification" class="success-notification" style="display: none;">
        <div class="success-notification-content">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <span id="successMessage"></span>
            <button onclick="closeSuccessNotification()" class="close-success">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

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
            <h1 class="page-title">Kelola Event</h1>
        </div>
        <div class="content-header">
            <div class="search-wrapper">
                <form method="GET" action="{{ route('admin.kelola.event.index') }}" class="search-box">
                    <input type="text" 
                           class="search-input" 
                           placeholder="Cari nama event atau penyelenggara..." 
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
                <button class="btn btn-outline-secondary {{ request()->has('filter_date') ? 'has-filter' : '' }}" id="filterBtn">
                    Filter Tanggal <i class="fas fa-calendar"></i>
                    @if(request()->has('filter_date'))
                        <span class="filter-date">{{ \Carbon\Carbon::parse(request('filter_date'))->format('d M Y') }}</span>
                    @endif
                </button>
                    <x-button.secondary url="{{ route('admin.kelola.event.export', request()->query()) }}" title="Export" icon="fas fa-download"></x-button.secondary>
                    <x-button.primary url="{{ route('admin.kelola.event.create') }}" title="Tambah Ruangan" icon="fas fa-plus"></x-button.primary>
            </div>
        </div>
        <div class="status-tabs">
            <a href="{{ route('admin.kelola.event.index') }}"
               class="tab {{ request('status') == null ? 'active' : '' }}">
                Semua ({{ $countAll }})
            </a>
            <a href="{{ route('admin.kelola.event.index', ['status' => 'berlangsung']) }}"
               class="tab {{ request('status') == 'berlangsung' ? 'active' : '' }}">
                Berlangsung ({{ $countBerlangsung }})
            </a>
            <a href="{{ route('admin.kelola.event.index', ['status' => 'akan_datang']) }}"
               class="tab {{ request('status') == 'akan_datang' ? 'active' : '' }}">
                Akan datang ({{ $countAkanDatang }})
            </a>
            <a href="{{ route('admin.kelola.event.index', ['status' => 'selesai']) }}"
               class="tab {{ request('status') == 'selesai' ? 'active' : '' }}">
                Selesai ({{ $countSelesai }})
            </a>
        </div>

         <!-- No Results Message -->
         <div class="no-results" style="display: none; text-align: center; padding: 2rem;">
            <i class="fas fa-search" style="font-size: 2rem; margin-bottom: 1rem; display: block; color: #94a3b8;"></i>
            <p>Tidak ada event yang sesuai dengan pencarian Anda</p>
        </div>

        <div class="table-responsive">
           
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NAMA EVENT</th>
                            <th>TANGGAL PELAKSANAAN</th>
                            <th>WAKTU</th>
                            <th>PENYELENGGARA</th>
                            <th>LOKASI RUANGAN</th>
                            <th>STATUS</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($events as $event)
                        <tr>
                            <td>{{ $event->id }}</td>
                            <td>{{ $event->nama_event }}</td>
                            <td>{{ \Carbon\Carbon::parse($event->tanggal_pelaksanaan)->format('d F Y') }}</td>
                            <td>{{ $event->waktu }}</td>
                            <td>{{ $event->penyelenggara }}</td>
                            <td>{{ $event->lokasi_ruangan }}</td>
                            <td>
                                <span class="status-badge {{ str_replace('_', '-', $event->status) }}">
                                    {{ ucfirst(str_replace('_', ' ', $event->status)) }}
                                </span>
                            </td>
                            <td style="position: relative;">
                                <div class="dropdown-action" style="position: relative; display: inline-block;">
                                    <button class="btn btn-icon" aria-label="Menu opsi lainnya" onclick="toggleDropdown(this)">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu-action" style="display: none; position: absolute; right: 0; top: 30px; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); min-width: 120px; z-index: 10;">
                                        <a href="{{ route('admin.kelola.event.edit', $event->id) }}" class="dropdown-item-action" style="display: block; padding: 10px 16px; color: #1e293b; text-decoration: none;">Edit</a>
                                        <form action="{{ route('admin.kelola.event.destroy', $event->id) }}" method="POST" style="margin:0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" aria-label="Menu delete" onclick="showDeleteConfirmation(this.form)" class="dropdown-item-action" style="display: block; padding: 10px 16px; color: #dc2626; background: none; border: none; width: 100%; text-align: left;">Delete</button>
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
                                    <p>Tidak ada data event</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            
        </div>

        <div class="pagination-wrapper">
            <div class="pagination-info">
                <span>{{ $events->firstItem() }}-{{ $events->lastItem() }} of {{ $events->total() }}</span>
                <select class="form-select"  aria-label="Jumlah baris per halaman">
                    <option>Rows per page: {{ $events->perPage() }}</option>
                    <option>20</option>
                    <option>50</option>
                </select>
            </div>
            <div class="pagination">
                <!-- {{-- Tombol Prev --}} -->
                <button class="page-btn" {{ $events->onFirstPage() ? 'disabled' : '' }}
                    onclick="window.location='{{ $events->previousPageUrl() }}'">Prev</button>

                <!-- {{-- Tombol Halaman --}} -->
                @for ($i = 1; $i <= $events->lastPage(); $i++)
                    @if ($i == $events->currentPage())
                        <button class="page-btn active">{{ $i }}</button>
                    @elseif ($i == 1 || $i == $events->lastPage() || abs($i - $events->currentPage()) <= 1)
                        <button class="page-btn"
                            onclick="window.location='{{ $events->url($i) }}'">{{ $i }}</button>
                    @elseif ($i == 2 && $events->currentPage() > 4)
                        <span class="dots">...</span>
                    @elseif ($i == $events->lastPage() - 1 && $events->currentPage() < $events->lastPage() - 3)
                        <span class="dots">...</span>
                    @endif
                @endfor

                <!-- {{-- Tombol Next --}} -->
                <button class="page-btn" {{ $events->hasMorePages() ? '' : 'disabled' }}
                    onclick="window.location='{{ $events->nextPageUrl() }}'">Next</button>
            </div>
        </div>
    </div>
    <!-- Filter Tanggal Modal -->
    <div class="filter-modal" id="filterModal">
            <div class="filter-modal-content">
                <div class="modal-header">
                    <h3>Filter Berdasarkan Tanggal</h3>
                    <div class="modal-actions">
                        @if(request()->has('filter_date'))
                            <a href="{{ route('admin.verifikasi.kunjungan.index') }}" class="clear-filter">
                                <i class="fas fa-times"></i> Clear
                            </a>
                        @endif
                        <button class="close-btn"><i class="fas fa-times"></i></button>
                    </div>
                </div>
                <div class="calendar-container">
                    <div class="calendar-header">
                        <button class="month-nav prev"><i class="fas fa-chevron-left"></i></button>
                        <span class="current-month">July 2021</span>
                        <button class="month-nav next"><i class="fas fa-chevron-right"></i></button>
                    </div>
                    <div class="calendar-weekdays">
                        <div>MON</div>
                        <div>TUE</div>
                        <div>WED</div>
                        <div>THU</div>
                        <div>FRI</div>
                        <div>SAT</div>
                        <div>SUN</div>
                    </div>
                    <div class="calendar-days"></div>
                </div>
            </div>
        </div>
</div>
@if(session('added'))
        <x-toast.approve title="Data Event berhasil ditambahkan" condition="{{ session('added') }}"></x-toast.approve>
    @endif
    @if(session('deleted'))
        <x-toast.reject title="Data Event berhasil dihapus" condition="{{ session('rejected') }}"></x-toast.reject>
    @endif

<style>

    :root {
        --top-nav-height: 60px; 
    }
    .content-wrapper {
        position: relative;
        margin-top: var(--top-nav-height);
        padding: 24px;
        background: #f8fafc;
    }

    .page-title {
        font-size: 24px;
        font-weight: 600;
        color: #1E293B;
        margin: 0;
        padding-left: 24px;
    }
    .content-wrapper {
        padding: 24px;
    }

    .content-header {
        background: white;
        padding: 20px ;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 24px;
    }

    .search-bar {
        flex: 1;
        max-width: 300px;
        position: relative;
    }

    .search-bar input {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 14px;
    }

    .actions {
        display: flex;
        gap: 10px;
    }

    .actions .btn {
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary {
        background: #0041C2;
        color: white;
        border: none;
    }

    .btn-outline-secondary {
        border: 1px solid #e2e8f0;
        background: white;
        color: #64748b;
    }

    .status-tabs {
        display: flex;
        gap: 30px;
        margin-top: 24px;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 0;
        background: white;
        padding: 20px;
        border-radius: 8px 8px 0 0;
    }

    .tab {
        color: #64748b;
        text-decoration: none;
        padding: 12px 0;
        font-size: 14px;
        position: relative;
    }

    .tab.active {
        color: #0041C2;
        font-weight: 500;
    }

    .tab.active::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        right: 0;
        height: 2px;
        background: #0041C2;
    }

    .table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table-responsive {
        background-color:white;
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }



    .table th {
        font-weight: 500;
        color: #64748b;
        border-bottom: 1px solid #e2e8f0;
        padding: 12px 16px;
        text-align: left;
        font-size: 12px;
    }

    .table td {
        padding: 16px;
        border-bottom: 1px solid #e2e8f0;
        font-size: 14px;
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

    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        display: inline-block;
    }

    .status-badge.berlangsung {
        background: #EBF5FF;
        color: #0041C2;
    }

    .status-badge.akan-datang {
        background: #FFF7ED;
        color: #92400e;
    }

    .status-badge.selesai {
        background: #F0FDF4;
        color: #166534;
    }

    .btn-icon {
        padding: 8px;
        background: none;
        border: none;
        color: #64748b;
        cursor: pointer;
    }

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

    .dropdown-menu-action {
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        border-radius: 8px;
        background: #fff;
        min-width: 120px;
        padding: 4px 0;
    }
    .dropdown-item-action {
        display: block;
        padding: 10px 16px;
        color: #1e293b;
        text-decoration: none;
        cursor: pointer;
        background: none;
        border: none;
        width: 100%;
        text-align: left;
        font-size: 14px;
    }
    .dropdown-item-action:hover {
        background: #f3f4f6;
    }
    .dropdown-item-action:last-child {
        color: #dc2626;
    }

    .search-form {
        display: flex;
        gap: 10px;
        width: 100%;
        max-width: 500px;
    }

    .search-form .form-control {
        flex: 1;
        padding: 10px 15px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.875rem;
        transition: all 0.3s ease;
    }

    .search-form .form-control:focus {
        border-color: #0041C2;
        box-shadow: 0 0 0 3px rgba(0,65,194,0.1);
        outline: none;
    }

    .search-button {
        padding: 10px 20px;
        background: #0041C2;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .search-button:hover {
        background: #003399;
    }

    .search-button i {
        font-size: 1rem;
    }

    .filter-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        justify-content: center;
        align-items: center;
    }

    .filter-modal-content {
        background: white;
        border-radius: 8px;
        width: 300px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px;
        border-bottom: 1px solid #e2e8f0;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 16px;
        color: #1e293b;
    }

    .close-btn {
        background: none;
        border: none;
        cursor: pointer;
        color: #64748b;
        font-size: 16px;
    }

    .calendar-container {
        padding: 16px;
    }

    .calendar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
    }

    .month-nav {
        background: none;
        border: none;
        cursor: pointer;
        color: #64748b;
        padding: 4px 8px;
    }

    .current-month {
        font-weight: 500;
        color: #1e293b;
    }

    .calendar-weekdays {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        text-align: center;
        font-size: 12px;
        color: #64748b;
        margin-bottom: 8px;
    }

    .calendar-days {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 4px;
    }

    .calendar-day {
        aspect-ratio: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border-radius: 4px;
        font-size: 14px;
    }

    .calendar-day:hover {
        background: #eff6ff;
    }

    .calendar-day.selected {
        background: #0041C2;
        color: white;
    }

    .calendar-day.today {
        font-weight: bold;
    }

    .modal-actions {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .clear-filter {
        display: flex;
        align-items: center;
        gap: 4px;
        padding: 4px 8px;
        background: ##f1f5f9;
        border-radius: 4px;
        color: #64748b;
        text-decoration: none;
        font-size: 12px;
        transition: all 0.2s ease;
    }

    .clear-filter:hover {
        background: #e2e8f0;
        color: #475569;
    }

    .clear-filter i {
        font-size: 10px;
    }

    #filterBtn.has-filter {
        color: #0041C2;
        border-color: #0041C2;
    }

    #filterBtn.has-filter i {
        color: #0041C2;
    }

    /* Search Styles */
    .search-group {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
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

    .search-input:focus {
        border-color: #0041C2;
        background-color: #fff;
        box-shadow: 0 0 0 3px rgba(0, 65, 194, 0.1);
        outline: none;
    }

    /* Success Notification Styles */
    .success-notification {
        position: fixed;
        top: 24px;
        right: 24px;
        z-index: 1000;
        animation: slideIn 0.3s ease-out;
    }

    .success-notification-content {
        display: flex;
        align-items: center;
        gap: 12px;
        background: white;
        padding: 16px 24px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border: 1px solid #e2e8f0;
    }

    .success-icon {
        color: #10B981;
        font-size: 24px;
    }

    .success-notification span {
        color: #1F2937;
        font-size: 14px;
    }

    .close-success {
        background: none;
        border: none;
        color: #6B7280;
        cursor: pointer;
        padding: 4px;
        margin-left: 12px;
    }

    .close-success:hover {
        color: #374151;
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

    /* Pagination Styles */
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
@endsection

<!-- Filter Modal -->
<div class="filter-modal" id="filterModal">
    <div class="filter-modal-content">
        <div class="modal-header">
            <h3>Filter Berdasarkan Tanggal</h3>
            <div class="modal-actions">
                @if(request()->has('filter_date'))
                    <a href="{{ route('admin.kelola.event.index') }}" class="clear-filter">
                        <i class="fas fa-times"></i> Clear
                    </a>
                @endif
                <button class="close-btn"><i class="fas fa-times"></i></button>
            </div>
        </div>
        <div class="calendar-container">
            <div class="calendar-header">
                <button class="month-nav prev"><i class="fas fa-chevron-left"></i></button>
                <span class="current-month">July 2021</span>
                <button class="month-nav next"><i class="fas fa-chevron-right"></i></button>
            </div>
            <div class="calendar-weekdays">
                <div>MON</div>
                <div>TUE</div>
                <div>WED</div>
                <div>THU</div>
                <div>FRI</div>
                <div>SAT</div>
                <div>SUN</div>
            </div>
            <div class="calendar-days"></div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterBtn = document.getElementById('filterBtn');
    const filterModal = document.getElementById('filterModal');
    const closeBtn = document.querySelector('.close-btn');
    const calendarDays = document.querySelector('.calendar-days');
    const currentMonthEl = document.querySelector('.current-month');
    const prevMonthBtn = document.querySelector('.month-nav.prev');
    const nextMonthBtn = document.querySelector('.month-nav.next');
    
    let currentDate = new Date();
    const urlParams = new URLSearchParams(window.location.search);
    const filterDateParam = urlParams.get('filter_date');

    let selectedDate = filterDateParam ? new Date(filterDateParam) : null;

    function renderCalendar() {
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();
        
        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const daysInMonth = lastDay.getDate();
        const startingDay = firstDay.getDay() || 7; // Convert Sunday (0) to 7

        currentMonthEl.textContent = firstDay.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
        
        calendarDays.innerHTML = '';

        // Add empty cells for days before the first day of the month
        for (let i = 1; i < startingDay; i++) {
            calendarDays.appendChild(document.createElement('div'));
        }

        // Add days of the month
        for (let day = 1; day <= daysInMonth; day++) {
            const dayEl = document.createElement('div');
            dayEl.classList.add('calendar-day');
            dayEl.textContent = day;

            const fullDate = new Date(year, month, day);
            const formattedDate = fullDate.getFullYear() + '-' +
                String(fullDate.getMonth() + 1).padStart(2, '0') + '-' +
                String(fullDate.getDate()).padStart(2, '0');
            dayEl.setAttribute('data-date', formattedDate);

            if (selectedDate &&
                selectedDate.getDate() === day &&
                selectedDate.getMonth() === month &&
                selectedDate.getFullYear() === year) {
                dayEl.classList.add('selected');
            }

            dayEl.addEventListener('click', () => {
                document.querySelectorAll('.calendar-day.selected').forEach(el => el.classList.remove('selected'));
                dayEl.classList.add('selected');
                selectedDate = new Date(year, month, day);

                const fullDate = new Date(year, month, day);
                const formattedDate = fullDate.getFullYear() + '-' +
                    String(fullDate.getMonth() + 1).padStart(2, '0') + '-' +
                    String(fullDate.getDate()).padStart(2, '0');

                const currentParams = new URLSearchParams(window.location.search);
                currentParams.set('filter_date', formattedDate);

                window.location.href = `${window.location.pathname}?${currentParams.toString()}`;
            });

            if (selectedDate) {
                currentDate = new Date(selectedDate.getFullYear(), selectedDate.getMonth(), 1);
            }

            calendarDays.appendChild(dayEl);
        }
    }

    filterBtn.addEventListener('click', () => {
        filterModal.style.display = 'flex';
        renderCalendar();
    });

    closeBtn.addEventListener('click', () => {
        filterModal.style.display = 'none';
    });

    prevMonthBtn.addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar();
    });

    nextMonthBtn.addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar();
    });

    // Close modal when clicking outside
    filterModal.addEventListener('click', (e) => {
        if (e.target === filterModal) {
            filterModal.style.display = 'none';
        }
    });
});

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

// Show notification if there's a success message in session
@if(session('success'))
    showSuccessNotification("{{ session('success') }}");
@endif
</script>



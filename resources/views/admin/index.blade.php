@extends('admin.dashboard')

@section('content')
<div class="container">
    <div class="sidebar">
        <h2>BCH LinkedBase</h2>
        <nav>
            <a href="{{ route('admin.index') }}" class="menu-item">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <div class="menu-group">
                <div class="menu-item">
                    <i class="fas fa-tasks"></i> Kelola
                </div>
                <div class="submenu">
                    <a href="{{ route('admin.kelola.ruangan') }}" class="menu-item">Ruangan</a>
                    <a href="{{ route('admin.kelola.event') }}" class="menu-item">Event</a>
                </div>
            </div>
            <!-- Add other menu items as needed -->
        </nav>
    </div>

    <div class="main-content">
        <div class="top-bar">
            <h2>Dashboard</h2>
            <div class="admin-info">
                <span>Admin: {{ Auth::check() ? Auth::user()->name : 'Guest' }}</span>
                @if(Auth::check())
                    <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                        @csrf
                        <button type="submit" class="logout-btn">
                            <i class="fas fa-sign-out-alt"></i> Keluar
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Pengguna</h3>
                <div class="number">150</div>
                <div class="chart-container">
                    <canvas id="userChart"></canvas>
                </div>
            </div>
            <div class="stat-card">
                <h3>Peminjaman Aktif</h3>
                <div class="number">24</div>
                <div class="chart-container">
                    <canvas id="bookingChart"></canvas>
                </div>
            </div>
            <div class="stat-card">
                <h3>Event Bulan Ini</h3>
                <div class="number">8</div>
                <div class="chart-container">
                    <canvas id="eventChart"></canvas>
                </div>
            </div>
        </div>

        <div class="recent-activity">
            <h3>Aktivitas Terbaru</h3>
            <table class="activity-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>User</th>
                        <th>Aktivitas</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>2023-12-20</td>
                        <td>John Doe</td>
                        <td>Peminjaman Ruangan Auditorium</td>
                        <td><span class="status pending">Pending</span></td>
                    </tr>
                    <tr>
                        <td>2023-12-19</td>
                        <td>Jane Smith</td>
                        <td>Registrasi Event Workshop</td>
                        <td><span class="status approved">Approved</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Add these new styles */
    .container {
        display: flex;
        min-height: 100vh;
    }

    .main-content {
        flex: 1;
        padding: 20px;
        margin-left: 250px; /* Width of sidebar */
    }

    .sidebar {
        position: fixed;
        left: 0;
        top: 0;
        width: 250px;
        height: 100vh;
        background: white;
        padding: 20px;
        box-shadow: 2px 0 5px rgba(0,0,0,0.1);
    }

    /* Existing styles remain the same */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .chart-container {
        height: 150px;
        margin-top: 15px;
    }

    .number {
        font-size: 2rem;
        font-weight: bold;
        color: #0041C2;
        margin: 10px 0;
    }

    .activity-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }

    .activity-table th,
    .activity-table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #eee;
    }

    .status {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.85rem;
    }

    .status.pending {
        background-color: #ffeeba;
        color: #856404;
    }

    .status.approved {
        background-color: #d4edda;
        color: #155724;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // User Chart
    new Chart(document.getElementById('userChart'), {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Pertumbuhan Pengguna',
                data: [65, 78, 90, 110, 125, 150],
                borderColor: '#0041C2',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Booking Chart
    new Chart(document.getElementById('bookingChart'), {
        type: 'bar',
        data: {
            labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum'],
            datasets: [{
                label: 'Peminjaman Harian',
                data: [5, 8, 6, 9, 4],
                backgroundColor: '#0041C2'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Event Chart
    new Chart(document.getElementById('eventChart'), {
        type: 'doughnut',
        data: {
            labels: ['Selesai', 'Akan Datang', 'Dibatalkan'],
            datasets: [{
                data: [4, 3, 1],
                backgroundColor: ['#28a745', '#0041C2', '#dc3545']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
</script>
@endpush
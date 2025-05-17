<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - BCH LinkedBase</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    @php
            $totalPeminjaman = $popularRoom->sum('jumlah_peminjaman');
            $colors = ['#4e73df','#1cc88a','#36b9cc','#f6c23e','#e74a3b','#858796'];
        @endphp
    @stack('styles')
</head>
    


    <!-- Replace @yield('content') with this -->
    @if(isset($content) && $content === 'dashboard-content')
        @yield('dashboard-content')
    @else
        @yield('content')
    @endif

    <!-- Add this default dashboard content -->
    @section('dashboard-content')
    @extends('layouts.admin')

    @section('content')

    <style>
    .status-cards {
        padding: 1rem 0;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        margin: 1rem 0;
        
    }

    .status-card {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }


    .status-card h2 {
        font-size: 2rem;
        margin: 0;
    }
    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #333;
    }
    .jumlah-pengajuan {
        font-size: 1.25rem;
        font-weight: 600;
        color: #0041c2;
    }
    .card-content {
        display: flex;
        align-items: center;
        gap: 1rem; 
    }
    .icon {
        background-color: #EFF4FF;
        padding: 0.5rem;
        border-radius: 12px;
    }
    .icon i {
        background-color: #D1E0FF;
        border-radius: 12px;
        font-size: 1rem;
        color: #0041c2;
        padding: 0.5rem;
    }
    .table {
        border-collapse: separate;
        border-spacing: 0 10px;
        border-radius: 40px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 14px;
        background-color: #fff;
    }

    .table thead {
        background-color: #EFF4FF   ;
        color: #0041c2;
    }

    .table th, .table td {
        padding: 12px 15px;
        text-align: left;
    }

    .table tbody tr {
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease;
        background-color: #fafafa;
    }

    .table tbody tr:hover {
        transform: scale(1.01);
        background-color: #f1f1f1;
    }

    .table tbody td {
        border-top: 1px solid #dee2e6;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f9f9f9;
    }

    .table-bordered {
        border: none;
    }

    .title{
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .second-cards {
        display: grid;
        grid-template-columns: 250px 1fr; /* Membagi menjadi 2 kolom: roomChart dan tabel */
        gap: 1.5rem;
        margin-top: 1.5rem;
    }
    
    .chart-card {
        max-width: 200px;
        margin: auto;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        padding: 20px;
        font-family: sans-serif;
    }

    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
    }

    .chart-header h2 {
        font-size: 14px;
        font-weight: 600;
        color: #555;
    }

    .chart-header button {
        font-size: 12px;
        color: #888;
        background: none;
        border: none;
        cursor: pointer;
    }

    .room-chart {
        position: relative;
        width: 100%;
        max-width: 200px;
        margin: auto;
    }

    .room-chart-center-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
    }

    .room-chart-center-text p {
        margin: 0;
        font-size: 13px;
        color: #777;
    }

    .room-chart-center-text strong {
        font-size: 20px;
        font-weight: 600;
        color: #000;
    }

    .legend-list {
        margin-top: 20px;
        font-size: 14px;
    }

    .legend-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        color: #333;
    }

    .legend-label {
        display: flex;
        align-items: center;
    }

    .legend-color {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        margin-right: 8px;
        flex-shrink: 0;
    }

    .legend-value {
        color: #777;
    }

    @media (max-width: 480px) {
        .chart-card {
            padding: 16px;
        }

        .room-chart {
            max-width: 160px;
        }

        .legend-item {
            font-size: 13px;
        }

        .chart-center-text strong {
            font-size: 18px;
        }
    }

    .tab-btn {
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 300;
        font-size: 1.8vh;
        text-decoration: none;
        background: white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        color: #1a202c;
        transition: 0.2s;
    }
    .tab-btn:hover {
        background: #cbd5e0;
    }
    .tab-btn.active {
        background: #3b82f6;
        color: white;
    }
    </style>

    <div class="dashboard-wrapper">
        <div class="top-bar">
            <div class="header-content">
                <h2>Dashboard</h2>
                <p class="text-gray-500">Welcome back, {{ Auth::user()->name }}</p>
            </div>
            <div class="admin-info">
                <div class="date-display">
                    <i class="fas fa-calendar"></i>
                    <span>{{ now()->format('l, d F Y') }}</span>
                </div>
            </div>
        </div>

        <!-- fix -->
        <div class="status-cards">
            <div class="status-card">
                <div class="card-header ">
                    <div class="title">
                        <i class="fa-regular fa-chart-bar"></i>
                        <h4 class="m-0 font-weight-semibold title">Total Pengajuan</h4>

                    </div>
                    <div class="tabs">
                        <a href="?mode=monthly" class="tab-btn {{ $mode == 'monthly' ? 'active' : '' }}">Monthly</a>
                        <a href="?mode=quarterly" class="tab-btn {{ $mode == 'quarterly' ? 'active' : '' }}">Quarterly</a>
                        <a href="?mode=yearly" class="tab-btn {{ $mode == 'yearly' ? 'active' : '' }}">Yearly</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height:240px;">
                        <!-- Chart -->
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="status-card">
                <div class="card-header">
                    <h3 title>Status Pengajuan</h3>
                </div>
                <p title>Rekapitulasi status pengajuan semua layanan</p>
                <div class="status-cards">
                    <div class="status-card">
                        <div class="card-content">
                            <div class="icon">
                                <i class="fas fa-chart-simple"></i>
                            </div>
                            <div class="isi">
                                <p class="mb-0">Total Pengajuan</p>
                                <h2 class="jumlah-pengajuan">{{ $totalPengajuan['total'] }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="status-card">
                        <div class="card-content">
                            <div class="icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="isi">
                                <p class="mb-0">Pengajuan Disetujui</p>
                                <h2 class="jumlah-pengajuan">{{ $totalDisetujui  }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="status-card">
                        <div class="card-content">
                            <div class="icon">
                                <i class="fas fa-spinner"></i>
                            </div>
                            <div class="isi">
                                <p class="mb-0">Pengajuan Diproses</p>
                                <h2 class="jumlah-pengajuan">{{ $totalDiproses  }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="status-card">
                        <div class="card-content">
                                <div class="icon">
                                    <i class="fas fa-xmark"></i>
                                </div>
                                <div class="isi">
                                    <p class="mb-0">Pengajuan Ditolak</p>
                                    <h2 class="jumlah-pengajuan">{{ $totalDitolak  }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>

            </div>
        </div>
        <!-- !-- Struktur baru untuk second-cards --> 
        <div class="second-cards">
            <!-- Kolom kiri: Room Chart -->
            <div class="chart-card">
                <div class="chart-header">
                    <i class="fa-solid fa-trophy"></i>
                    <h2> Top Ruangan</h2>
                    <button>Lihat Semua</button>
                </div>

                <div class="room-chart">
                    <canvas id="roomChart"></canvas>
                    <div class="room-chart-center-text">
                        <p>Total</p>
                        <strong>{{ $totalPeminjaman }}</strong>
                    </div>
                </div>

                <div class="legend-list">
                    @foreach ($popularRoom as $index => $room)
                        @php
                            $percentage = $totalPeminjaman > 0
                                ? round(($room->jumlah_peminjaman / $totalPeminjaman) * 100)
                                : 0;
                            $color = $colors[$index % count($colors)];
                        @endphp
                        <div class="legend-item">
                            <div class="legend-label">
                                <span class="legend-color" style="background-color: {{ $color }}"></span>
                                {{ $room->nama_ruangan }}
                            </div>
                            <div class="legend-value">
                                {{ $room->jumlah_peminjaman }} <span style="margin-left: 4px;">{{ $percentage }}%</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Kolom kanan: Tabel -->
            <div class="table-container">
                <div class="status-card">
                    <h3>Data Pengajuan Terbaru</h3>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>NAMA PEMOHON</th>
                                <th>INSTANSI</th>
                                <th>TANGGAL PENGAJUAN</th>
                                <th>KONTAK PIC</th>
                                <th>STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mediapartners as $i => $item)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $item->nama_pemohon }}</td>
                                <td>{{ $item->nama_instansi }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d F Y') }}</td>
                                <td>{{ $item->pic_whatsapp }}</td>
                                <td>
                                    <span class="status-badge {{ 
                                        $item->status === 'approved' ? 'status-success' : 
                                        ($item->status === 'pending' ? 'status-warning' : 'status-danger') 
                                    }}">
                                        • {{ $item->status === 'approved' ? 'Disetujui' : 
                                        ($item->status === 'pending' ? 'Menunggu' : 'Ditolak') }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
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
            </div>
        </div>
    


        <!-- <div class="container">
            <h3>Forecast Peminjaman Ruangan</h3>

            <div class="mb-3">
                <label for="periodeSelect" class="form-label">Pilih Periode:</label>
                <select id="periodeSelect" class="form-select">
                    <option value="quarter">Quarter (3 Bulan)</option>
                    <option value="half">Half (6 Bulan)</option>
                    <option value="year" selected>Year (12 Bulan)</option>
                </select>
            </div>

            <canvas id="forecastChart" height="100"></canvas>
        </div> -->

        <!-- <h2>Forecast Peminjaman </h2>

        <form method="GET" action="/forecast/chart">
            <label for="range">Pilih Periode:</label>
            <select name="range" id="range" onchange="this.form.submit()">
                <option value="3" {{ (isset($range) && $range == 3) ? 'selected' : '' }}>3 Bulan</option>
                <option value="6" {{ (isset($range) && $range == 6) ? 'selected' : '' }}>6 Bulan</option>
                <option value="12" {{ (isset($range) && $range == 12) ? 'selected' : '' }}>12 Bulan</option>
            </select>
        </form>

        <canvas id="forecastChart" width="800" height="400"></canvas> -->
    </div>
    
    
    @push('styles')
    <style>
    :root {
        --top-nav-height: 60px; 
    }
    .dashboard-wrapper {
        position: relative;
        margin-top: var(--top-nav-height);
        padding: 24px;
        background: #f8fafc;
    }
    
    .top-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .header-content h2 {
        font-size: 24px;
        font-weight: 600;
        color: #1a1a1a;
        margin: 0;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
        margin-bottom: 24px;
    }
    
    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    
    .stat-card h3 {
        color: #64748b;
        font-size: 14px;
        margin: 0 0 12px 0;
    }

    .status-card p {
        color: #0b0b0b;
        font-size: 14px;
        margin: 0 0 12px 0;
    }
    
    .stat-card .number {
        font-size: 32px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 16px;
    }

    .card-header{
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-header h3{
        margin: 0;
    }

    .card-header p{
        display: inline-flex;
        align-items: right;
        color: #0041C2;
        background-color: #EFF4FF;
        max-width: 4rem;
        padding: 6px 12px;
        border-radius: 9999px;
        font-size: 13px;
        font-weight: 500;
        
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
    
    .chart-container {
        height: 100%;
        margin-top: 15px;
    }
    
    .activity-table {
        width: 100%;
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    
    .activity-table th {
        background: #f8f9fa;
        padding: 12px 16px;
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
    }
    
    .activity-table td {
        padding: 16px;
        border-bottom: 1px solid #eee;
    }
    
    .date-display {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        background: white;
        border-radius: 8px;
        font-size: 14px;
        color: #64748b;
    }
    </style>
    @endpush
    
    @push('scripts')

    <!-- Script untuk menampilkan chart jumlah pengajuan -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Data dari PHP ke JavaScript
        const monthlyData = @json($monthlyStats);

        // Persiapkan data untuk chart
        const labels = monthlyData.map(item => item.label);
        const kunjunganData = monthlyData.map(item => item.kunjungan_visit);
        const ruanganData = monthlyData.map(item => item.peminjaman_ruangan);

        // Data untuk room chart
        const roomData = @json($popularRoom);
        const roomCounts = roomData.map(item => item.jumlah_peminjaman);
        const roomLabels = roomData.map(item => item.nama_ruangan);
        const bgColors = ['#4e73df','#1cc88a','#36b9cc','#f6c23e','#e74a3b','#858796'];

        // Pastikan DOM sudah siap sebelum menginisialisasi chart
        document.addEventListener('DOMContentLoaded', function() {
            // Cek apakah elemen canvas ada
            const lineChartElement = document.getElementById('lineChart');
            const roomChartElement = document.getElementById('roomChart');
            
            // Inisialisasi line chart jika elemennya ada
            if (lineChartElement) {
                const lineCtx = lineChartElement.getContext('2d');
                const lineChart = new Chart(lineCtx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Kunjungan Visit',
                                data: kunjunganData,
                                borderColor: '#FF6B35',
                                backgroundColor: 'rgba(255, 107, 53, 0.05)',
                                borderWidth: 3,
                                pointBackgroundColor: '#FF6B35',
                                pointRadius: 0,
                                pointHoverRadius: 5,
                                tension: 0.4,
                                fill: true
                            },
                            {
                                label: 'Ruangan',
                                data: ruanganData,
                                borderColor: '#3b7ddd',
                                backgroundColor: 'rgba(59, 125, 221, 0.05)',
                                borderWidth: 3,
                                pointBackgroundColor: '#3b7ddd',
                                pointRadius: 0,
                                pointHoverRadius: 5,
                                borderDash: [5, 5],
                                tension: 0.4,
                                fill: true
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top'
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: { drawBorder: false },
                                ticks: { stepSize: 10 }
                            },
                            x: {
                                grid: { display: false }
                            }
                        }
                    }
                });
            } else {
                console.error('Element with ID "lineChart" not found');
            }
            
            // Inisialisasi room chart jika elemennya ada
            if (roomChartElement) {
                const roomCtx = roomChartElement.getContext('2d');
                const roomChart = new Chart(roomCtx, {
                    type: 'doughnut',
                    data: {
                        labels: roomLabels,
                        datasets: [{
                            data: roomCounts,
                            backgroundColor: bgColors,
                            borderWidth: 0,
                            hoverOffset: 8,
                            borderRadius: 10,
                            spacing: 5,
                            offset: 5
                        }]
                    },
                    options: {
                        cutout: '70%',
                        radius: '90%',
                        plugins: {
                            legend: { display: false },
                            tooltip: { enabled: true },
                        },
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });
            } else {
                console.error('Element with ID "roomChart" not found');
            }
        });
    </script>

        
     
        
    <!-- Your existing chart initialization scripts -->
    @endpush
    @endsection

    @push('styles')
    <style>

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

        .activity-table th {
            background-color: #f8f9fa;
            font-weight: 600;
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

   

    <!-- Add this before </head> -->
    <script>
        // Add dropdown functionality
        document.querySelectorAll('.dropdown-trigger').forEach(trigger => {
            trigger.addEventListener('click', function() {
                const menuGroup = this.closest('.menu-group');
                menuGroup.classList.toggle('active');
            });
        });
    </script>

    <!-- Update these styles in your existing stylesheet -->
    <style>
        .dropdown-trigger {
            cursor: pointer;
        }

        .menu-group {
            margin: 5px 0;
        }

        .submenu {
            margin-left: 20px;
            display: none;
            transition: all 0.3s ease;
        }

        .menu-group.active .submenu {
            display: block;
        }

        .menu-group.active .fa-chevron-down {
            transform: rotate(180deg);
        }
    </style>

</html>
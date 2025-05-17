@extends('layouts.app')

@section('content')
<div class="dashboard-container mt-5">
    <div class="slider-container">
        <div class="slider">
            <div class="slide">
                <img src="{{ asset('images/baner/banner1.jpg') }}" alt="Banner 1">
            </div>
            <div class="slide">
                <img src="{{ asset('images/baner/banner2.jpg') }}" alt="Banner 2">
            </div>
            <div class="slide">
                <img src="{{ asset('images/baner/banner3.jpg') }}" alt="Banner 3">
            </div>
        </div>
        <div class="slider-nav">
            <div class="slider-dot active"></div>
            <div class="slider-dot"></div>
            <div class="slider-dot"></div>
        </div>
    </div>

    <!-- Add this to your existing style section -->
    <style>
    .slider {
        display: flex;
        transition: transform 0.5s ease-in-out;
    }

    .slide {
        min-width: 100%;
        position: relative;
    }

    .slider-nav {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 8px;
        z-index: 10;
    }

    .slider-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .slider-dot.active {
        background: white;
        transform: scale(1.2);
    }
    </style>

    <!-- Add this script at the end of your content section -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const slider = document.querySelector('.slider');
        const dots = document.querySelectorAll('.slider-dot');
        let currentSlide = 0;
        const slideCount = dots.length;

        function updateSlider() {
            slider.style.transform = `translateX(-${currentSlide * 100}%)`;
            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === currentSlide);
            });
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % slideCount;
            updateSlider();
        }

        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                currentSlide = index;
                updateSlider();
            });
        });

        setInterval(nextSlide, 5000); // Change slide every 5 seconds
    });
    </script>

    <div class="section-title">Status Pengajuan</div>
    <div class="status-cards">
        <div class="status-card">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <p class="mb-0">Disetujui</p>
                <i class="fas fa-arrow-right text-primary"></i>
            </div>
            <h2 class="text-primary">{{ $approvedCount }}</h2>
        </div>
        <div class="status-card">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <p class="mb-0">Ditolak</p>
                <i class="fas fa-arrow-right text-primary"></i>
            </div>
            <h2 class="text-primary">{{ $rejectedCount }}</h2>
        </div>
        <div class="status-card">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <p class="mb-0">Menunggu</p>
                <i class="fas fa-arrow-right text-primary"></i>
            </div>
            <h2 class="text-primary">{{ $pendingCount }}</h2>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-5 mb-4">
        <div class="section-title mb-0">Event Terdekat</div>
        <a href="#" class="text-primary text-decoration-none">Lihat semua</a>
    </div>
    
    <div class="event-list">
        @forelse($upcomingEvents as $event)
        <div class="event-card">
            <img src="{{ asset('storage/images/events/' . $event->poster) }}" alt="{{ $event->nama_event }}">
            <div class="content p-3">
                <h5 class="title mb-3">{{ $event->nama_event }}</h5>
                <div class="d-flex align-items-center mb-2">
                    <i class="far fa-calendar-alt me-2 text-primary"></i>
                    <span>{{ \Carbon\Carbon::parse($event->tanggal_pelaksanaan)->format('d M Y') }}</span>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <i class="far fa-clock me-2 text-primary"></i>
                    <span>{{ $event->waktu }}</span>
                </div>
                <div class="d-flex align-items-center">
                    <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                    <span>{{ $event->lokasi_ruangan }}</span>
                </div>
                <a href="#" class="btn btn-outline-primary btn-sm mt-3 w-100">Workshop</a>
            </div>
        </div>
        @empty
        <div class="text-center">
            <p>Tidak ada event terdekat saat ini.</p>
        </div>
        @endforelse
    </div>
</div>

<style>
.dashboard-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 1rem;
}

.slider-container {
    position: relative;
    overflow: hidden;
    border-radius: 12px;
    margin-bottom: 2.5rem;
}

.slide img {
    width: 100%;
    height: 300px;
    object-fit: cover;
    border-radius: 12px;
}

.status-cards {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.status-card {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.status-card h2 {
    font-size: 2rem;
    margin: 0;
}

.event-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
}

.event-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.event-card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.event-card .title {
    font-weight: 600;
    color: #333;
}

.section-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #333;
}

.text-primary {
    color: #0041C2 !important;
}

.btn-outline-primary {
    color: #0041C2;
    border-color: #0041C2;
}

.btn-outline-primary:hover {
    background-color: #0041C2;
    color: white;
}
</style>
@endsection
@extends('layouts.app')

@section('content')
<div class="container profile-page">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Profile</li>
        </ol>
    </nav>

    {{-- Header --}}
    <div class="profile-header text-center mb-5">
        <h1>Edit Profile</h1>
        <p>Perbarui informasi akun dan ubah kata sandi Anda di halaman ini.</p>
    </div>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Form Section --}}
    <div class="row justify-content-center g-4">
        <div class="col-md-8">
            {{-- Edit Profile --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-semibold mb-4">Edit Profil</h5>
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="text-center mb-4">
                            <img src="{{ asset(auth()->user()->photo ?? 'images/avatar/default.jpg') }}" 
                                class="rounded-circle mb-3 shadow-sm" 
                                style="width: 150px; height: 150px; object-fit: cover;" 
                                id="preview-photo" alt="Profile Photo">

                            <div>
                                <label class="btn btn-outline-primary btn-sm">
                                    Ganti Foto
                                    <input type="file" name="photo" class="d-none" accept="image/*" onchange="previewImage(this)">
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                name="name" value="{{ old('name', auth()->user()->name) }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                name="email" value="{{ old('email', auth()->user()->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Change Password --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="fw-semibold mb-4">Ubah Password</h5>
                    <form action="{{ route('profile.update.password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Password Saat Ini</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                name="current_password">
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password Baru</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                name="password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" name="password_confirmation">
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary px-4">Ubah Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Preview Foto --}}
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-photo').setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<style>
/* ======== Struktur & Padding ======== */
.container.profile-page {
    margin-top: 100px !important;
    margin-bottom: 80px;
    max-width: 1200px;
}

/* ======== Breadcrumb ======== */
.breadcrumb {
    margin-bottom: 2rem;
    background-color: transparent;
    padding: 0;
}

.breadcrumb a {
    color: #0041C2;
    text-decoration: none;
    font-weight: 500;
}

.breadcrumb a:hover {
    text-decoration: underline;
}

/* ======== Header ======== */
.profile-header h1 {
    font-size: 32px;
    color: #1a1a1a;
    margin-bottom: 16px;
}

.profile-header p {
    color: #666;
    line-height: 1.6;
}

/* ======== Card ======== */
.card {
    border-radius: 12px;
    transition: all 0.2s ease;
}

.card:hover {
    box-shadow: 0 6px 16px rgba(0,0,0,0.08);
}

/* ======== Button ======== */
.btn-primary {
    background-color: #0041C2;
    border: none;
    border-radius: 6px;
    font-weight: 500;
    transition: all 0.2s ease;
}

.btn-primary:hover {
    background-color: #003399;
}

.btn-outline-primary {
    border-color: #0041C2;
    color: #0041C2;
    border-radius: 6px;
    font-weight: 500;
}

.btn-outline-primary:hover {
    background-color: #0041C2;
    color: #fff;
}
</style>
@endsection

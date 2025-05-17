@extends('layouts.admin')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <a href="{{ route('admin.list-user.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="user-profile-card">
        <div class="profile-header">
            <div class="profile-image">
                @if($user->photo)
                    <img src="{{ Storage::url($user->photo) }}" alt="{{ $user->name }}">
                @else
                    <div class="default-avatar">{{ substr($user->name, 0, 1) }}</div>
                @endif
            </div>
            <div class="profile-info">
                <h1>{{ $user->name }}</h1>
                <p class="email">{{ $user->email }}</p>
                <!-- <span class="status-badge {{ $user->last_login_at && $user->last_login_at->diffInDays() < 30 ? 'active' : 'inactive' }}">
                    {{ $user->last_login_at && $user->last_login_at->diffInDays() < 30 ? 'Aktif' : 'Tidak Aktif' }}
                </span> -->
            </div>
        </div>

        <div class="profile-details">
            <div class="detail-item">
                <span class="label">Terakhir Login</span>
                <span class="value">{{ $user->last_login_at ? $user->last_login_at->format('d M Y H:i') : 'Belum Pernah Login' }}</span>
            </div>
            <div class="detail-item">
                <span class="label">Bergabung Sejak</span>
                <span class="value">{{ $user->created_at->format('d M Y') }}</span>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.content-wrapper {
    padding: 24px;
    background: #f1f5f9;
    min-height: 100vh;
}

.user-profile-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    overflow: hidden;
}

.profile-header {
    padding: 32px;
    display: flex;
    align-items: center;
    gap: 24px;
    border-bottom: 1px solid #e2e8f0;
}

.profile-image {
    width: 120px;
    height: 120px;
    border-radius: 60px;
    overflow: hidden;
}

.profile-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.default-avatar {
    width: 100%;
    height: 100%;
    background: #3b82f6;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 48px;
    font-weight: bold;
}

.profile-info h1 {
    font-size: 24px;
    color: #1e293b;
    margin-bottom: 8px;
}

.profile-info .email {
    color: #64748b;
    margin-bottom: 16px;
}

.status-badge {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 500;
}

.status-badge.active {
    background: #dcfce7;
    color: #166534;
}

.status-badge.inactive {
    background: #fee2e2;
    color: #991b1b;
}

.profile-details {
    padding: 32px;
}

.detail-item {
    margin-bottom: 20px;
}

.detail-item .label {
    display: block;
    color: #64748b;
    font-size: 14px;
    margin-bottom: 4px;
}

.detail-item .value {
    color: #1e293b;
    font-size: 16px;
    font-weight: 500;
}

/* Add these new styles */
.page-header {
    margin-bottom: 24px;
}

.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    color: #64748b;
    text-decoration: none;
    font-size: 14px;
    transition: all 0.2s;
}

.btn-back:hover {
    background: #f8fafc;
    color: #1e293b;
}
</style>
@endpush
@endsection
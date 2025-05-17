@extends('layouts.admin')

@section('content')
<div class="main-content">
    <div class="modal-overlay">
        <div class="modal-container">
            <div class="modal-header">
                <h2>Edit Ruangan</h2>
                <a href="{{ route('admin.kelola.ruangan.index') }}" class="close-btn">
                    <i class="fas fa-times"></i>
                </a>
            </div>

            <div class="modal-body">
                <form action="{{ route('admin.kelola.ruangan.update', $ruangan->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-section">
                        <h3>Informasi Umum</h3>
                        
                        <div class="form-group-row">
                            <div class="form-group">
                                <label for="nama_ruangan">Nama Ruangan</label>
                                <input type="text" id="nama_ruangan" name="nama_ruangan" value="{{ $ruangan->nama_ruangan }}" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="kapasitas">Kapasitas</label>
                                <input type="number" id="kapasitas" name="kapasitas" value="{{ $ruangan->kapasitas }}" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group-row">
                            <div class="form-group">
                                <label for="lokasi">Lokasi</label>
                                <input type="text" id="lokasi" name="lokasi" value="{{ $ruangan->lokasi }}" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="fasilitas">Fasilitas</label>
                                <input type="text" id="fasilitas" name="fasilitas" value="{{ $ruangan->fasilitas }}" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="jam_operasional">Jam Operasional</label>
                            <input type="text" id="jam_operasional" name="jam_operasional" value="{{ $ruangan->jam_operasional }}" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3>Sesi Ruangan</h3>

                        @foreach ($ruangan->sesi as $index => $sesi)
                        <div class="border p-3 mb-3 rounded sesi-wrapper bg-light">
                            <h6>Sesi {{ $loop->iteration }}</h6>

                            <div class="form-group">
                                <label>Nama Sesi</label>
                                <input type="text" name="sesi[{{ $index }}][nama_sesi]" class="form-control"
                                    value="{{ old("sesi.$index.nama_sesi", $sesi->nama_sesi) }}" placeholder="Contoh: Sesi Pagi">
                            </div>

                            <div class="form-group">
                                <label>Jam Mulai</label>
                                <input type="time" name="sesi[{{ $index }}][jam_mulai]" class="form-control"
                                    value="{{ old("sesi.$index.jam_mulai", $sesi->jam_mulai) }}">
                            </div>

                            <div class="form-group">
                                <label>Jam Selesai</label>
                                <input type="time" name="sesi[{{ $index }}][jam_selesai]" class="form-control"
                                    value="{{ old("sesi.$index.jam_selesai", $sesi->jam_selesai) }}">
                            </div>

                            <input type="hidden" name="sesi[{{ $index }}][id]" value="{{ $sesi->id }}">
                        </div>
                        @endforeach
                    </div>

                    <div class="form-section">
                        <h3>Foto Ruangan</h3>
                        <div class="image-preview">
                            @if($ruangan->gambar)
                                <img src="{{ asset($ruangan->gambar) }}" alt="Preview" id="imagePreview">
                            @else
                                <div class="no-image">Tidak ada gambar</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="gambar" class="custom-file-upload">
                                <i class="fas fa-cloud-upload-alt"></i> Pilih Foto
                            </label>
                            <input type="file" id="gambar" name="gambar" accept="image/*" class="form-control-file" onchange="previewImage(this)">
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('admin.kelola.ruangan.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}

.modal-container {
    background: white;
    border-radius: 12px;
    width: 90%;
    max-width: 700px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.modal-header {
    padding: 20px;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h2 {
    margin: 0;
    font-size: 1.5rem;
    color: #1f2937;
}

.close-btn {
    background: none;
    border: none;
    color: #6b7280;
    cursor: pointer;
    font-size: 1.25rem;
    padding: 4px;
}

.close-btn:hover {
    color: #1f2937;
}

.modal-body {
    padding: 20px;
}

.form-section {
    margin-bottom: 24px;
}

.form-section h3 {
    font-size: 1.1rem;
    color: #374151;
    margin-bottom: 16px;
}

.form-group-row {
    display: flex;
    gap: 20px;
    margin-bottom: 16px;
}

.form-group {
    flex: 1;
    margin-bottom: 16px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    color: #4b5563;
    font-size: 0.9rem;
}

.form-control {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 0.95rem;
}

.form-control:focus {
    border-color: #3b82f6;
    outline: none;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.image-preview {
    width: 100%;
    height: 200px;
    border: 2px dashed #d1d5db;
    border-radius: 8px;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.image-preview img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

.no-image {
    color: #6b7280;
    font-size: 0.9rem;
}

.custom-file-upload {
    display: inline-block;
    padding: 8px 16px;
    background: #f3f4f6;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    cursor: pointer;
    color: #4b5563;
    font-size: 0.9rem;
}

.custom-file-upload:hover {
    background: #e5e7eb;
}

input[type="file"] {
    display: none;
}

.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    margin-top: 24px;
    padding-top: 20px;
    border-top: 1px solid #e5e7eb;
}

.btn {
    padding: 8px 16px;
    border-radius: 6px;
    font-size: 0.95rem;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-secondary {
    background: white;
    border: 1px solid #d1d5db;
    color: #4b5563;
}

.btn-secondary:hover {
    background: #f3f4f6;
}

.btn-primary {
    background: #3b82f6;
    border: none;
    color: white;
}

.btn-primary:hover {
    background: #2563eb;
}

/* Success Notification */
.success-notification {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 16px 24px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    display: flex;
    align-items: center;
    gap: 12px;
    z-index: 1100;
    animation: slideIn 0.3s ease-out;
}

.success-icon {
    color: #10b981;
    font-size: 1.25rem;
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
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const file = input.files[0];
    const reader = new FileReader();

    reader.onloadend = function() {
        preview.src = reader.result;
    }

    if (file) {
        reader.readAsDataURL(file);
        preview.style.display = 'block';
    }
}

// Show success notification if exists in session
@if(session('success'))
    const notification = document.createElement('div');
    notification.className = 'success-notification';
    notification.innerHTML = `
        <i class="fas fa-check-circle success-icon"></i>
        <span>{{ session('success') }}</span>
    `;
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.remove();
    }, 3000);
@endif
</script>
@endsection
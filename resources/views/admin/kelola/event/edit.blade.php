@extends('layouts.admin')

@section('content')
<div class="main-content">
    <div class="modal-overlay">
        <div class="modal-container">
            <div class="modal-header">
                <h2>Edit Event</h2>
                <a href="{{ route('admin.kelola.event.index') }}" class="close-btn">
                    <i class="fas fa-times"></i>
                </a>
            </div>

            <div class="modal-body">
                <form action="{{ route('admin.kelola.event.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-section">
                        <h3>Informasi Umum</h3>
                        
                        <div class="form-group">
                            <label for="nama_event">Nama Event</label>
                            <input type="text" id="nama_event" name="nama_event" value="{{ $event->nama_event }}" required>
                        </div>

                        <div class="form-group">
                            <label for="penyelenggara">Penyelenggara</label>
                            <input type="text" id="penyelenggara" name="penyelenggara" value="{{ $event->penyelenggara }}" required>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="tanggal">Tanggal Pelaksanaan</label>
                                <input type="date" id="tanggal" name="tanggal" value="{{ $event->tanggal }}" required>
                            </div>

                            <div class="form-group">
                                <label for="waktu">Waktu</label>
                                <input type="time" id="waktu" name="waktu" value="{{ $event->waktu }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="lokasi_ruangan">Lokasi Ruangan</label>
                            <input type="text" id="lokasi_ruangan" name="lokasi_ruangan" value="{{ $event->lokasi_ruangan }}" required>
                        </div>

                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea id="deskripsi" name="deskripsi" rows="4">{{ $event->deskripsi }}</textarea>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3>Poster Event</h3>
                        <div class="poster-upload">
                            <div class="current-poster">
                                @if($event->image)
                                    <img src="{{ asset('storage/' . $event->image) }}" alt="Event Poster" id="posterPreview">
                                @else
                                    <div class="no-poster">
                                        <i class="fas fa-image"></i>
                                        <span>Belum ada poster</span>
                                    </div>
                                @endif
                            </div>
                            <div class="upload-controls">
                                <label for="image" class="upload-btn">
                                    <i class="fas fa-upload"></i>
                                    Upload Poster
                                </label>
                                <input type="file" id="image" name="image" accept="image/*" class="hidden-input" onchange="previewPoster(this)">
                                <p class="upload-hint">Format: JPG, PNG (Max. 2MB)</p>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('admin.kelola.event.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
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
    justify-content: center;
    align-items: start;
    padding: 40px;
    z-index: 1000;
}

.modal-container {
    background: white;
    border-radius: 12px;
    width: 100%;
    max-width: 800px;
    max-height: calc(100vh - 80px);
    overflow-y: auto;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    border-bottom: 1px solid #e5e7eb;
}

.modal-header h2 {
    font-size: 1.5rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
}

.close-btn {
    background: none;
    border: none;
    color: #6b7280;
    cursor: pointer;
    padding: 8px;
    border-radius: 6px;
    transition: all 0.2s;
}

.close-btn:hover {
    background: #f3f4f6;
    color: #1f2937;
}

.modal-body {
    padding: 24px;
}

.form-section {
    margin-bottom: 32px;
}

.form-section h3 {
    font-size: 1.1rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 16px;
}

.form-group {
    margin-bottom: 20px;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

label {
    display: block;
    font-size: 0.875rem;
    font-weight: 500;
    color: #374151;
    margin-bottom: 8px;
}

input[type="text"],
input[type="date"],
input[type="time"],
textarea {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 0.875rem;
    transition: all 0.3s;
}

input:focus,
textarea:focus {
    border-color: #0041C2;
    box-shadow: 0 0 0 3px rgba(0, 65, 194, 0.1);
    outline: none;
}

.poster-upload {
    border: 2px dashed #e5e7eb;
    border-radius: 12px;
    padding: 24px;
    background: #f8fafc;
    text-align: center;
}

.current-poster {
    margin-bottom: 20px;
    background: white;
    border-radius: 8px;
    padding: 16px;
    min-height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.current-poster img {
    max-width: 100%;
    max-height: 300px;
    object-fit: contain;
}

.no-poster {
    color: #94a3b8;
    text-align: center;
}

.no-poster i {
    font-size: 48px;
    margin-bottom: 12px;
}

.upload-controls {
    margin-top: 16px;
}

.upload-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #0041C2;
    color: white;
    padding: 10px 20px;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s;
}

.upload-btn:hover {
    background: #003399;
}

.upload-hint {
    margin-top: 8px;
    font-size: 0.875rem;
    color: #6b7280;
}

.hidden-input {
    display: none;
}

.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    margin-top: 32px;
    padding-top: 20px;
    border-top: 1px solid #e5e7eb;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-primary {
    background: #0041C2;
    color: white;
    border: none;
}

.btn-primary:hover {
    background: #003399;
}

.btn-secondary {
    background: white;
    color: #6b7280;
    border: 1px solid #e5e7eb;
    text-decoration: none;
}

.btn-secondary:hover {
    border-color: #d1d5db;
    color: #374151;
}
</style>

<script>
function previewPoster(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            let preview = document.getElementById('posterPreview');
            if (!preview) {
                preview = document.createElement('img');
                preview.id = 'posterPreview';
                const currentPoster = document.querySelector('.current-poster');
                currentPoster.innerHTML = '';
                currentPoster.appendChild(preview);
            }
            preview.src = e.target.result;
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
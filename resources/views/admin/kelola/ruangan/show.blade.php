@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="top-bar">
            <div class="page-title">
                <h2>Detail Ruangan</h2>
                <p class="breadcrumb">
                    <a href="{{ route('admin.kelola.ruangan.index') }}">Kelola Ruangan</a> / Detail
                </p>
            </div>
            <div class="admin-info">
                <span>Admin: {{ Auth::user()->name }}</span>
                <a href="{{ route('admin.kelola.ruangan.index') }}" class="back-btn">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <div class="room-detail-card">
            <div class="room-header">
                <h3>{{ $ruangan->nama_ruangan }}</h3>
                <div class="room-actions">
                    
                </div>
            </div>

            <!-- Add this modal at the bottom of the container div -->
            <div id="editModal" class="modal" style="display: none;">
                <div class="modal-content">
                   
                    <form action="{{ route('admin.kelola.ruangan.update', $ruangan->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Nama Ruangan</label>
                            <input type="text" name="nama_ruangan" value="{{ $ruangan->nama_ruangan }}" required>
                        </div>
                        <div class="form-group">
                            <label>Kapasitas</label>
                            <input type="number" name="kapasitas" value="{{ $ruangan->kapasitas }}" required>
                        </div>
                        <div class="form-group">
                            <label>Lokasi</label>
                            <select name="lokasi" required>
                                <option value="Lantai 1" {{ $ruangan->lokasi == 'Lantai 1' ? 'selected' : '' }}>Lantai 1</option>
                                <option value="Lantai 2" {{ $ruangan->lokasi == 'Lantai 2' ? 'selected' : '' }}>Lantai 2</option>
                                <option value="Lantai 4" {{ $ruangan->lokasi == 'Lantai 4' ? 'selected' : '' }}>Lantai 4</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Fasilitas</label>
                            <textarea name="fasilitas" required>{{ $ruangan->fasilitas }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Jam Operasional</label>
                            <input type="text" name="jam_operasional" value="{{ $ruangan->jam_operasional }}" required>
                        </div>
                        <div class="form-group">
                            <label>Gambar</label>
                            <input type="file" name="gambar" accept="image/*">
                            <small>Biarkan kosong jika tidak ingin mengubah gambar</small>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn-cancel" onclick="closeEditModal()">Batal</button>
                            <button type="submit" class="btn-save">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Add this script before closing body tag -->
            <script>
                function openEditModal() {
                    document.getElementById('editModal').style.display = 'flex';
                }

                function closeEditModal() {
                    document.getElementById('editModal').style.display = 'none';
                }
            </script>

            <!-- Add these styles -->
            <style>
                .modal {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(0, 0, 0, 0.5);
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    z-index: 1000;
                }

                .modal-content {
                    background: white;
                    padding: 2rem;
                    border-radius: 12px;
                    width: 100%;
                    max-width: 600px;
                    max-height: 90vh;
                    overflow-y: auto;
                }

                .modal-header {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    margin-bottom: 1.5rem;
                }

                .close-btn {
                    background: none;
                    border: none;
                    font-size: 1.5rem;
                    cursor: pointer;
                    color: #666;
                }

                .form-group {
                    margin-bottom: 1rem;
                }

                .form-group label {
                    display: block;
                    margin-bottom: 0.5rem;
                    font-weight: 500;
                }

                .form-group input,
                .form-group select,
                .form-group textarea {
                    width: 100%;
                    padding: 0.5rem;
                    border: 1px solid #ddd;
                    border-radius: 6px;
                    font-size: 1rem;
                }

                .form-group textarea {
                    height: 100px;
                    resize: vertical;
                }

                .form-actions {
                    display: flex;
                    justify-content: flex-end;
                    gap: 1rem;
                    margin-top: 2rem;
                }

                .btn-cancel {
                    padding: 0.5rem 1rem;
                    border: 1px solid #ddd;
                    border-radius: 6px;
                    background: white;
                    cursor: pointer;
                }

                .btn-save {
                    padding: 0.5rem 1rem;
                    border: none;
                    border-radius: 6px;
                    background: #3182ce;
                    color: white;
                    cursor: pointer;
                }

                .btn-save:hover {
                    background: #2c5282;
                }
            </style>
            <div class="room-image">
                @if($ruangan->gambar)
                    <img src="{{ asset('images/ruangan/' . $ruangan->gambar) }}" alt="{{ $ruangan->nama_ruangan }}">
                @else
                    <div class="no-image">
                        <i class="fas fa-image"></i>
                        <p>Tidak ada gambar</p>
                    </div>
                @endif
            </div>
            
            <div class="room-info">
                <div class="info-item">
                    <i class="fas fa-users info-icon"></i>
                    <div class="info-content">
                        <label>Kapasitas</label>
                        <span>{{ $ruangan->kapasitas }} orang</span>
                    </div>
                </div>
                
                <div class="info-item">
                    <i class="fas fa-map-marker-alt info-icon"></i>
                    <div class="info-content">
                        <label>Lokasi</label>
                        <span>{{ $ruangan->lokasi }}</span>
                    </div>
                </div>
                
                <div class="info-item">
                    <i class="fas fa-tools info-icon"></i>
                    <div class="info-content">
                        <label>Fasilitas</label>
                        <span>{{ $ruangan->fasilitas }}</span>
                    </div>
                </div>
                
                <div class="info-item">
                    <i class="fas fa-clock info-icon"></i>
                    <div class="info-content">
                        <label>Jam Operasional</label>
                        <span>{{ $ruangan->jam_operasional }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background: #f0f2f5;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .top-bar {
            background: white;
            padding: 1.5rem 2rem;
            border-radius: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .page-title h2 {
            margin: 0;
            font-size: 1.5rem;
            color: #2d3748;
        }

        .breadcrumb {
            margin: 0.5rem 0 0;
            font-size: 0.875rem;
            color: #718096;
        }

        .breadcrumb a {
            color: #4a5568;
            text-decoration: none;
        }

        .breadcrumb a:hover {
            color: #2d3748;
        }

        .admin-info {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .back-btn {
            background: #f7fafc;
            color: #4a5568;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s;
        }

        .back-btn:hover {
            background: #edf2f7;
            color: #2d3748;
        }

        .room-detail-card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .room-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .room-header h3 {
            margin: 0;
            font-size: 1.25rem;
            color: #2d3748;
        }

        .btn-edit {
            background: #ebf4ff;
            color: #3182ce;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s;
        }

        .btn-edit:hover {
            background: #bee3f8;
        }

        .room-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .info-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }

        .info-icon {
            font-size: 1.25rem;
            color: #4299e1;
            padding: 0.75rem;
            background: #ebf8ff;
            border-radius: 8px;
        }

        .info-content {
            flex: 1;
        }

        .info-content label {
            display: block;
            font-size: 0.875rem;
            color: #718096;
            margin-bottom: 0.25rem;
        }

        .info-content span {
            font-size: 1rem;
            color: #2d3748;
            font-weight: 500;
        }

        .room-image {
            margin: -1rem -2rem 2rem;
            height: 300px;
            position: relative;
            overflow: hidden;
            background: #f7fafc;
        }

        .room-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .no-image {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #a0aec0;
        }

        .no-image i {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .no-image p {
            margin: 0;
            font-size: 0.875rem;
        }
    </style>
@endsection
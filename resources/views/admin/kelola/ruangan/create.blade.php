@extends('layouts.admin')

@section('content')
<div class="contents">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <a href="{{ route('admin.kelola.ruangan.index') }}" class="btn btn-light">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="create-form-card">
        @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.kelola.ruangan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="content-header">
                <div class="breadcrumb">
                    <h4 class="mb-0">Tambah Event</h4>
                </div>
                <div class="header-actions">
                    <x-button.tertiary title="Cancel" onclick="history.back()"></x-button.secondary>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save
                    </button>
                    <x-button.primary type="submit" title="Save"></x-button.primary>
                    
                </div>
            </div>
            <div class="form-container">
                <div class="section">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Nama Ruangan</label>
                            <input type="text" name="nama_ruangan" class="form-control @error('nama_ruangan') is-invalid @enderror" 
                                   value="{{ old('nama_ruangan') }}" required placeholder="Masukkan nama ruangan">
                            @error('nama_ruangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
        
                        <div class="form-group">
                            <label>Kapasitas</label>
                            <input type="number" name="kapasitas" class="form-control @error('kapasitas') is-invalid @enderror" 
                                   value="{{ old('kapasitas') }}" required placeholder="Jumlah orang">
                            @error('kapasitas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
        
                        <div class="form-group">
                            <label>Lokasi</label>
                            <select name="lokasi" class="form-control @error('lokasi') is-invalid @enderror" required>
                                <option value="" disabled {{ old('lokasi') ? '' : 'selected' }}>Pilih lokasi</option>
                                <option value="Lantai 1" {{ old('lokasi') == 'Lantai 1' ? 'selected' : '' }}>Lantai 1</option>
                                <option value="Lantai 2" {{ old('lokasi') == 'Lantai 2' ? 'selected' : '' }}>Lantai 2</option>
                                <option value="Lantai 3" {{ old('lokasi') == 'Lantai 3' ? 'selected' : '' }}>Lantai 3</option>
                                <option value="Lantai 4" {{ old('lokasi') == 'Lantai 4' ? 'selected' : '' }}>Lantai 4</option>
                                <option value="Lantai 5" {{ old('lokasi') == 'Lantai 5' ? 'selected' : '' }}>Lantai 5</option>
                            </select>
                            @error('lokasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
        
                        <div class="form-group">
                            <label>Jam Operasional</label>
                            <input type="text" name="jam_operasional" class="form-control @error('jam_operasional') is-invalid @enderror" 
                                   value="{{ old('jam_operasional') }}" required placeholder="Contoh: 08:00 - 17:00">
                            @error('jam_operasional')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group span-full">
                            <h5 class="mb-3 d-flex justify-content-between align-items-center">
                                Sesi Ruangan
                                <button type="button" id="add-sesi-btn" class="btn btn-sm btn-success">
                                    <i class="fas fa-plus"></i> Tambah Sesi
                                </button>
                            </h5>
                            @for ($i = 0; $i < 3; $i++)
                            <div class="border p-3 mb-3 rounded sesi-wrapper bg-light sesi-input" id="sesi-{{ $i }}" style="{{ $i === 0 ? '' : 'display: none;' }}">
                                <h6>Sesi {{ $i + 1 }}</h6>
                                <div class="form-group">
                                    <div class="input-form">
                                        <label>Jam Mulai</label>
                                        <input type="time" name="sesi[{{ $i }}][jam_mulai]" class="form-control"
                                            value="{{ old("sesi.$i.jam_mulai") }}">
                                        <label>Jam Selesai</label>
                                        <input type="time" name="sesi[{{ $i }}][jam_selesai]" class="form-control"
                                            value="{{ old("sesi.$i.jam_selesai") }}">
                                    </div>
                                </div>

                            </div>
                            @endfor
                        </div>

        
                        <div class="form-group span-full">
                            <label>Fasilitas</label>
                            <textarea name="fasilitas" class="form-control @error('fasilitas') is-invalid @enderror" 
                                      required placeholder="Deskripsi fasilitas ruangan">{{ old('fasilitas') }}</textarea>
                            @error('fasilitas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
        
                        <div class="form-group span-full">
                            <label>Gambar Ruangan</label>
                            <div class="file-input-wrapper">
                                <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror" 
                                       accept="image/*" required>
                                <p class="file-help">Format: JPG, PNG (Max. 2MB)</p>
                                @error('gambar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.kelola.ruangan.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .contents {
        padding: 24px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .divider {
        border: none;
        border-top: 1px solid #e2e8f0;
        margin: 24px 0;
    }

    .content-header {
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 32px;
    }

    .card-header a{
        color: #0041C2;
        text-decoration: none;
        gap:1rem;   
    }

    .section {
    margin-bottom: 32px;
    }

    .section-title {
        font-size: 18px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 16px;
    }

    .section-desc {
        font-size: 14px;
        color: #64748b;
        margin-bottom: 16px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-bottom: 20px;
    }


    .top-bar {
        background: white;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .page-title h2 {
        margin: 0;
        font-size: 24px;
        color: #2d3748;
    }

    .breadcrumb {
        margin-top: 5px;
        font-size: 14px;
        color: #718096;
    }

    .breadcrumb a {
        color: #0041C2;
        text-decoration: none;
    }

    .create-form-card {
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .span-full {
        display: grid;
        grid-column: span 2;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #2d3748;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 14px;
        transition: border-color 0.2s;
    }

    .form-control:focus {
        outline: none;
        border-color: #0041C2;
        box-shadow: 0 0 0 3px rgba(0,65,194,0.1);
    }

    textarea.form-control {
        height: 120px;
        resize: vertical;
    }

    .file-input-wrapper {
        position: relative;
    }

    .file-help {
        margin-top: 5px;
        font-size: 12px;
        color: #718096;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 15px;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #e2e8f0;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-secondary {
        background: #f7fafc;
        color: #4a5568;
        border: 1px solid #e2e8f0;
        text-decoration: none;
    }

    .btn-secondary:hover {
        background: #edf2f7;
    }

    .btn-primary {
        background: #0041C2;
        color: white;
        border: none;
    }

    .btn-primary:hover {
        background: #003399;
    }

    /* Add new styles for error handling */
    .alert {
        padding: 16px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .alert-danger {
        background-color: #FEE2E2;
        border: 1px solid #F87171;
        color: #991B1B;
    }

    .invalid-feedback {
        color: #DC2626;
        font-size: 12px;
        margin-top: 4px;
    }

    .is-invalid {
        border-color: #DC2626 !important;
    }

    .is-invalid:focus {
        box-shadow: 0 0 0 3px rgba(220,38,38,0.1) !important;
    }

    #add-sesi-btn{
        margin-left: 120vh;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let currentVisible = 1; // sesi-0 sudah tampil
        const maxSesi = 3;

        document.getElementById('add-sesi-btn').addEventListener('click', function () {
            if (currentVisible < maxSesi) {
                const nextSesi = document.getElementById('sesi-' + currentVisible);
                if (nextSesi) {
                    nextSesi.style.display = 'block';
                    currentVisible++;
                }

                // Jika sudah maksimal, sembunyikan tombol tambah
                if (currentVisible >= maxSesi) {
                    this.style.display = 'none';
                }
            }
        });
    });
</script>
@endsection
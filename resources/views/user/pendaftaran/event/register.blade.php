@extends('layouts.app')

@section('content')
<div class="registration-header">
    <div class="container">
        <div class="text-center py-5">
            <h1 class="fw-bold">Pendaftaran Event</h1>
            <p class="text-muted">Lengkapi data diri Anda untuk mendaftar event</p>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-body p-5">
                    <form action="{{ route('pendaftaran.event.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="event_id" value="{{ $event_id }}">
                        
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" name="nama_lengkap" required>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Alamat Domisili</label>
                                    <textarea class="form-control" name="alamat" rows="3" required></textarea>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Nomor WhatsApp</label>
                                    <input type="tel" class="form-control" name="whatsapp" required>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Username Instagram</label>
                                    <div class="input-group">
                                        <span class="input-group-text">@</span>
                                        <input type="text" class="form-control" name="instagram" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Dapat Informasi Event Dari Mana?</label>
                                    <select class="form-select" name="info_source" required>
                                        <option value="">Pilih Sumber Informasi</option>
                                        <option value="Instagram">Instagram</option>
                                        <option value="Website">Website</option>
                                        <option value="Teman">Teman</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Upload Bukti Follow @creativehub.bdg</label>
                                    <input type="file" class="form-control" name="bukti_follow" accept="image/*" required>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Mengapa Tertarik Mengikuti Event Ini?</label>
                                    <textarea class="form-control" name="alasan" rows="4" required></textarea>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="agreement" required>
                                    <label class="form-check-label">
                                        Saya bersedia mengikuti seluruh rangkaian acara dan mematuhi peraturan yang berlaku
                                    </label>
                                </div>
                            </div>
                            
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-user-plus me-2"></i>Daftar Event
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.registration-header {
    background: linear-gradient(135deg, #0041C2, #0052cc);
    color: white;
    padding: 2rem 0;
    margin-top: 4rem;
}

.form-label {
    font-weight: 500;
    color: #333;
    margin-bottom: 0.5rem;
}

.form-control, .form-select {
    padding: 0.75rem 1rem;
    border-color: #e0e0e0;
    border-radius: 8px;
}

.form-control:focus, .form-select:focus {
    border-color: #0041C2;
    box-shadow: 0 0 0 0.2rem rgba(0,65,194,0.1);
}
</style>
@endsection
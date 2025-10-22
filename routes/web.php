<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\HomeController;

// Admin Controllers
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\KelolaEventController;
use App\Http\Controllers\Admin\KelolaRuanganController;
use App\Http\Controllers\Admin\VerifikasiPeminjamanController;
use App\Http\Controllers\Admin\VerifikasiKunjunganController;
use App\Http\Controllers\Admin\KerjaSamaEventController as AdminKerjaSamaEventController;
use App\Http\Controllers\Admin\MediaPartnerVerifikasiController;
use App\Http\Controllers\Admin\PendaftaranEventController as AdminPendaftaranEventController;
use App\Http\Controllers\Admin\ListUserController;
use App\Http\Controllers\Admin\SesiRuanganController;

// User Controllers
use App\Http\Controllers\User\RuanganController;
use App\Http\Controllers\User\PeminjamanRuanganController;
use App\Http\Controllers\User\PeminjamanEventController;
use App\Http\Controllers\User\KunjunganVisitController;
use App\Http\Controllers\User\MediaPartnerController;
use App\Http\Controllers\User\PendaftaranEventController;
use App\Http\Controllers\User\RiwayatController;
use App\Http\Controllers\User\KerjaSamaEventController as UserKerjaSamaEventController;
use App\Http\Controllers\User\UserProfileController;



/*
|--------------------------------------------------------------------------  
| Authentication Routes
|--------------------------------------------------------------------------  
*/
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Password Reset
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

/*
|--------------------------------------------------------------------------  
| Public Routes  
|--------------------------------------------------------------------------  
*/
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::resource('ruangan', RuanganController::class)->only(['index', 'show']);

/*
|--------------------------------------------------------------------------  
| Admin Routes  
|--------------------------------------------------------------------------  
*/
Route::prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/chart-data/{range}', [AdminController::class, 'getChartData']);


    // Kelola Ruangan
    Route::prefix('kelola/ruangan')->name('kelola.ruangan.')->group(function () {
        Route::get('/', [KelolaRuanganController::class, 'index'])->name('index');
        Route::get('/create', [KelolaRuanganController::class, 'create'])->name('create');
        Route::post('/', [KelolaRuanganController::class, 'store'])->name('store');
        Route::get('/show/{ruangan}', [KelolaRuanganController::class, 'show'])->name('show');
        Route::get('/{ruangan}/edit', [KelolaRuanganController::class, 'edit'])->name('edit');
        Route::put('/{ruangan}', [KelolaRuanganController::class, 'update'])->name('update');
        Route::delete('/{ruangan}', [KelolaRuanganController::class, 'destroy'])->name('destroy');
        Route::get('/export', [KelolaRuanganController::class, 'export'])->name('export');
        Route::get('/search', [KelolaRuanganController::class, 'search'])->name('search');
        Route::get('/{id}/sesi/create', [SesiRuanganController::class, 'create'])->name('sesi.create');
        Route::post('/{id}/sesi', [SesiRuanganController::class, 'store'])->name('sesi.store');
    });

    // List User
    Route::prefix('list-user')->name('list-user.')->group(function () {
        Route::get('/', [ListUserController::class, 'index'])->name('index');
        Route::get('/export', [ListUserController::class, 'export'])->name('export');
        Route::get('/{user}', [ListUserController::class, 'show'])->name('show');
    });

    // Kelola Event
    Route::prefix('kelola/event')->name('kelola.event.')->group(function () {
        Route::get('/', [KelolaEventController::class, 'index'])->name('index');
        Route::get('/create', [KelolaEventController::class, 'create'])->name('create');
        Route::post('/', [KelolaEventController::class, 'store'])->name('store');
        Route::get('/export', [KelolaEventController::class, 'export'])->name('export');
        Route::get('/{event}/edit', [KelolaEventController::class, 'edit'])->name('edit');
        Route::put('/{event}', [KelolaEventController::class, 'update'])->name('update');
        Route::delete('/{event}', [KelolaEventController::class, 'destroy'])->name('destroy');
    });

    // Kerjasama Event Management
    Route::prefix('kerjasama/event')->name('kerjasama.event.')->group(function () {
        Route::get('/', [AdminKerjaSamaEventController::class, 'index'])->name('index');
        Route::get('/create', [AdminKerjaSamaEventController::class, 'create'])->name('create');
        Route::post('/', [AdminKerjaSamaEventController::class, 'store'])->name('store');
        Route::get('/export', [AdminKerjaSamaEventController::class, 'export'])->name('export');
        Route::get('/{id}', [AdminKerjaSamaEventController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [AdminKerjaSamaEventController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AdminKerjaSamaEventController::class, 'update'])->name('update');
        Route::delete('/{id}', [AdminKerjaSamaEventController::class, 'destroy'])->name('destroy');
        Route::post('/bulk-action', [AdminKerjaSamaEventController::class, 'bulkAction'])->name('bulk_action');
        Route::post('/{id}/approve', [AdminKerjaSamaEventController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [AdminKerjaSamaEventController::class, 'reject'])->name('reject');
    });

    // Verifikasi
    Route::prefix('verifikasi')->name('verifikasi.')->group(function () {
        // Verifikasi Kunjungan
        Route::prefix('kunjungan')->name('kunjungan.')->group(function () {
            Route::get('/', [VerifikasiKunjunganController::class, 'index'])->name('index');
            Route::get('/export', [VerifikasiKunjunganController::class, 'export'])->name('export');
            Route::post('/{id}/approve', [VerifikasiKunjunganController::class, 'approve'])->name('approve');
            Route::post('/{id}/reject', [VerifikasiKunjunganController::class, 'reject'])->name('reject');
            Route::get('/{id}', [VerifikasiKunjunganController::class, 'show'])->name('show');
            Route::delete('/{id}', [VerifikasiKunjunganController::class, 'destroy'])->name('destroy');
            Route::get('/{id}/proposal', [VerifikasiKunjunganController::class, 'downloadProposal'])->name('proposal');
            Route::post('/bulk-action', [VerifikasiKunjunganController::class, 'bulkAction'])->name('bulk_action');
        });

        // Verifikasi Peminjaman
        Route::prefix('peminjaman')->name('peminjaman.')->group(function () {
            Route::get('/', [VerifikasiPeminjamanController::class, 'index'])->name('index');
            Route::post('/ruangan/store', [VerifikasiPeminjamanController::class, 'store'])->name('ruangan.store');
            Route::get('/create', [VerifikasiPeminjamanController::class, 'create'])->name('create');
            Route::post('/', [KelolaEventController::class, 'store'])->name('store');
            Route::get('/export', [VerifikasiPeminjamanController::class, 'export'])->name('export');
            Route::get('/import', [VerifikasiPeminjamanController::class, 'showImportForm'])->name('import');
            Route::get('/download-template', function () {
                return response()->download(public_path('templates/template_peminjaman.xlsx'));
            })->name('template.download');
            Route::post('/import', [VerifikasiPeminjamanController::class, 'import'])->name('import.store');
            Route::get('/filter', [VerifikasiPeminjamanController::class, 'filter'])->name('filter');
            Route::post('/{id}/approve', [VerifikasiPeminjamanController::class, 'approve'])->name('approve');
            Route::post('/{id}/reject', [VerifikasiPeminjamanController::class, 'reject'])->name('reject');
            Route::get('/{id}', [VerifikasiPeminjamanController::class, 'show'])->name('show');
        });
   

            // Tetap dalam grup mediapartner
        Route::prefix('mediapartner')->name('mediapartner.')->group(function () {
            Route::get('/', [MediaPartnerVerifikasiController::class, 'index'])->name('index');
            Route::get('/export', [MediaPartnerVerifikasiController::class, 'export'])->name('export');
            Route::post('/{id}/update', [MediaPartnerVerifikasiController::class, 'update'])->name('update');
            Route::get('/{id}', [MediaPartnerVerifikasiController::class, 'show'])->name('show');
            Route::post('/{id}/approve', [MediaPartnerVerifikasiController::class, 'approve'])->name('approve');
            Route::post('/{id}/reject', [MediaPartnerVerifikasiController::class, 'reject'])->name('reject'); // Ubah ke PUT
        });
    });
    
    // Pendaftaran Event Admin
    Route::prefix('pendaftaran/event')->name('pendaftaran.event.')->group(function () {
        Route::get('/', [AdminPendaftaranEventController::class, 'index'])->name('index');
        Route::get('/export', [AdminPendaftaranEventController::class, 'export'])->name('export');
        Route::get('/create', [AdminPendaftaranEventController::class, 'create'])->name('create');
        Route::post('/', [AdminPendaftaranEventController::class, 'store'])->name('store');
        Route::get('/{id}', [AdminPendaftaranEventController::class, 'show'])->name('show');
        Route::post('/{id}/approve', [AdminPendaftaranEventController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [AdminPendaftaranEventController::class, 'reject'])->name('reject');
    });
});

/*
|--------------------------------------------------------------------------  
| User Routes  
|--------------------------------------------------------------------------  
*/
Route::middleware(['auth'])->group(function () {
    // Peminjaman Ruangan
    Route::prefix('peminjaman/ruangan')->name('peminjaman.ruangan.')->group(function () {
        Route::get('/', [PeminjamanRuanganController::class, 'index'])->name('index');
        Route::get('/create', [PeminjamanRuanganController::class, 'create'])->name('create');
        Route::post('/store', [PeminjamanRuanganController::class, 'store'])->name('store');
        Route::get('/{id}', [PeminjamanRuanganController::class, 'show'])->name('show');
        Route::get('/riwayat', [PeminjamanRuanganController::class, 'riwayat'])->name('riwayat');
    });

    // Peminjaman Event
    Route::prefix('peminjaman/event')->name('peminjaman.event.')->group(function () {
        Route::get('{id}/form', [PeminjamanEventController::class, 'form'])->name('form');
        Route::post('store', [PeminjamanEventController::class, 'store'])->name('store');
        Route::get('{id}/detail', [PeminjamanEventController::class, 'detail'])->name('detail');
    });

    // Kerjasama Event
    Route::prefix('kerjasama/event')->name('kerjasama.event.')->group(function () {
        Route::get('/', [UserKerjaSamaEventController::class, 'index'])->name('index');
        Route::get('/{id}', [UserKerjaSamaEventController::class, 'show'])->name('show');
        Route::post('/{id}/register', [UserKerjaSamaEventController::class, 'register'])->name('register')->middleware('auth');
    });
    // Profile & Riwayat
        // Riwayat routes
        Route::prefix('riwayat')->name('riwayat.')->group(function () {
            Route::get('/', [RiwayatController::class, 'index'])->name('index');
            Route::get('/{id}', [RiwayatController::class, 'show'])->name('show');
        });
    });
    Route::get('profile', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [UserProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/password', [UserProfileController::class, 'updatePassword'])->name('profile.update.password');


/*
|--------------------------------------------------------------------------  
| Guest Routes  
|--------------------------------------------------------------------------  
*/
// Kunjungan
Route::prefix('kunjungan')->name('kunjungan.')->group(function () {
    Route::get('visit/create', [KunjunganVisitController::class, 'create'])->name('visit.create');
    Route::post('visit', [KunjunganVisitController::class, 'store'])->name('visit.store');
});

// Media Partner
Route::prefix('mediapartner')->name('mediapartner.')->group(function () {
    Route::get('create', [MediaPartnerController::class, 'create'])->name('create');
    Route::post('/', [MediaPartnerController::class, 'store'])->name('store');
});

// User Event Registration Routes
Route::prefix('pendaftaran/event')->name('pendaftaran.event.')->middleware(['auth'])->group(function () {
    Route::get('/', [PendaftaranEventController::class, 'index'])->name('index');
    Route::get('/cari', [PendaftaranEventController::class, 'cari'])->name('cari');
    Route::get('/{id}', [PendaftaranEventController::class, 'show'])->name('show');
    Route::get('/{id}/form', [PendaftaranEventController::class, 'form'])->name('form');
    Route::post('/store', [PendaftaranEventController::class, 'store'])->name('store');
});

    
Route::get('/admin/kelola/event/{event}/edit', [KelolaEventController::class, 'edit'])->name('admin.kelola.event.edit');
Route::delete('/admin/kelola/event/{event}', [KelolaEventController::class, 'destroy'])->name('admin.kelola.event.destroy');

// Route untuk user
Route::prefix('peminjaman/ruangan')->name('peminjaman.ruangan.')->group(function () {
    Route::get('/', [PeminjamanRuanganController::class, 'index'])->name('index');
    Route::get('/create', [PeminjamanRuanganController::class, 'create'])->name('create');
    Route::post('/store', [PeminjamanRuanganController::class, 'store'])->name('store');
    Route::get('/{id}', [PeminjamanRuanganController::class, 'show'])->name('show');
    Route::get('/riwayat', [PeminjamanRuanganController::class, 'riwayat'])->name('riwayat');
});

// Route untuk admin
Route::prefix('admin/verifikasi/peminjaman')->name('admin.verifikasi.peminjaman.')->group(function () {
    Route::get('/', [VerifikasiPeminjamanController::class, 'index'])->name('index');
    Route::get('/{id}', [VerifikasiPeminjamanController::class, 'show'])->name('show');
    Route::post('/{id}/approve', [VerifikasiPeminjamanController::class, 'approve'])->name('approve');
    Route::post('/{id}/reject', [VerifikasiPeminjamanController::class, 'reject'])->name('reject');
});

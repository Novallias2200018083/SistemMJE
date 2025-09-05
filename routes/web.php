<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AttendeeController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\NewsController;

// --- Admin Controllers ---
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\LotteryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ExportController as AdminExportController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\TenanController;
use App\Http\Controllers\Admin\TenanExportController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;


// --- Tenant Controllers ---
use App\Http\Controllers\Tenant\DashboardController as TenantDashboardController;
use App\Http\Controllers\Tenant\SaleController;
use App\Models\Tenant;

/*
|--------------------------------------------------------------------------
| Rute Halaman Publik (Untuk Pengunjung)
|--------------------------------------------------------------------------
| Rute ini dapat diakses oleh siapa saja tanpa perlu login.
*/

Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/register-event', [AttendeeController::class, 'create'])->name('event.register.form');
Route::post('/register-event', [AttendeeController::class, 'store'])->name('event.register.submit');
Route::get('/ticket/{token}', [TicketController::class, 'show'])->name('ticket.show');
Route::get('/ticket/{token}/download', [TicketController::class, 'download'])->name('ticket.download');
// Tambahkan rute ini di dalam grup Rute Halaman Publik
Route::get('/cek-undian', [PublicController::class, 'lottery'])->name('lottery.check');
// Route untuk menampilkan form pencarian dan menangani pencarian tiket
Route::get('/cetak-tiket', [AttendeeController::class, 'showFindForm'])->name('ticket.find');
// Route untuk portal berita (public)
Route::get('/portal-berita', [NewsController::class, 'index'])->name('news.index');
Route::get('/portal-berita/{news}', [NewsController::class, 'show'])->name('news.show');


/*
|--------------------------------------------------------------------------
| Rute Autentikasi Umum
|--------------------------------------------------------------------------
| Rute ini untuk pengguna yang sudah login (Admin & Tenan).
*/
Route::middleware(['auth', 'verified'])->group(function () {
    // Rute /dashboard utama yang akan mengarahkan pengguna berdasarkan peran (role)
    Route::get('/dashboard', function () {
        if (Auth::user() && Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif (Auth::user() && Auth::user()->role === 'tenant') {
            return redirect()->route('tenant.dashboard');
        }
        // Fallback jika ada peran lain di masa depan
        return redirect()->route('home');
    })->name('dashboard');

    // Rute profil bawaan dari Laravel Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| Rute Grup untuk Admin
|--------------------------------------------------------------------------
| Rute ini hanya bisa diakses oleh pengguna dengan peran 'admin'.
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('/events', EventController::class);
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');


    Route::get('/lottery', [LotteryController::class, 'index'])->name('lottery.index');
    // Hapus rute undian yang lama dan ganti dengan ini
    Route::post('/lottery/draw/{prize}', [LotteryController::class, 'draw'])->name('lottery.draw');
    Route::patch('/lottery/claim/{winner}', [LotteryController::class, 'claim'])->name('lottery.claim');
    Route::resource('/lottery', LotteryController::class)->parameters(['lottery' => 'prize']);
    // Halaman spin/roulette
Route::get('/lottery/spin/{prize}', [LotteryController::class, 'showSpinner'])->name('lottery.spin');


    Route::get('/export/attendance/{day}', [AdminExportController::class, 'attendance'])->name('export.attendance');
    // Ganti rute-rute UserController yang lama dengan ini:
    Route::resource('/users', UserController::class);
    // Rute untuk Export Data Pengguna
    Route::get('/export/users/complete', [ExportController::class, 'completeUsers'])->name('export.users.complete');
    Route::get('/export/users/demographics', [ExportController::class, 'demographics'])->name('export.users.demographics');

    // Rute untuk Presensi Massal
    Route::post('/attendance/mass-store', [AttendanceController::class, 'storeMass'])->name('attendance.mass_store');

    // Rute untuk Export Analisis Kehadiran
    Route::get('/export/attendance/analysis/{day}', [ExportController::class, 'attendanceAnalysis'])->name('export.attendance.analysis');

    // TAMBAHKAN DUA ROUTE BARU INI
    Route::get('/attendance/find-by-token', [AttendanceController::class, 'findByToken'])->name('attendance.findByToken');
    Route::post('/attendance/store-ajax', [AttendanceController::class, 'storeAjax'])->name('attendance.storeAjax');

    Route::get('/attendance/find-for-mass-absen', [AttendanceController::class, 'findForMassAbsen'])->name('attendance.findForMassAbsen');

    // Grup untuk Export
    Route::prefix('export')->name('export.')->controller(ExportController::class)->group(function () {
        // ... (route export Anda yang lain)

        // TAMBAHKAN ROUTE INI
        Route::get('/attendance/day/{day}', 'attendanceByDay')->name('attendance.by_day');
    });

    // Rute untuk Manajemen Tenan
    Route::resource('/tenan', TenanController::class);

    Route::get('/export/tenants/complete', [ExportController::class, 'completeTenants'])
        ->name('export.tenants.complete');

    // Rute untuk Export Tenants
    Route::prefix('export/tenants')->name('export.tenants.')->controller(TenanExportController::class)->group(function () {
        Route::get('/complete', 'complete')->name('complete');
        Route::get('/sales', 'sales')->name('sales');
        Route::get('/categories', 'categories')->name('categories');
        Route::get('/daily', 'daily')->name('daily');
        Route::get('/summary', 'summary')->name('summary');
    });

    // Rute untuk Manajemen Berita
    Route::resource('newslatter', AdminNewsController::class);
});


/*
|--------------------------------------------------------------------------
| Rute Grup untuk Tenan
|--------------------------------------------------------------------------
| Rute ini hanya bisa diakses oleh pengguna dengan peran 'tenant'.
*/
Route::middleware(['auth', 'role:tenant'])->prefix('tenant')->name('tenant.')->group(function () {
    Route::get('/dashboard', [TenantDashboardController::class, 'index'])->name('dashboard');
    Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
    Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');
    // Tambahkan rute ekspor untuk tenan jika diperlukan di sini
    Route::get('/sales/create-detail', [SaleController::class, 'createDetail'])->name('sales.create_detail');
    Route::post('/sales/store-detail', [SaleController::class, 'storeDetail'])->name('sales.store_detail');
    // TAMBAHKAN ROUTE INI
    Route::patch('/target', [TenantDashboardController::class, 'updateTarget'])->name('target.update');
    // TAMBAHKAN ROUTE INI
    Route::get('/sales/history', [SaleController::class, 'history'])->name('sales.history');
    Route::get('/sales/export', [SaleController::class, 'export'])->name('sales.export'); // <-- TAMBAHKAN INI
});


// Memuat rute-rute autentikasi (login, register, logout, dll.)
require __DIR__ . '/auth.php';

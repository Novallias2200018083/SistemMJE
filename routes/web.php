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
use App\Http\Controllers\Admin\SalesController;
use App\Http\Controllers\Admin\AdminSaleController;
use App\Http\Controllers\Admin\TenanExportController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;


// --- Tenant Controllers ---
use App\Http\Controllers\Tenant\DashboardController as TenantDashboardController;
use App\Http\Controllers\Tenant\SaleController;
use App\Models\Tenant;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

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

    // Routes baru untuk mengelola transaksi penjualan (mirip seperti SaleController)
Route::resource('sales', AdminSaleController::class)->except(['index', 'create', 'store']);

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

// <<<<<<< HEAD
    Route::resource('sales', SalesController::class)->except(['create', 'store', 'index']);

// =======
    // Rute untuk Manajemen Berita
    Route::resource('newslatter', AdminNewsController::class);
// >>>>>>> 36d3bb08c3f4dd7ce06443870a6d166825b8c953
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

     // ===== TAMBAHKAN ROUTE BARU DI BAWAH INI =====
    Route::get('/sales/{sale}', [SaleController::class, 'show'])->name('sales.show');
    Route::get('/sales/{sale}/edit', [SaleController::class, 'edit'])->name('sales.edit');
    Route::put('/sales/{sale}', [SaleController::class, 'update'])->name('sales.update');
    Route::delete('/sales/{sale}', [SaleController::class, 'destroy'])->name('sales.destroy');
});

// ===== TES FINAL: PAKSA KONFIGURASI LARAVEL =====
Route::get('/laravel-db-test', function () {
    try {
        // Langkah 1: Hapus cache config secara paksa di awal request
        Artisan::call('config:clear');

        // Langkah 2: Timpa konfigurasi database secara manual HANYA untuk request ini
        Config::set('database.connections.mysql.database', 'sistemmjediy');

        // Langkah 3: Paksa Laravel untuk membuat koneksi baru dengan config yang benar
        DB::purge('mysql');
        DB::reconnect('mysql');

        // Langkah 4: Sekarang jalankan query menggunakan DB facade Laravel
        $results = DB::table('sales')->where('tenant_id', 1)->get();

        // Tampilkan hasilnya
        echo "<h1>Tes Koneksi via Laravel DB Facade</h1>";
        echo "<b>Database yang digunakan secara paksa:</b> " . DB::getDatabaseName() . "<br><br>";

        if ($results->isEmpty()) {
            echo "<b>Hasil:</b> Gagal mengambil data, collection kosong. Masalah masih ada di tempat lain.";
        } else {
            echo "<b>Hasil:</b> BERHASIL! Data ditemukan.<br>";
            echo "<pre>";
            print_r($results->toArray());
            echo "</pre>";
        }

    } catch (\Exception $e) {
        echo "<h1>KONEKSI VIA LARAVEL GAGAL</h1>";
        echo "<p>" . $e->getMessage() . "</p>";
    }
});

Route::middleware(['auth', 'verified', 'role:admin']) // <-- GANTI INI AGAR SAMA DENGAN ROUTE ADMIN ANDA
    ->group(function () {
    
    Route::get('/middleware-test', function () {
        echo "<h1>Tes di dalam Middleware Admin</h1>";
        try {
            $salesData = DB::select('SELECT * FROM sales WHERE tenant_id = ?', [1]);

            if (empty($salesData)) {
                echo "Hasil: KOSONG. Middleware adalah penyebabnya.";
            } else {
                echo "Hasil: MUNCUL. Ini sangat aneh.";
                echo "<pre>";
                print_r($salesData);
                echo "</pre>";
            }
        } catch (\Exception $e) {
            echo "Query Gagal: " . $e->getMessage();
        }
    });

});

// Memuat rute-rute autentikasi (login, register, logout, dll.)
require __DIR__ . '/auth.php';

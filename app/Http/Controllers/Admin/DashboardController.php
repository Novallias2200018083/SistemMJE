<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendee;
use App\Models\Attendance;
use App\Models\Event;
use App\Models\Sale;
use App\Models\Tenant;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // Definisikan tanggal event di sini agar mudah diubah
    private $eventDates = [
        1 => '2025-09-12', // Contoh tanggal Hari 1
        2 => '2025-09-13', // Contoh tanggal Hari 2
        3 => '2025-09-14', // Contoh tanggal Hari 3
    ];

    public function index(Request $request)
    {
        // 1. Tentukan hari yang dipilih dari URL, default 'all'
        $selectedDay = in_array($request->input('day'), [1, 2, 3]) ? (int)$request->input('day') : 'all';
        $selectedDateFilter = ($selectedDay !== 'all') ? Carbon::parse($this->eventDates[$selectedDay]) : null;

        // --- Statistik Utama (Dinamis berdasarkan hari yang dipilih) ---
        $totalAttendees = Attendee::count(); // Total peserta terdaftar (global)

        // Total Kehadiran
        $totalAttendanceQuery = Attendance::query();
        if ($selectedDateFilter) {
            $totalAttendanceQuery->whereDate('created_at', $selectedDateFilter);
        }
        $totalAttendance = $totalAttendanceQuery->count();
        
        // Total Penjualan
        $totalSalesQuery = Sale::query();
        if ($selectedDateFilter) {
            $totalSalesQuery->whereDate('sale_date', $selectedDateFilter);
        }
        $totalSales = $totalSalesQuery->sum('amount');
        
        // Tingkat Kehadiran
        $attendanceRate = $totalAttendees > 0 ? ($totalAttendance / $totalAttendees) * 100 : 0;

        // --- Kehadiran Harian (Selalu tampil untuk semua hari event) ---
        $dailyAttendance = collect();
        foreach ($this->eventDates as $dayNum => $dateString) {
            $date = Carbon::parse($dateString);
            $count = Attendance::whereDate('created_at', $date)->count();
            $dailyAttendance->put("Hari " . $dayNum, $count);
        }

        // --- Penjualan Harian (Selalu tampil untuk semua hari event) ---
        $dailySales = collect();
        foreach ($this->eventDates as $dayNum => $dateString) {
            $date = Carbon::parse($dateString);
            $sum = Sale::whereDate('sale_date', $date)->sum('amount');
            $dailySales->put("Hari " . $dayNum, $sum);
        }
        
        // --- Tenan Terlaris per Kategori (Dinamis berdasarkan hari yang dipilih) ---
        $topTenants = [];
        $categories = ['makanan', 'multi_produk', 'pcr']; // Sesuaikan kategori Anda
        foreach ($categories as $category) {
            $tenantsQuery = Tenant::where('category', $category);

            // Menjumlahkan penjualan berdasarkan filter hari
            if ($selectedDateFilter) {
                $tenantsQuery->withSum(['sales as total_sales' => function ($query) use ($selectedDateFilter) {
                    $query->whereDate('sale_date', $selectedDateFilter);
                }], 'amount');
            } else {
                $tenantsQuery->withSum('sales as total_sales', 'amount');
            }

            $topTenants[$category] = $tenantsQuery->orderByDesc('total_sales')->take(5)->get();
        }

        // --- Event Hari Ini (Berdasarkan tanggal kalender hari ini, bukan filter dashboard) ---
        $today = Carbon::now('Asia/Jakarta')->toDateString();
        $eventDayNow = array_search($today, $this->eventDates); // Mencari hari event yang cocok dengan tanggal hari ini
        $todaysEvents = ($eventDayNow) 
            ? Event::where('day', $eventDayNow)->orderBy('start_time')->get()
            : collect(); // Jika tidak ada event hari ini

        return view('admin.dashboard', compact(
            'totalAttendees',
            'totalAttendance',
            'totalSales',
            'attendanceRate',
            'dailyAttendance', // Untuk kehadiran harian per hari
            'dailySales',      // Untuk penjualan harian per hari
            'topTenants',
            'todaysEvents',
            'eventDayNow',     // Hari event saat ini (jika ada)
            'selectedDay'      // Hari yang dipilih di filter dashboard
        ));
    }
}
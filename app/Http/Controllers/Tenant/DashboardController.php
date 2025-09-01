<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\SaleDetail;

class DashboardController extends Controller
{
    private $eventDates = [
        1 => '2025-09-12',
        2 => '2025-09-13',
        3 => '2025-09-14',
    ];

    // app/Http/Controllers/Tenant/DashboardController.php

public function index(Request $request)
{
    $tenant = Auth::user()->tenant;

    // --- Logika Cerdas untuk Menentukan Hari Event ---
    $validDays = [1, 2, 3];
    $selectedDay = in_array($request->input('day'), $validDays) ? $request->input('day') : 1;
    $selectedDate = Carbon::parse($this->eventDates[$selectedDay]);

    // --- Statistik Disesuaikan dengan Hari yang Dipilih ---
    $totalSales = $tenant->sales()->sum('amount');
    $daySalesData = $tenant->sales()->whereDate('sale_date', $selectedDate)->sum('amount');
    $targetColumn = 'target_day_' . $selectedDay;
    $dayTarget = $tenant->{$targetColumn};
    $targetPercentage = $dayTarget > 0 ? ($daySalesData / $dayTarget) * 100 : 0;
    
    // --- Statistik Ranking (tetap sama) ---
    $allTenantsInCategory = Tenant::where('category', $tenant->category)
        ->withSum('sales', 'amount')->get()->sortByDesc('sales_sum_amount');
    $rank = $allTenantsInCategory->pluck('id')->search($tenant->id) + 1;
    $totalTenantsInCategory = $allTenantsInCategory->count();

    // --- Chart Penjualan per Hari (tetap sama, menampilkan semua hari) ---
    $dailySalesChart = $tenant->sales()
        ->select(DB::raw('DATE(sale_date) as date'), DB::raw('SUM(amount) as total'))
        ->groupBy('date')->orderBy('date')->get()
        ->mapWithKeys(function ($item, $key) {
            return ['Hari ' . ($key + 1) => $item->total];
        });

    // ===== TAMBAHKAN LOGIKA INI =====
    // Ambil 5 item penjualan terakhir dari tenan ini
    $recentSales = SaleDetail::whereHas('sale', function ($query) use ($tenant) {
        $query->where('tenant_id', $tenant->id);
    })->latest()->take(5)->get();
    // ===== BATAS PENAMBAHAN =====

    return view('tenant.dashboard', [
        'tenant' => $tenant,
        'totalSales' => $totalSales,
        'daySalesData' => $daySalesData,
        'rank' => $rank,
        'totalTenantsInCategory' => $totalTenantsInCategory,
        'dailySalesChart' => $dailySalesChart,
        'dayTarget' => $dayTarget,
        'targetPercentage' => $targetPercentage,
        'selectedDay' => $selectedDay,
        'recentSales' => $recentSales, // <-- DAN KIRIM VARIABEL BARU INI
    ]);
}

    public function updateTarget(Request $request)
    {
        // Method updateTarget tidak perlu diubah
        $request->validate([
            'target_day_1' => 'required|numeric|min:0',
            'target_day_2' => 'required|numeric|min:0',
            'target_day_3' => 'required|numeric|min:0',
        ]);
        $tenant = Auth::user()->tenant;
        $tenant->update($request->only(['target_day_1', 'target_day_2', 'target_day_3']));
        return redirect()->route('tenant.dashboard')->with('status', 'Target Harian berhasil diperbarui!');
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendee;
use App\Models\Attendance;
use App\Models\Sale;
use App\Models\Event;
use App\Models\Tenant;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\LotteryWinner;
use App\Models\News;

class PublicController extends Controller
{
    public function home()
    {
        // --- Statistik Utama ---
        $totalAttendees = Attendee::count();
        $totalAttendance = Attendance::count();
        $totalSales = Sale::sum('amount');

        // --- Jadwal Acara per Hari ---
        $eventsByDay = Event::orderBy('start_time')->get()->groupBy('day');

        // --- Tenan Terlaris per Kategori ---
        $topTenants = [];
        $categories = ['makanan', 'multi_produk', 'pcr'];
        foreach ($categories as $category) {
            $topTenants[$category] = Tenant::where('category', $category)
                ->join('sales', 'tenants.id', '=', 'sales.tenant_id')
                ->select('tenants.tenant_name', DB::raw('SUM(sales.amount) as total_sales'))
                ->groupBy('tenants.id', 'tenants.tenant_name')
                ->orderBy('total_sales', 'desc')
                ->take(3)
                ->get();
        }

        // --- Ambil berita terbaru untuk homepage ---
        $news = News::latest()->get();

        return view('public.home', [
            'totalAttendees' => $totalAttendees,
            'totalAttendance' => $totalAttendance,
            'totalSales' => $totalSales,
            'eventsByDay' => $eventsByDay, // Mengirim semua event yang sudah dikelompokkan
            'topTenants' => $topTenants,
            'news' => $news,
        ]);

    }

public function lottery(Request $request)
{
    // Tentukan waktu pengundian (Hari terakhir event, jam 8 malam)
    $drawTime = Carbon::create(2025, 8, 27, 20, 0, 0, 'Asia/Jakarta');
    $now = Carbon::now('Asia/Jakarta');

    // Jika waktu sekarang belum mencapai waktu pengundian
    if ($now->isBefore($drawTime)) {
        return view('public.lottery', [
            'isDrawTime' => false,
            'drawTime' => $drawTime
        ]);
    }

    // Jika sudah waktu pengundian, ambil hanya pemenang yang sudah diklaim
    $winners = LotteryWinner::with('attendee')
        ->where('is_claimed', true)
        ->latest('drawn_at')
        ->get();

    $searchResult = null;
    $searchedToken = $request->input('token');

    // Logika pencarian token
    if ($searchedToken) {
        $isWinner = $winners->firstWhere('attendee.token', $searchedToken);
        if ($isWinner) {
            $searchResult = 'win';
        } else {
            $searchResult = 'lose';
        }
    }

    return view('public.lottery', [
        'isDrawTime' => true,
        'winners' => $winners,
        'searchResult' => $searchResult,
        'searchedToken' => $searchedToken
    ]);
}
}

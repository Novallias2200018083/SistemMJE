<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\Tenant;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TenantSalesExport; // Pastikan Anda memiliki Export class ini

class TenanController extends Controller
{
    private function getTenantCategories(): array
    {
        return [
            'Makanan',
            'Multi Produk',
            'Ranting/Cabang (PCR/PCM)',
        ];
    }
    
    // Metode helper baru untuk mendapatkan tanggal event
    private function getEventDates(): array
    {
        return [
            1 => '2025-09-12',
            2 => '2025-09-13',
            3 => '2025-09-14',
        ];
    }

    public function index(Request $request)
    {
        $totalTenants = Tenant::count();
        $totalSales = Sale::sum('amount');
        
        $categories = Tenant::query()->whereNotNull('category')->distinct()->pluck('category');
        $categoryDistribution = Tenant::query()->whereNotNull('category')->pluck('category')->countBy();

        $tenansQuery = Tenant::query()
            ->with('user')
            ->withSum('sales', 'amount')
            ->when($request->filled('search'), fn($q) => $q->where('tenant_name', 'like', '%' . $request->search . '%'))
            ->when($request->filled('category'), fn($q) => $q->where('category', $request->category))
            ->orderByDesc('sales_sum_amount');

        $tenans = $tenansQuery->paginate(10)->withQueryString();

        return view('admin.tenan.index', compact('tenans', 'totalTenants', 'totalSales', 'categories', 'categoryDistribution'));
    }

    public function create()
    {
        $categories = $this->getTenantCategories();
        return view('admin.tenan.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $categories = $this->getTenantCategories();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'tenant_name' => 'required|string|max:255|unique:tenants,tenant_name',
            'category' => ['required', 'string', Rule::in($categories)],
            'phone_number' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'target_day_1' => 'nullable|integer|min:0',
            'target_day_2' => 'nullable|integer|min:0',
            'target_day_3' => 'nullable|integer|min:0',
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone_number' => $validated['phone_number'],
                'password' => Hash::make($validated['password']),
            ]);
            $user->assignRole('tenant');

            $user->tenant()->create([
                'tenant_name' => $validated['tenant_name'],
                'category' => $validated['category'],
                'target_day_1' => $validated['target_day_1'] ?? 0,
                'target_day_2' => $validated['target_day_2'] ?? 0,
                'target_day_3' => $validated['target_day_3'] ?? 0,
            ]);
        });

        return redirect()->route('admin.tenan.index')->with('success', 'Akun Tenan baru berhasil dibuat!');
    }

    /**
     * Display the specified tenant's details and statistics.
     */
    public function show(Tenant $tenan, Request $request)
    {
        $tenan->load('user');

        $eventDates = $this->getEventDates();
        $eventStartDate = Carbon::parse(reset($eventDates))->startOfDay();
        $eventEndDate = Carbon::parse(end($eventDates))->endOfDay();
        $totalEventDays = count($eventDates);

        // 1. Logika untuk Pencarian, Filter, dan Sortir pada Riwayat Transaksi
        $query = $tenan->sales()
            ->with('details')
            ->whereBetween('sale_date', [$eventStartDate, $eventEndDate]);

        // Filter berdasarkan hari
        $selectedDay = $request->input('day', 'all');
        if ($selectedDay !== 'all') {
            $query->whereDate('sale_date', $eventDates[$selectedDay]);
        }

        // Pencarian berdasarkan nama produk
        if ($request->filled('search')) {
            $query->whereHas('details', function ($q) use ($request) {
                $q->where('product_name', 'like', '%' . $request->search . '%');
            });
        }

        // Sortir
        $sort = $request->input('sort', 'newest');
        switch ($sort) {
            case 'oldest':
                $query->oldest('sale_date')->oldest('id');
                break;
            case 'highest_amount':
                $query->orderByDesc('amount');
                break;
            case 'lowest_amount':
                $query->orderBy('amount');
                break;
            default: // newest
                $query->latest('sale_date')->latest('id');
                break;
        }

        // PERBAIKAN: Gunakan paginate() untuk daftar transaksi agar links() bisa bekerja
        $allSalesForListing = $query->paginate(10)->withQueryString();


        // 2. Logika untuk Statistik Dashboard (Tanpa Filter Riwayat Transaksi)
        $statsQuery = $tenan->sales()->whereBetween('sale_date', [$eventStartDate, $eventEndDate]);
        $totalSales = $statsQuery->sum('amount');
        $totalTransactions = $statsQuery->count();

        $salesPerDay = collect($eventDates)->map(function ($date, $dayNumber) use ($tenan) {
            $dailySales = $tenan->sales()->whereDate('sale_date', $date)->sum('amount');
            $dailyTransactions = $tenan->sales()->whereDate('sale_date', $date)->count();
            $dailyTarget = $tenan->{'target_day_' . ($dayNumber)} ?? 0;
            return [
                'day_number' => $dayNumber,
                'day_name' => Carbon::parse($date)->isoFormat('dddd'),
                'total' => $dailySales,
                'target' => $dailyTarget,
                'transactions' => $dailyTransactions,
            ];
        });

        $totalTarget = $salesPerDay->sum('target');
        $bestDay = $salesPerDay->sortByDesc('total')->first() ?? ['day_number' => null];
        $averageSalesPerDay = $totalEventDays > 0 ? $totalSales / $totalEventDays : 0;
        
        $overallRankData = Sale::whereBetween('sale_date', [$eventStartDate, $eventEndDate])
                                ->groupBy('tenant_id')
                                ->selectRaw('tenant_id, SUM(amount) as total_sales')
                                ->orderByDesc('total_sales')
                                ->get();
        $overallRank = $overallRankData->search(fn($item) => $item->tenant_id === $tenan->id) + 1;
        $totalAllTenants = $overallRankData->count();

        $categoryRankData = Sale::join('tenants', 'sales.tenant_id', '=', 'tenants.id')
                                ->where('tenants.category', $tenan->category)
                                ->whereBetween('sale_date', [$eventStartDate, $eventEndDate])
                                ->groupBy('tenant_id')
                                ->selectRaw('tenant_id, SUM(amount) as total_sales')
                                ->orderByDesc('total_sales')
                                ->get();
        $categoryRank = $categoryRankData->search(fn($item) => $item->tenant_id === $tenan->id) + 1;
        $totalInCategory = $categoryRankData->count();

        $targetAchievementPercentage = $totalTarget > 0 ? ($totalSales / $totalTarget) * 100 : 0;

        return view('admin.tenan.show', [
            'tenant' => $tenan,
            'totalSales' => $totalSales,
            'totalTransactions' => $totalTransactions,
            'salesPerDay' => $salesPerDay,
            'averageSalesPerDay' => $averageSalesPerDay,
            'bestDay' => $bestDay,
            'totalTarget' => $totalTarget,
            'targetAchievementPercentage' => number_format($targetAchievementPercentage, 1),
            'overallRank' => $overallRank,
            'totalAllTenants' => $totalAllTenants,
            'categoryRank' => $categoryRank,
            'totalInCategory' => $totalInCategory,
            'allSalesForListing' => $allSalesForListing,
            'selectedDay' => $selectedDay,
            'sort' => $sort,
            'search' => $request->input('search'),
        ]);
    }

    // // Metode baru untuk ekspor data
    // public function export(Tenant $tenan, Request $request)
    // {
    //     $eventDates = $this->getEventDates();
    //     $eventStartDate = reset($eventDates);
    //     $eventEndDate = end($eventDates);

    //     $query = $tenan->sales()->with('details')->whereBetween('sale_date', [$eventStartDate, $eventEndDate]);

    //     // Terapkan filter yang sama seperti di metode show
    //     $selectedDay = $request->input('day', 'all');
    //     if ($selectedDay !== 'all') {
    //         $query->whereDate('sale_date', $eventDates[$selectedDay]);
    //     }
    //     if ($request->filled('search')) {
    //         $searchTerm = $request->search;
    //         $query->whereHas('details', function ($q) use ($searchTerm) {
    //             $q->where('product_name', 'like', "%{$searchTerm}%");
    //         });
    //     }
    //     if ($request->filled('sort')) {
    //         switch ($request->sort) {
    //             case 'highest_amount': $query->orderBy('amount', 'desc'); break;
    //             case 'lowest_amount': $query->orderBy('amount', 'asc'); break;
    //             case 'oldest': $query->oldest('sale_date')->oldest('id'); break;
    //             default: $query->latest('sale_date')->latest('id'); break;
    //         }
    //     }

    //     $salesToExport = $query->get();
    //     $fileName = 'Riwayat_Penjualan_' . $tenan->tenant_name . '_' . $selectedDay . '.xlsx';
        
    //     return Excel::download(new TenantSalesExport($salesToExport), $fileName);
    // }
    
    public function edit(Tenant $tenan, Sale $sale)
    {
        if ($tenan->id !== $sale->tenant_id) {
            abort(403);
        }
        return redirect()->route('admin.sales.edit', $sale);
    }

    public function destroy(Tenant $tenan, Sale $sale)
    {
        if ($tenan->id !== $sale->tenant_id) {
            abort(403);
        }
        return redirect()->route('admin.sales.destroy', $sale);
    }

    public function editTenant(Tenant $tenan)
    {
        $tenan->load('user');
        $categories = $this->getTenantCategories();
        return view('admin.tenan.edit', compact('tenan', 'categories'));
    }

    public function updateTenant(Request $request, Tenant $tenan)
    {
        $categories = $this->getTenantCategories();
        $user = $tenan->user;
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'tenant_name' => ['required', 'string', 'max:255', Rule::unique('tenants')->ignore($tenan->id)],
            'category' => ['required', 'string', Rule::in($categories)],
            'phone_number' => 'required|string|max:20',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'target_day_1' => 'nullable|integer|min:0',
            'target_day_2' => 'nullable|integer|min:0',
            'target_day_3' => 'nullable|integer|min:0',
        ]);

        DB::transaction(function () use ($validated, $tenan) {
            $tenan->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone_number' => $validated['phone_number'],
            ]);

            if (!empty($validated['password'])) {
                $tenan->user->update(['password' => Hash::make($validated['password'])]);
            }

            $tenan->update([
                'tenant_name' => $validated['tenant_name'],
                'category' => $validated['category'],
                'target_day_1' => $validated['target_day_1'] ?? 0,
                'target_day_2' => $validated['target_day_2'] ?? 0,
                'target_day_3' => $validated['target_day_3'] ?? 0,
            ]);
        });

        return redirect()->route('admin.tenan.index')->with('success', "Data tenan {$tenan->tenant_name} berhasil diperbarui!");
    }

    public function destroyTenant(Tenant $tenan)
    {
        DB::transaction(function () use ($tenan) {
            $user = $tenan->user;

            $tenan->sales()->each(function ($sale) {
                if ($sale->image) {
                    Storage::disk('public')->delete($sale->image);
                }
                $sale->details()->delete();
                $sale->delete();
            });

            $tenan->delete();
            
            if ($user) {
                $user->delete();
            }
        });

        return redirect()->route('admin.tenan.index')->with('success', 'Tenan berhasil dihapus beserta semua datanya.');
    }
}
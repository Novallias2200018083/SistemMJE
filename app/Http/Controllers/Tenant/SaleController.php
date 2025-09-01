<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel; // <-- Import Excel
use App\Exports\SalesExport; // <-- Import kelas Export kita

class SaleController extends Controller
{
    // Definisikan tanggal event di sini agar mudah diubah
    private $eventDates = [
        1 => '2025-09-12',
        2 => '2025-09-13',
        3 => '2025-09-14',
    ];

    public function index()
    {
        return view('tenant.sales.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'day' => 'required|integer|in:1,2,3',
        ]);

        $tenant = Auth::user()->tenant;
        $saleDate = $this->eventDates[$request->day];

        $tenant->sales()->updateOrCreate(
            ['sale_date' => $saleDate],
            ['amount' => $request->amount]
        );

        return redirect()->route('tenant.dashboard')->with('success', 'Data penjualan berhasil disimpan.');
    }

    public function createDetail()
    {
        return view('tenant.sales.create-detail');
    }

    // app/Http/Controllers/Tenant/SaleController.php

// app/Http/Controllers/Tenant/SaleController.php

    public function storeDetail(Request $request)
    {
        // Validasi tidak berubah
        $request->validate([
            'day' => 'required|integer|in:1,2,3',
            'products' => 'required|array|min:1',
            'products.*.name' => 'required|string|max:255',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ]);

        $tenant = Auth::user()->tenant;
        $saleDate = $this->eventDates[$request->day];
        $totalAmount = 0;

        foreach ($request->products as $product) {
            $totalAmount += $product['quantity'] * $product['price'];
        }

        DB::transaction(function () use ($request, $tenant, $totalAmount, $saleDate) {
            
            // ===== LOGIKA BARU UNTUK NOMOR URUT TRANSAKSI =====
            // 1. Dapatkan transaksi terakhir dari tenan INI SAJA untuk mendapatkan nomor urut terakhir
            $lastSale = $tenant->sales()->latest('tenant_sale_id')->first();

            // 2. Tentukan nomor urut berikutnya. Jika belum ada, mulai dari 1.
            $nextSaleId = ($lastSale) ? $lastSale->tenant_sale_id + 1 : 1;
            // ======================================================

            // Buat record Sale baru dengan nomor urut yang baru
            $sale = Sale::create([
                'tenant_id' => $tenant->id,
                'tenant_sale_id' => $nextSaleId, // Simpan nomor urut baru
                'amount' => $totalAmount,
                'sale_date' => $saleDate,
            ]);

            // Loop untuk menyimpan setiap item penjualan (tidak berubah)
            foreach ($request->products as $product) {
                SaleDetail::create([
                    'sale_id' => $sale->id,
                    'product_name' => $product['name'],
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                    'total_price' => $product['quantity'] * $product['price'],
                ]);
            }
        });

        return redirect()->route('tenant.sales.history')->with('status', 'Transaksi berhasil disimpan!');
    }


    public function history(Request $request)
    {
        $tenant = Auth::user()->tenant;
        $validDays = [1, 2, 3];
        $selectedDay = in_array($request->input('day'), $validDays) ? $request->input('day') : 'all';

        // Mulai query dasar
        $query = $tenant->sales()->with('details')->latest('sale_date')->latest('id');

        // 1. Filter berdasarkan Hari
        if ($selectedDay !== 'all') {
            $eventDates = [1 => '2025-09-12', 2 => '2025-09-13', 3 => '2025-09-14'];
            $query->whereDate('sale_date', $eventDates[$selectedDay]);
        }

        // 2. Filter berdasarkan Pencarian
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->whereHas('details', function ($q) use ($searchTerm) {
                $q->where('product_name', 'like', "%{$searchTerm}%");
            });
        }
        
        // 3. Filter berdasarkan Pengurutan
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'highest_amount':
                    $query->orderBy('amount', 'desc');
                    break;
                case 'lowest_amount':
                    $query->orderBy('amount', 'asc');
                    break;
                case 'oldest':
                    $query->oldest('sale_date')->oldest('id');
                    break;
                default: // 'newest'
                    $query->latest('sale_date')->latest('id');
                    break;
            }
        }

        // 4. Ambil data dengan pagination
        $sales = $query->paginate(10)->withQueryString();

        return view('tenant.sales-history', [
            'sales' => $sales,
            'selectedDay' => $selectedDay,
        ]);
    }

    // METHOD BARU untuk Ekspor Excel
    public function export(Request $request)
    {
        $tenant = Auth::user()->tenant;
        $validDays = [1, 2, 3];
        $selectedDay = in_array($request->input('day'), $validDays) ? $request->input('day') : 'all';

        // Query ini MENG-COPY logika dari method history()
        $query = $tenant->sales()->with('details')->latest('sale_date')->latest('id');

        if ($selectedDay !== 'all') {
             $eventDates = [1 => '2025-09-12', 2 => '2025-09-13', 3 => '2025-09-14'];
            $query->whereDate('sale_date', $eventDates[$selectedDay]);
        }
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->whereHas('details', function ($q) use ($searchTerm) {
                $q->where('product_name', 'like', "%{$searchTerm}%");
            });
        }
        if ($request->filled('sort')) {
             switch ($request->sort) {
                case 'highest_amount': $query->orderBy('amount', 'desc'); break;
                case 'lowest_amount': $query->orderBy('amount', 'asc'); break;
                case 'oldest': $query->oldest('sale_date')->oldest('id'); break;
                default: $query->latest('sale_date')->latest('id'); break;
            }
        }

        // Ambil SEMUA data yang cocok (tanpa pagination)
        $salesToExport = $query->get();
        
        $fileName = 'Riwayat_Penjualan_Hari_' . $selectedDay . '_' . now()->format('Y-m-d') . '.xlsx';
        
        return Excel::download(new SalesExport($salesToExport), $fileName);
    }
}

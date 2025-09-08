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
use Illuminate\Support\Facades\Storage; // <-- Jangan lupa tambahkan ini

class SaleController extends Controller
{
    // Definisikan tanggal event di sini agar mudah diubah
    private $eventDates = [
        1 => '2025-09-12',
        2 => '2025-09-13',
        3 => '2025-09-14',
    ];

    // BARU (Perbaikan)
    public function index()
    {
        // 1. Ambil data tenan yang sedang login
        $tenant = Auth::user()->tenant;

        // 2. Kirim variabel $tenant tersebut ke view
        return view('tenant.sales.index', ['tenant' => $tenant]);
    }

     public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'day' => 'required|integer|in:1,2,3',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // <-- Validasi gambar
        ]);

        $tenant = Auth::user()->tenant;
        $saleDate = $this->eventDates[$request->day];
        $imagePath = null; // <-- Siapkan variabel path gambar

        // Logika untuk menyimpan gambar
        if ($request->hasFile('image')) {
            // Simpan gambar di folder 'storage/app/public/sales_images'
            // dan dapatkan path-nya untuk disimpan di DB.
            $imagePath = $request->file('image')->store('sales_images', 'public');
        }

        DB::transaction(function () use ($request, $tenant, $saleDate, $imagePath) {
            $lastSale = $tenant->sales()->latest('tenant_sale_id')->first();
            $nextSaleId = ($lastSale) ? $lastSale->tenant_sale_id + 1 : 1;

            Sale::create([
                'tenant_id'      => $tenant->id,
                'tenant_sale_id' => $nextSaleId,
                'sale_date'      => $saleDate,
                'amount'         => $request->amount,
                'image'          => $imagePath, // <-- Simpan path gambar ke DB
            ]);

            // 2. KUNCI PILIHAN JIKA INI INPUT PERTAMA
            if (is_null($tenant->sales_input_method)) {
                $tenant->update(['sales_input_method' => 'total']);
            }
        });

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
        // Validasi digabungkan, ditambahkan validasi untuk gambar
        $request->validate([
            'day' => 'required|integer|in:1,2,3',
            'products' => 'required|array|min:1',
            'products.*.name' => 'required|string|max:255',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // <-- Validasi gambar
        ]);

        $tenant = Auth::user()->tenant;
        $saleDate = $this->eventDates[$request->day];
        $totalAmount = 0;
        $imagePath = null; // Siapkan variabel path gambar

        // Logika untuk menyimpan gambar
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('sales_images', 'public');
        }

        foreach ($request->products as $product) {
            $totalAmount += $product['quantity'] * $product['price'];
        }

        DB::transaction(function () use ($request, $tenant, $totalAmount, $saleDate, $imagePath) { // <-- $imagePath ditambahkan
            
            // Dapatkan transaksi terakhir untuk mendapatkan nomor urut terakhir
            $lastSale = $tenant->sales()->latest('tenant_sale_id')->first();
            $nextSaleId = ($lastSale) ? $lastSale->tenant_sale_id + 1 : 1;

            // Buat record Sale baru dengan nomor urut yang baru
            $sale = Sale::create([
                'tenant_id'      => $tenant->id,
                'tenant_sale_id' => $nextSaleId,
                'amount'         => $totalAmount,
                'sale_date'      => $saleDate,
                'image'          => $imagePath, // <-- Simpan path gambar ke DB
            ]);

            // Loop untuk menyimpan setiap item penjualan
            foreach ($request->products as $product) {
                SaleDetail::create([
                    'sale_id'      => $sale->id,
                    'product_name' => $product['name'],
                    'quantity'     => $product['quantity'],
                    'price'        => $product['price'],
                    'total_price'  => $product['quantity'] * $product['price'],
                ]);
            }

            // 2. KUNCI PILIHAN JIKA INI INPUT PERTAMA
            if (is_null($tenant->sales_input_method)) {
                $tenant->update(['sales_input_method' => 'detail']);
            }

        });

        return redirect()->route('tenant.sales.history')->with('status', 'Transaksi berhasil disimpan!');
    }


    public function history(Request $request)
    {
        $tenant = Auth::user()->tenant;
        $selectedDay = in_array($request->input('day'), [1, 2, 3]) ? $request->input('day') : 'all';

        // Query dasar yang akan kita gunakan untuk filter dan statistik
        $query = $tenant->sales()
            ->with('details')
            ->when($selectedDay !== 'all', function ($q) use ($selectedDay) {
            // <-- 2. Ganti config('event.dates') menjadi $this->eventDates
            $q->whereDate('sale_date', $this->eventDates[$selectedDay]);
            })
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->whereHas('details', function ($subq) use ($request) {
                    $subq->where('product_name', 'like', '%' . $request->search . '%');
                });
            });

        // HITUNG STATISTIK BERDASARKAN QUERY YANG SUDAH DIFILTER
        // Kita clone query agar perhitungan tidak mengganggu paginasi
        $statsQuery = clone $query;
        $filteredStats = $statsQuery->select(
            DB::raw('SUM(amount) as total_sales'),
            DB::raw('COUNT(id) as total_transactions')
        )->first();

        // Terapkan pengurutan
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

        // Ambil data dengan paginasi setelah semua filter dan urutan diterapkan
        $sales = $query->paginate(10)->withQueryString();

        return view('tenant.sales-history', [
            'sales' => $sales,
            'selectedDay' => $selectedDay,
            'totalFilteredSales' => $filteredStats->total_sales ?? 0,
            'totalFilteredTransactions' => $filteredStats->total_transactions ?? 0,
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

    // ===== METHOD BARU UNTUK MELIHAT DETAIL =====
    public function show(Sale $sale)
    {
        // // Otorisasi: Pastikan tenan hanya bisa melihat transaksinya sendiri
        // if (Auth::user()->tenant->id !== $sale->tenant_id) {
        //     abort(403, 'AKSI TIDAK DIIZINKAN');
        // }

        return view('tenant.sales.show', compact('sale'));
    }

    // ===== METHOD BARU UNTUK MENAMPILKAN FORM EDIT =====
     public function edit(Sale $sale)
    {
        // // Otorisasi
        // if (Auth::user()->tenant->id !== $sale->tenant_id) {
        //     abort(403, 'AKSI TIDAK DIIZINKAN');
        // }

        // Cari tahu 'day' (1, 2, atau 3) dari tanggal penjualan
        $saleDate = \Carbon\Carbon::parse($sale->sale_date)->toDateString();
        $day = array_search($saleDate, $this->eventDates);

        // **LOGIKA BARU:** Tentukan view mana yang akan ditampilkan
        if ($sale->tenant->sales_input_method === 'total') {
            return view('tenant.sales.edit-total', compact('sale', 'day'));
        }
        
        // Default ke form edit detail
        return view('tenant.sales.edit-detail', compact('sale', 'day'));
    }

    public function update(Request $request, Sale $sale)
    {
        // // Otorisasi
        // if (Auth::user()->tenant->id !== $sale->tenant_id) {
        //     abort(403, 'AKSI TIDAK DIIZINKAN');
        // }
        
        $tenant = $sale->tenant;
        $saleDate = $this->eventDates[$request->day];

        // **LOGIKA BARU:** Proses update berdasarkan metode input
        DB::transaction(function () use ($request, $sale, $tenant, $saleDate) {
            // Jika metodenya TOTAL
            if ($tenant->sales_input_method === 'total') {
                $validated = $request->validate([
                    'day' => 'required|integer|in:1,2,3',
                    'amount' => 'required|numeric|min:0',
                    'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                ]);

                $sale->amount = $validated['amount'];
            } 
            // Jika metodenya DETAIL
            else {
                $validated = $request->validate([
                    'day' => 'required|integer|in:1,2,3',
                    'products' => 'required|array|min:1',
                    'products.*.name' => 'required|string|max:255',
                    'products.*.quantity' => 'required|integer|min:1',
                    'products.*.price' => 'required|numeric|min:0',
                    'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                ]);

                $totalAmount = collect($validated['products'])->sum(fn($p) => $p['quantity'] * $p['price']);
                $sale->amount = $totalAmount;

                // Hapus detail lama dan buat yang baru
                $sale->details()->delete();
                foreach ($validated['products'] as $product) {
                    $sale->details()->create([
                        'product_name' => $product['name'],
                        'quantity' => $product['quantity'],
                        'price' => $product['price'],
                        'total_price' => $product['quantity'] * $product['price'],
                    ]);
                }
            }

            // Handle upload gambar baru (berlaku untuk keduanya)
            if ($request->hasFile('image')) {
                if ($sale->image) {
                    Storage::disk('public')->delete($sale->image);
                }
                $sale->image = $request->file('image')->store('sales_images', 'public');
            }
            
            // Update data utama penjualan
            $sale->sale_date = $saleDate;
            $sale->save();
        });

        return redirect()->route('tenant.sales.history')->with('status', 'Transaksi berhasil diperbarui!');
    }

    // ===== METHOD BARU UNTUK MENGHAPUS TRANSAKSI =====
    public function destroy(Sale $sale)
    {
        // // Otorisasi
        // if (Auth::user()->tenant->id !== $sale->tenant_id) {
        //     abort(403, 'AKSI TIDAK DIIZINKAN');
        // }

        DB::transaction(function () use ($sale) {
            // Hapus gambar dari storage jika ada
            if ($sale->image) {
                Storage::disk('public')->delete($sale->image);
            }
            // Hapus detail penjualan
            $sale->details()->delete();
            // Hapus penjualan utama
            $sale->delete();
        });

        return redirect()->route('tenant.sales.history')->with('status', 'Transaksi berhasil dihapus.');
    }
}

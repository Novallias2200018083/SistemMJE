<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminSaleController extends Controller
{
    // Definisikan tanggal event di sini agar mudah diubah
    private $eventDates = [
        1 => '2025-09-12',
        2 => '2025-09-13',
        3 => '2025-09-14',
    ];

    /**
     * Show the specified transaction details.
     * Mengembalikan tampilan detail transaksi yang dapat diperluas.
     */
    public function show(Sale $sale): View
    {
        // Pastikan relasi details sudah dimuat
        $sale->load('details');
        
        return view('admin.sales.show', compact('sale'));
    }

    /**
     * Show the form for editing the specified transaction.
     * Menggunakan logika yang sama dengan SaleController milik tenan.
     */
    public function edit(Sale $sale): View
    {
        $sale->load('details');

        // Cari tahu 'day' (1, 2, atau 3) dari tanggal penjualan
        $saleDate = \Carbon\Carbon::parse($sale->sale_date)->toDateString();
        $day = array_search($saleDate, $this->eventDates);

        // Tentukan view mana yang akan ditampilkan berdasarkan sales_input_method tenan
        if ($sale->tenant->sales_input_method === 'total') {
            return view('admin.sales.edit-total', compact('sale', 'day'));
        }
        
        // Default ke form edit detail jika metodenya detail
        return view('admin.sales.edit-detail', compact('sale', 'day'));
    }

    /**
     * Update the specified transaction in storage.
     * Menggunakan logika yang sama dengan SaleController milik tenan.
     */
    public function update(Request $request, Sale $sale)
    {
        $tenant = $sale->tenant;
        $saleDate = $this->eventDates[$request->day];

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

        return redirect()->route('admin.tenan.show', $sale->tenant_id)->with('success', 'Transaksi berhasil diperbarui.');
    }

    /**
     * Remove the specified transaction from storage.
     * Menggunakan logika yang sama dengan SaleController milik tenan.
     */
    public function destroy(Sale $sale)
    {
        $tenantId = $sale->tenant_id;
        
        DB::transaction(function () use ($sale) {
            // Hapus file gambar jika ada
            if ($sale->image) {
                Storage::disk('public')->delete($sale->image);
            }
            
            // Hapus detail transaksi (jika ada) dan transaksi utama
            if ($sale->details) {
                $sale->details()->delete();
            }
            $sale->delete();
        });

        return redirect()->route('admin.tenan.show', $tenantId)->with('success', 'Transaksi berhasil dihapus.');
    }
}
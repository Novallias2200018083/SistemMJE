<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SalesController extends Controller
{
    // Method untuk menampilkan form edit
    public function edit(Sale $sale)
    {
        $sale->load('details');
        return view('admin.sales.edit', compact('sale'));
    }

    // Method untuk mengupdate transaksi
    public function update(Request $request, Sale $sale)
    {
        // Logika validasi dan update data penjualan
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            // tambahkan validasi lain sesuai kebutuhan
        ]);

        $sale->update($validated);

        return redirect()->back()->with('success', 'Transaksi berhasil diperbarui.');
    }

    // Method untuk menghapus transaksi
    public function destroy(Sale $sale)
    {
        // Hapus file gambar jika ada
        if ($sale->image) {
            Storage::disk('public')->delete($sale->image);
        }
        
        // Hapus detail transaksi dan kemudian transaksi itu sendiri
        $sale->details()->delete();
        $sale->delete();

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus.');
    }
}
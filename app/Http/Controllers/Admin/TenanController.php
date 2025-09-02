<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;

class TenanController extends Controller
{
    public function index()
    {
        $tenans = Tenant::with('user')->latest()->paginate(12);

        $totalTenants = Tenant::count();
        $totalSales   = Tenant::sum('total_sales');
        $targetDay1   = Tenant::sum('target_day_1');
        $targetDay2   = Tenant::sum('target_day_2');
        $targetDay3   = Tenant::sum('target_day_3');

        $categories = $this->categories();

        $categoryDistribution = Tenant::select('category')
            ->whereNotNull('category')
            ->groupBy('category')
            ->selectRaw('category, COUNT(*) as total')
            ->pluck('total', 'category');

        return view('admin.tenan.index', compact(
            'tenans',
            'totalTenants',
            'totalSales',
            'targetDay1',
            'targetDay2',
            'targetDay3',
            'categories',
            'categoryDistribution'
        ));
    }

    private function categories()
    {
        return Tenant::whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');
    }

    public function create()
    {
        $categories = $this->categories();
        return view('admin.tenan.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'tenant_name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'total_sales' => 'nullable|integer',
            'target_day_1' => 'nullable|integer',
            'target_day_2' => 'nullable|integer',
            'target_day_3' => 'nullable|integer',
        ]);

        Tenant::create($validated);

        return redirect()->route('admin.tenan.index')
            ->with('success', 'Tenan berhasil ditambahkan!');
    }

    public function edit(Tenant $tenan)
    {
        $categories = $this->categories();
        return view('admin.tenan.edit', compact('tenan', 'categories'));
    }

    public function update(Request $request, Tenant $tenan)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'tenant_name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'total_sales' => 'nullable|integer',
            'target_day_1' => 'nullable|integer',
            'target_day_2' => 'nullable|integer',
            'target_day_3' => 'nullable|integer',
        ]);

        $tenan->update($validated);

        return redirect()->route('admin.tenan.index')
            ->with('success', 'Tenan berhasil diperbarui!');
    }

    public function destroy(Tenant $tenan)
    {
        $tenan->delete();

        return redirect()->route('admin.tenan.index')
            ->with('success', 'Tenan berhasil dihapus');
    }
}

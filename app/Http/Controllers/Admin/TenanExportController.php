<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\Sale;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;

class TenanExportController extends Controller
{
    /**
     * Export semua data tenant lengkap
     */
    public function complete()
    {
        $tenants = Tenant::all();

        $csvData = "ID,Nama Tenant,Kategori,Target,Created At\n";
        foreach ($tenants as $tenant) {
            $csvData .= "{$tenant->id},\"{$tenant->tenant_name}\",\"{$tenant->category}\",{$tenant->target},{$tenant->created_at}\n";
        }

        return Response::make($csvData, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="tenants_complete.csv"',
        ]);
    }

    /**
     * Export data penjualan tenant
     */
    public function sales()
    {
        $sales = Sale::with('tenant')->get();

        $csvData = "ID,ID Tenant,Nama Tenant,Amount,Sale Date,Created At\n";
        foreach ($sales as $sale) {
            $csvData .= "{$sale->id},{$sale->tenant_id},\"{$sale->tenant->tenant_name}\",{$sale->amount},{$sale->sale_date},{$sale->created_at}\n";
        }

        return Response::make($csvData, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="tenants_sales.csv"',
        ]);
    }

    /**
     * Export distribusi tenant per kategori
     */
    public function categories()
    {
        $categories = Tenant::select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->get();

        $csvData = "Kategori,Total Tenant\n";
        foreach ($categories as $cat) {
            $csvData .= "\"{$cat->category}\",{$cat->total}\n";
        }

        return Response::make($csvData, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="tenants_categories.csv"',
        ]);
    }

    /**
     * Export penjualan harian semua tenant
     */
    public function daily()
    {
        $dailySales = Sale::select('sale_date', DB::raw('SUM(amount) as total_amount'))
            ->groupBy('sale_date')
            ->orderBy('sale_date')
            ->get();

        $csvData = "Tanggal,Total Penjualan\n";
        foreach ($dailySales as $row) {
            $csvData .= "{$row->sale_date},{$row->total_amount}\n";
        }

        return Response::make($csvData, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="tenants_daily_sales.csv"',
        ]);
    }

    /**
     * Export ringkasan total penjualan per tenant
     */
    public function summary()
    {
        $summary = Sale::select('tenant_id', DB::raw('SUM(amount) as total_sales'))
            ->groupBy('tenant_id')
            ->with('tenant')
            ->get();

        $csvData = "ID Tenant,Nama Tenant,Total Penjualan\n";
        foreach ($summary as $row) {
            $csvData .= "{$row->tenant_id},\"{$row->tenant->tenant_name}\",{$row->total_sales}\n";
        }

        return Response::make($csvData, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="tenants_summary.csv"',
        ]);
    }
}

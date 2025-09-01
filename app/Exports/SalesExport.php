<?php

namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SalesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $sales;

    public function __construct($sales)
    {
        $this->sales = $sales;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->sales;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID Transaksi',
            'Tanggal',
            'Nama Produk',
            'Jumlah',
            'Harga Satuan',
            'Subtotal',
        ];
    }

    /**
     * @param mixed $sale
     *
     * @return array
     */
    public function map($sale): array
    {
        $rows = [];
        foreach ($sale->details as $item) {
            $rows[] = [
                $sale->id,
                $sale->sale_date,
                $item->product_name,
                $item->quantity,
                $item->price,
                $item->total_price,
            ];
        }
        return $rows;
    }
}
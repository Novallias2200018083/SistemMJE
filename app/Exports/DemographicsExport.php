<?php

namespace App\Exports;

use App\Models\Attendee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class DemographicsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Attendee::select('regency', DB::raw('count(*) as total'))
            ->groupBy('regency')
            ->orderBy('total', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return ['Kabupaten', 'Jumlah Peserta'];
    }
}
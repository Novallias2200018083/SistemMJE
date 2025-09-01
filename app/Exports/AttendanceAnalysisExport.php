<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class AttendanceAnalysisExport implements FromCollection, WithHeadings
{
    protected $day;

    public function __construct(int $day)
    {
        $this->day = $day;
    }

    public function collection()
    {
        return Attendance::join('attendees', 'attendances.attendee_id', '=', 'attendees.id')
            ->where('attendances.day', $this->day)
            ->select('attendees.regency', DB::raw('count(*) as total'))
            ->groupBy('attendees.regency')
            ->orderBy('total', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Kabupaten/Kota',
            'Jumlah Kehadiran',
        ];
    }
}

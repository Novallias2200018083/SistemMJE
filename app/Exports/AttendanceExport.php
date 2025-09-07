<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AttendanceExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $day;

    public function __construct(int $day)
    {
        $this->day = $day;
    }

    /**
     * Query data dari database.
     */
    public function query()
    {
        return Attendance::query()
            ->with('attendee') // Mengambil data peserta terkait
            ->where('day', $this->day)
            ->orderBy('created_at', 'asc');
    }

    /**
     * Mendefinisikan header kolom di Excel.
     */
    public function headings(): array
    {
        return [
            'Nama Peserta',
            'Nomor Token',
            'Pekerjaan',
            'Asal Kabupaten/Kota',
            'Nomor HP',
            'Usia',
            'Jam Kehadiran',
        ];
    }

    /**
     * Memetakan data untuk setiap baris di Excel.
     * @param Attendance $attendance
     */
    public function map($attendance): array
    {
        return [
            $attendance->attendee->name,
            $attendance->attendee->token,
            $attendance->attendee->jobs,
            $attendance->attendee->regency,
            $attendance->attendee->phone_number,
            $attendance->attendee->age,
            $attendance->created_at->format('H:i:s'),
        ];
    }
}

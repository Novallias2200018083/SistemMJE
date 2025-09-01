<?php

namespace App\Exports;

use App\Models\Attendee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AttendeesExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Attendee::with('attendances')->get();
    }

    public function headings(): array
    {
        return [
            'Token', 'Nama', 'Alamat', 'Kabupaten', 'No HP', 'Usia',
            'Hadir Hari 1', 'Hadir Hari 2', 'Hadir Hari 3', 'Total Kehadiran'
        ];
    }

    public function map($attendee): array
    {
        return [
            $attendee->token,
            $attendee->name,
            $attendee->full_address,
            $attendee->regency,
            $attendee->phone_number,
            $attendee->age,
            $attendee->attendances->contains('day', 1) ? 'Ya' : 'Tidak',
            $attendee->attendances->contains('day', 2) ? 'Ya' : 'Tidak',
            $attendee->attendances->contains('day', 3) ? 'Ya' : 'Tidak',
            $attendee->attendances->count(),
        ];
    }
}
<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Exports\AttendanceExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AttendeesExport; // Tambahkan ini
use App\Exports\DemographicsExport; // Tambahkan ini
use App\Exports\AttendanceAnalysisExport; // Tambahkan ini

class ExportController extends Controller {
    public function attendance($day) {
        return Excel::download(new AttendanceExport($day), 'kehadiran-hari-'.$day.'.xlsx');
    }

    // Method baru untuk export semua data peserta
    public function completeUsers()
    {
        return Excel::download(new AttendeesExport, 'laporan-lengkap-peserta.xlsx');
    }

    // Method baru untuk export data demografi
    public function demographics()
    {
        return Excel::download(new DemographicsExport, 'laporan-demografi-peserta.xlsx');
    }
     // Method baru untuk export analisis kehadiran
    public function attendanceAnalysis($day)
    {
        return Excel::download(new AttendanceAnalysisExport($day), 'analisis-kehadiran-hari-'.$day.'.xlsx');
    }
    public function attendanceByDay(int $day)
    {
        // Validasi agar hari hanya 1, 2, atau 3
        if (!in_array($day, [1, 2, 3])) {
            return redirect()->back()->with('error', 'Hari tidak valid.');
        }

        $fileName = 'laporan-kehadiran-hari-' . $day . '-' . now()->format('Y-m-d') . '.xlsx';

        return Excel::download(new AttendanceExport($day), $fileName);
    }
}
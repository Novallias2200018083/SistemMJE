<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendee;
use App\Models\Attendance;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; // <-- Tambahkan Carbon

class AttendanceController extends Controller
{
    /**
     * 1. Definisikan tanggal event di sini.
     * PASTIKAN tanggal ini SAMA PERSIS dengan yang ada di DashboardController Anda.
     */
    private $eventDates = [
        1 => '2025-09-12',
        2 => '2025-09-13',
        3 => '2025-09-14',
    ];

    /**
     * Menampilkan halaman utama kelola kehadiran.
     * (Method ini tidak perlu diubah)
     */
    public function index(Request $request)
    {
        // --- Statistik Kartu Atas ---
        $totalAttendees = Attendee::count();
        $dailyAttendance = [];
        for ($i = 1; $i <= 3; $i++) {
            $dailyAttendance[$i] = Attendance::where('day', $i)->count();
        }

        // --- Logika untuk Tab "Absen Massal" ---
        $massAbsenDay = $request->input('mass_absen_day', 1);
        $massAbsenSearch = $request->input('mass_absen_search');
        $alreadyAttendedIds = Attendance::where('day', $massAbsenDay)->pluck('attendee_id');
        $massAbsenQuery = Attendee::whereNotIn('id', $alreadyAttendedIds);
        if ($massAbsenSearch) {
            $massAbsenQuery->where(function ($q) use ($massAbsenSearch) {
                $q->where('name', 'like', "%{$massAbsenSearch}%")
                  ->orWhere('token', 'like', "%{$massAbsenSearch}%");
            });
        }
        $massAbsenAttendees = $massAbsenQuery->latest()->get();

        // --- Logika untuk Tab "Data Kehadiran" (dengan filter & pagination) ---
        $attendanceLogQuery = Attendance::with('attendee')->latest();
        if ($request->filled('filter_log_day') && $request->filter_log_day != 'all') {
            $attendanceLogQuery->where('day', $request->filter_log_day);
        }
        $attendanceLogs = $attendanceLogQuery->paginate(15)->withQueryString();

        // --- Logika untuk Tab "Analisis" (Chart Data) ---
        $analysisDay = in_array($request->input('analysis_day'), [1, 2, 3]) ? (int)$request->input('analysis_day') : 'all';

        // Query dasar untuk analisis
        $analysisQuery = Attendance::join('attendees', 'attendances.attendee_id', '=', 'attendees.id');
        if ($analysisDay !== 'all') {
            $analysisQuery->where('attendances.day', $analysisDay);
        }

        // Distribusi Wilayah
        $regencyDistributionData = (clone $analysisQuery)
            ->select('attendees.regency', DB::raw('count(*) as total'))
            ->groupBy('attendees.regency')
            ->orderBy('total', 'desc')
            ->get();
            
        $regencyDistribution = [
            'labels' => $regencyDistributionData->pluck('regency'),
            'data' => $regencyDistributionData->pluck('total'),
        ];

        // Distribusi Usia
        $ageDistributionData = (clone $analysisQuery)
            ->select(
                DB::raw("CASE 
                    WHEN age BETWEEN 8 AND 16 THEN '8-16 thn'
                    WHEN age BETWEEN 17 AND 25 THEN '17-25 thn'
                    WHEN age BETWEEN 26 AND 35 THEN '26-35 thn'
                    WHEN age BETWEEN 36 AND 45 THEN '36-45 thn'
                    WHEN age BETWEEN 46 AND 55 THEN '46-55 thn'
                    ELSE '55+ thn' 
                END as age_group"),
                DB::raw('count(*) as total')
            )
            ->groupBy('age_group')
            ->orderBy('age_group')
            ->get();

        $ageDistribution = [
            'labels' => $ageDistributionData->pluck('age_group'),
            'data' => $ageDistributionData->pluck('total'),
        ];

        return view('admin.attendance.index', compact(
            'totalAttendees', 'dailyAttendance', 'massAbsenAttendees',
            'massAbsenDay', 'massAbsenSearch', 'attendanceLogs',
            'regencyDistribution', 'ageDistribution', 'analysisDay'
        ));
    }

    /**
     * Menyimpan presensi manual via token.
     */
    public function store(Request $request)
    {
        $request->validate([
            'token' => 'required|string|exists:attendees,token',
            'day' => 'required|integer|in:1,2,3',
        ]);

        $attendee = Attendee::where('token', $request->token)->first();
        $alreadyPresent = Attendance::where('attendee_id', $attendee->id)->where('day', $request->day)->exists();

        if ($alreadyPresent) {
            return back()->with('error', 'Peserta ini sudah melakukan presensi pada hari ke-'.$request->day);
        }

        // 2. Tentukan tanggal event berdasarkan hari yang dipilih
        $eventDate = Carbon::parse($this->eventDates[$request->day])->startOfDay();

        // 3. Simpan absensi dengan tanggal event yang benar, bukan tanggal hari ini
        Attendance::create([
            'attendee_id' => $attendee->id,
            'day' => $request->day,
            'created_at' => $eventDate,
            'updated_at' => $eventDate,
        ]);

        return back()->with('success', 'Presensi untuk '.$attendee->name.' berhasil!');
    }

    /**
     * Menyimpan presensi massal (centang).
     */
    public function storeMass(Request $request)
    {
        $request->validate([
            'attendee_ids' => 'required|array|min:1',
            'day' => 'required|integer|in:1,2,3',
        ]);

        // 2. Tentukan tanggal event berdasarkan hari yang dipilih
        $eventDate = Carbon::parse($this->eventDates[$request->day])->startOfDay();

        $attendances = [];
        foreach ($request->attendee_ids as $attendeeId) {
            $attendances[] = [
                'attendee_id' => $attendeeId,
                'day' => $request->day,
                // 3. Atur tanggal pembuatan sesuai tanggal event
                'created_at' => $eventDate,
                'updated_at' => $eventDate,
            ];
        }

        Attendance::insert($attendances);
        return redirect()->route('admin.attendance.index')->with('success', count($attendances) . ' peserta berhasil ditandai hadir.');
    }

     /**
     * [BARU] Mencari peserta berdasarkan token untuk live search (AJAX).
     */
    public function findByToken(Request $request)
    {
        $request->validate(['token' => 'required|string', 'day' => 'required|integer']);

        $attendee = Attendee::where('token', $request->token)->first();

        if (!$attendee) {
            return response()->json(['message' => 'Peserta tidak ditemukan'], 404);
        }

        $isAlreadyPresent = Attendance::where('attendee_id', $attendee->id)
                                      ->where('day', $request->day)
                                      ->exists();

        return response()->json([
            'attendee' => $attendee,
            'is_present' => $isAlreadyPresent
        ]);
    }

    /**
     * [BARU] Menyimpan presensi dan merespon dengan JSON (AJAX).
     */
    public function storeAjax(Request $request)
    {
        $request->validate([
            'token' => 'required|string|exists:attendees,token',
            'day' => 'required|integer|in:1,2,3',
        ]);

        $attendee = Attendee::where('token', $request->token)->first();
        $isAlreadyPresent = Attendance::where('attendee_id', $attendee->id)->where('day', $request->day)->exists();

        if ($isAlreadyPresent) {
            return response()->json(['message' => 'Peserta ini sudah melakukan presensi.'], 422);
        }

        $eventDate = Carbon::parse($this->eventDates[$request->day])->startOfDay();
        Attendance::create([
            'attendee_id' => $attendee->id,
            'day' => $request->day,
            'created_at' => $eventDate,
            'updated_at' => $eventDate,
        ]);
        
        return response()->json(['message' => 'Presensi untuk ' . $attendee->name . ' berhasil!']);
    }

    public function findForMassAbsen(Request $request)
{
    $request->validate([
        'day' => 'required|integer|in:1,2,3',
        'search' => 'nullable|string',
    ]);

    $day = $request->day;
    $search = $request->search;

    // Ambil ID peserta yang sudah absen pada hari yang dipilih
    $alreadyAttendedIds = Attendance::where('day', $day)->pluck('attendee_id');

    $query = Attendee::whereNotIn('id', $alreadyAttendedIds);

    if ($search) {
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('token', 'like', "%{$search}%")
              ->orWhere('phone_number', 'like', "%{$search}%")
              ->orWhere('regency', 'like', "%{$search}%");
        });
    }

    // Batasi hasil pencarian agar tidak terlalu berat, misal 50.
    $attendees = $query->latest()->take(50)->get();

    return response()->json($attendees);
}

}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendee;
use App\Models\Attendance;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Menampilkan halaman manajemen pengguna dengan data dan filter.
     */
   public function index(Request $request)
    {
        // --- Statistik Kartu ---
        $totalAttendees = Attendee::count();
        $dailyAttendance = Attendance::select('day', DB::raw('count(*) as total'))
            ->groupBy('day')
            ->pluck('total', 'day');

        // --- Logika Filter & Pencarian ---
        $query = Attendee::with('attendances');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('token', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('regency') && $request->regency != 'Semua') {
            $query->where('regency', $request->regency);
        }

        if ($request->filled('attendance_status')) {
            switch ($request->attendance_status) {
                case 'Hadir':
                    $query->whereHas('attendances');
                    break;
                case 'Tidak Hadir':
                    $query->whereDoesntHave('attendances');
                    break;
            }
        }

        $attendees = $query->latest()->paginate(6);
        $regencies = Attendee::select('regency')->distinct()->pluck('regency');

        // --- [PENAMBAHAN] Data untuk Tab Analisis ---
        $regencyDistribution = Attendee::select('regency', DB::raw('count(*) as total'))
            ->groupBy('regency')
            ->orderBy('total', 'desc')
            ->get();
        
        $ageDistribution = Attendee::select(
                DB::raw("CASE 
                    WHEN age BETWEEN 8 AND 16 THEN '8-16 tahun'
                    WHEN age BETWEEN 17 AND 25 THEN '17-25 tahun'
                    WHEN age BETWEEN 26 AND 35 THEN '26-35 tahun'
                    WHEN age BETWEEN 36 AND 45 THEN '36-45 tahun'
                    WHEN age BETWEEN 46 AND 55 THEN '46-55 tahun'
                    ELSE '55+ tahun' 
                END as age_group"),
                DB::raw('count(*) as total')
            )
            ->groupBy('age_group')
            ->orderBy('age_group')
            ->get();

        return view('admin.users.index', compact(
            'attendees',
            'totalAttendees',
            'dailyAttendance',
            'regencies',
            'regencyDistribution', // <-- [PENAMBAHAN] Mengirim data ke view
            'ageDistribution'    // <-- [PENAMBAHAN] Mengirim data ke view
        ));

        // $attendees = $query->latest()->paginate(6);
    }

    /**
     * Menampilkan form untuk menambah pengguna baru.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Menyimpan pengguna baru ke database.
     */
    // app/Http/Controllers/Admin/UserController.php

// app/Http/Controllers/Admin/UserController.php

public function store(Request $request)
{
    // 1. Validasi input dasar
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'full_address' => 'required|string',
        'regency' => 'required|string',
        'other_regency' => 'required_if:regency,Lain-lain|nullable|string|max:255',
        'phone_number' => 'required|string|min:10|max:15',
        'age' => 'required|integer|min:1',
    ]);

    // --- VALIDASI BATAS NOMOR HP DIMULAI DI SINI ---
    $phoneNumber = $validatedData['phone_number'];
    $phoneCount = Attendee::where('phone_number', $phoneNumber)->count();

    if ($phoneCount >= 3) {
        // Jika sudah 3 kali atau lebih, kembalikan ke form dengan pesan error
        return back()->withErrors([
            'phone_number' => 'Nomor HP ini telah mencapai batas maksimal pendaftaran (3 kali).'
        ])->withInput(); // withInput() agar data yang sudah diisi tidak hilang
    }
    // --- VALIDASI BATAS NOMOR HP SELESAI ---

    // Tentukan nilai regency yang akan disimpan
    $regencyToStore = $validatedData['regency'] === 'Lain-lain' 
        ? $validatedData['other_regency'] 
        : $validatedData['regency'];

    // Buat Attendee dengan token sementara
    $attendee = Attendee::create([
        'name' => $validatedData['name'],
        'full_address' => $validatedData['full_address'],
        'regency' => $regencyToStore,
        'phone_number' => $validatedData['phone_number'],
        'age' => $validatedData['age'],
        'token' => 'PENDING',
    ]);

    // Hasilkan dan update token yang benar
    $token = 'MJE-' . str_pad($attendee->id, 7, '0', STR_PAD_LEFT);
    $attendee->update(['token' => $token]);

    return redirect()->route('admin.users.index')->with('success', 'Peserta baru berhasil ditambahkan.');
}

    /**
     * Menampilkan form untuk mengedit pengguna.
     */
    public function edit(Attendee $user)
    {
        return view('admin.users.edit', ['attendee' => $user]);
    }

    /**
     * Memperbarui data pengguna di database.
     */
    public function update(Request $request, Attendee $user) // Variabel $user kita ganti jadi $attendee untuk konsistensi
{
    $attendee = $user; // Alias
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'full_address' => 'required|string',
        'regency' => 'required|string',
        'other_regency' => 'required_if:regency,Lain-lain|nullable|string|max:255',
        'phone_number' => 'required|string|min:10|max:15',
        'age' => 'required|integer|min:1',
    ]);

    $regencyToStore = $validatedData['regency'] === 'Lain-lain' 
        ? $validatedData['other_regency'] 
        : $validatedData['regency'];
    
    // Hapus other_regency dari array agar tidak coba disimpan ke database
    unset($validatedData['other_regency']);
    $validatedData['regency'] = $regencyToStore;

    $attendee->update($validatedData);

    return redirect()->route('admin.users.index')->with('success', 'Data peserta berhasil diperbarui.');
}

    /**
     * Menghapus data pengguna dari database.
     */
    public function destroy(Attendee $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Data peserta berhasil dihapus.');
    }
}

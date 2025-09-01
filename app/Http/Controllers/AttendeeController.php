<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendee;
use Illuminate\Support\Str;

class AttendeeController extends Controller
{
    // Menampilkan form pendaftaran
    public function create()
    {
        return view('public.register');
    }

    // Menyimpan data pendaftaran
    public function store(Request $request)
    {
        // 1. Validasi Input (Tetap sama)
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'full_address' => 'required|string',
            'regency' => 'required|string',
            'other_regency' => 'nullable|string|max:100', // Tambahkan validasi untuk regency lain
            'phone_number' => 'required|string|min:10|max:15',
            'age' => 'required|integer|min:1',
        ]);

        // --- MULAI LOGIKA PENGECEKAN NOMOR HP ---
        
        // Ambil nomor HP dari data yang sudah divalidasi
        $phoneNumber = $validatedData['phone_number'];

        // Hitung berapa kali nomor HP ini sudah ada di database
        $phoneCount = Attendee::where('phone_number', $phoneNumber)->count();

        // Jika nomor HP sudah terdaftar 3 kali atau lebih
        if ($phoneCount >= 3) {
            // Hentikan proses dan kembalikan ke halaman form dengan pesan error
            // withInput() akan menjaga data yang sudah diisi pengguna agar tidak hilang
            return back()->withErrors([
                'phone_number' => 'Pendaftaran gagal. Nomor HP ini telah mencapai batas maksimal pendaftaran (3 kali).'
            ])->withInput();
        }
        
        // --- SELESAI LOGIKA PENGECEKAN NOMOR HP ---

        // Menentukan nilai regency (jika "Lain-lain" dipilih)
        $regency = $validatedData['regency'];
        if ($regency === 'Lain-lain' && !empty($validatedData['other_regency'])) {
            $regency = $validatedData['other_regency'];
        }

        // 2. Jika lolos pengecekan, baru buat data peserta
        $attendee = Attendee::create([
            'name' => $validatedData['name'],
            'full_address' => $validatedData['full_address'],
            'regency' => $regency,
            'phone_number' => $validatedData['phone_number'],
            'age' => $validatedData['age'],
            'token' => 'PENDING', // Token sementara
        ]);

        // 3. Buat token berurutan berdasarkan ID yang baru dibuat
        $token = 'MJE-' . str_pad($attendee->id, 7, '0', STR_PAD_LEFT);

        // 4. Update peserta dengan token yang benar
        $attendee->token = $token;
        $attendee->save();

        // 5. Redirect ke Halaman Tiket
        return redirect()->route('ticket.show', $attendee->token)->with('success', 'Pendaftaran Berhasil!');
    }


    public function showFindForm(Request $request)
    {
        $attendees = collect();
        $query = '';
        $search_type = 'token'; // Default tab yang aktif

        if ($request->filled('token_query')) {
            $query = $request->input('token_query');
            $search_type = 'token';
            $attendees = Attendee::where('token', $query)->get();
        } 
        elseif ($request->filled('hp_query')) {
            $query = $request->input('hp_query');
            $search_type = 'hp';
            $attendees = Attendee::where('phone_number', $query)->get();
        } 
        elseif ($request->filled('nama_query')) {
            $query = $request->input('nama_query');
            $search_type = 'nama';
            $attendees = Attendee::where('name', 'LIKE', "%{$query}%")->get();
        }

        return view('public.find-ticket', [
            'attendees' => $attendees,
            'query' => $query,
            'search_type' => $search_type,
        ]);
    }
}
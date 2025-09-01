<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prize;
use App\Models\Attendee;
use App\Models\LotteryWinner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LotteryController extends Controller
{
    /**
     * Menampilkan dashboard utama pengundian.
     */
    public function index()
    {
        // Statistik
        $totalPrizes = Prize::sum('quantity');
        $drawnPrizes = LotteryWinner::count();
        $claimedPrizes = LotteryWinner::where('is_claimed', true)->count();

        // Peserta yang pernah hadir minimal 1x
        $eligibleAttendeesCount = Attendee::whereHas('attendances')->count();

        // Data untuk tabs
        $prizes = Prize::withCount('winners')->get();
        $winners = LotteryWinner::with('attendee', 'prize')->latest()->get();

        return view('admin.lottery.index', compact(
            'totalPrizes', 'drawnPrizes', 'claimedPrizes', 'eligibleAttendeesCount',
            'prizes', 'winners'
        ));
    }

    /**
     * Menyimpan hadiah baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'value' => 'nullable|numeric',
            'sponsor' => 'nullable|string',
        ]);

        Prize::create($request->all());
        return redirect()->route('admin.lottery.index')->with('success', 'Hadiah baru berhasil ditambahkan.');
    }

    /**
     * Melakukan proses pengundian untuk hadiah tertentu.
     */
    public function draw(Prize $prize)
    {
        // Cek sisa hadiah
        $drawnCount = $prize->winners()->count();
        if ($drawnCount >= $prize->quantity) {
            return back()->with('error', 'Semua hadiah ' . $prize->name . ' sudah diundi.');
        }

        // Ambil ID semua yang sudah pernah menang
        $winnerIds = LotteryWinner::pluck('attendee_id');

        // Cari 1 peserta acak yang:
        // 1. Pernah hadir (minimal 1 kali)
        // 2. Belum pernah menang hadiah apapun
        $eligibleWinner = Attendee::whereHas('attendances')
                                  ->whereNotIn('id', $winnerIds)
                                  ->inRandomOrder()
                                  ->first();

        if (!$eligibleWinner) {
            return back()->with('error', 'Tidak ada peserta yang memenuhi syarat untuk diundi.');
        }

        // Simpan sebagai pemenang
        LotteryWinner::create([
            'attendee_id' => $eligibleWinner->id,
            'prize_id' => $prize->id,
        ]);

        return redirect()->route('admin.lottery.index', ['#pemenang'])->with('success', 'Selamat! Pemenang untuk ' . $prize->name . ' adalah ' . $eligibleWinner->name);
    }

    /**
     * Menandai hadiah sudah diambil oleh pemenang.
     */
    public function claim(LotteryWinner $winner)
    {
        $winner->update(['is_claimed' => true]);
        return back()->with('success', 'Hadiah telah ditandai sebagai sudah diambil.');
    }
}

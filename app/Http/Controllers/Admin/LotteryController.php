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
 * Menampilkan halaman roulette/spin untuk hadiah tertentu.
 */
public function showSpinner(Prize $prize)
{
    // Ambil peserta eligible yang belum pernah menang
    $winnerIds = LotteryWinner::pluck('attendee_id');

    $attendees = Attendee::whereHas('attendances')
                         ->whereNotIn('id', $winnerIds)
                         ->get();

    // Pastikan view ini ada: resources/views/admin/lottery/spin.blade.php
    return view('admin.lottery.spin', compact('prize', 'attendees'));
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
public function draw(Request $request, Prize $prize)
{
    $attendeeId = $request->input('attendee_id');

    // Validasi
    $winnerIds = LotteryWinner::pluck('attendee_id');
    if (in_array($attendeeId, $winnerIds->toArray())) {
        return response()->json(['error' => 'Peserta sudah pernah menang'], 422);
    }

    $attendee = Attendee::find($attendeeId);
    if (!$attendee) {
        return response()->json(['error' => 'Peserta tidak ditemukan'], 404);
    }

    // Simpan pemenang
    LotteryWinner::create([
        'attendee_id' => $attendee->id,
        'prize_id' => $prize->id,
    ]);

    return response()->json([
        'success' => true,
        'winner' => [
            'id' => $attendee->id,
            'name' => $attendee->name,
            'phone_number' => $attendee->phone_number
        ]
    ]);
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

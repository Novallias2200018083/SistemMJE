<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prize;
use App\Models\Attendee;
use App\Models\LotteryWinner;
use Illuminate\Http\Request;

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

    // Menandai hadiah sudah diambil
    public function claim(LotteryWinner $winner)
{
    $winner->update(['is_claimed' => true]);
    return redirect()->back()->with('success', 'Hadiah berhasil ditandai sebagai diambil.');
}


    /**
     * Menyimpan hadiah baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'category'    => 'required|string',
            'quantity'    => 'required|integer|min:1',
            'value'       => 'nullable|numeric',
            'sponsor'     => 'nullable|string',
        ]);

        Prize::create($request->all());
        return redirect()->route('admin.lottery.index')->with('success', 'Hadiah baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan halaman spinner dengan semua peserta eligible.
     */
    public function showSpinner(Prize $prize)
    {
        $winnerIds = LotteryWinner::pluck('attendee_id');
        $attendees = Attendee::whereHas('attendances')
                            ->whereNotIn('id', $winnerIds)
                            ->get();

        return view('admin.lottery.spin', compact('prize', 'attendees'));
    }

    /** Melakukan undian dan simpan pemenang.**/
public function draw(Request $request, Prize $prize)
{
    $winnerIds = LotteryWinner::pluck('attendee_id');
$attendees = Attendee::whereHas('attendances')
                ->whereNotIn('id', $winnerIds)
                ->get()
                ->values();

if ($attendees->isEmpty()) {
    return response()->json(['success' => false, 'error' => 'Tidak ada peserta.'], 422);
}

$randomIndex = $attendees->keys()->random(); // pemenang
$attendee = $attendees[$randomIndex];

$lw = LotteryWinner::create([
    'attendee_id' => $attendee->id,
    'prize_id' => $prize->id,
]);

return response()->json([
    'success' => true,
    'winner' => [
        'id' => $attendee->id,
        'name' => $attendee->name,
        'phone_number' => $attendee->phone_number,
    ],
    'winner_index' => $randomIndex, // kirim ke frontend
    'attendees' => $attendees,      // kirim juga daftar peserta
]);
}
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    /**
     * Menampilkan halaman utama manajemen acara.
     */
    public function index(Request $request)
    {
        // Statistik untuk kartu di atas
        $eventStats = Event::select('day', DB::raw('count(*) as total'))
            ->groupBy('day')
            ->pluck('total', 'day');
        $totalEvents = Event::count();

        // Mengambil semua event dan mengelompokkannya berdasarkan hari
        $eventsByDay = Event::orderBy('start_time')->get()->groupBy('day');

        // Data untuk tab "Daftar Event" dengan filter
        $query = Event::orderBy('day')->orderBy('start_time');
        if ($request->filled('filter_day')) {
            $query->where('day', $request->filter_day);
        }
        $listedEvents = $query->get();

        return view('admin.events.index', compact(
            'eventStats',
            'totalEvents',
            'eventsByDay',
            'listedEvents'
        ));
    }

    /**
     * Menyimpan event baru dari modal.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'day' => 'required|integer|in:1,2,3',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        Event::create($request->all());
        return redirect()->route('admin.events.index')->with('success', 'Event baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan data event untuk form edit (API response).
     */
    public function show(Event $event)
    {
        return response()->json($event);
    }

    /**
     * Memperbarui data event dari modal.
     */
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'day' => 'required|integer|in:1,2,3',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        $event->update($request->all());
        return redirect()->route('admin.events.index')->with('success', 'Event berhasil diperbarui.');
    }

    /**
     * Menghapus event.
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Event berhasil dihapus.');
    }
}

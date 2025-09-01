<?php

// path: app/Http/Controllers/TicketController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendee;
use Barryvdh\DomPDF\Facade\Pdf;

class TicketController extends Controller
{
    public function show($token)
    {
        $attendee = Attendee::where('token', $token)->firstOrFail();
        return view('public.ticket', compact('attendee'));
    }

    public function download($token)
    {
        $attendee = Attendee::where('token', $token)->firstOrFail();

        $pdf = PDF::loadView('public.ticket_pdf', compact('attendee'));

        // Set ukuran kertas custom seperti kartu nama/tiket
        $pdf->setPaper([0, 0, 283.46, 453.54], 'portrait'); // Ukuran sekitar 10cm x 16cm

        return $pdf->download('tiket-muhammadiyah-expo-'.$attendee->token.'.pdf');
    }
}

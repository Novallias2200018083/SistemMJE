<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendee;
use Barryvdh\DomPDF\Facade\Pdf;

// import untuk endroid/qr-code
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class TicketController extends Controller
{
    private function generateQrBase64($text, $size = 200)
    {
        $qrCode = QrCode::create($text)->setSize($size);
        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        return base64_encode($result->getString());
    }

    public function show($token)
    {
        $attendee = Attendee::where('token', $token)->firstOrFail();
        $qrCodeBase64 = $this->generateQrBase64($attendee->token);

        return view('public.ticket', compact('attendee', 'qrCodeBase64'));
    }

    public function download($token)
    {
        $attendee = Attendee::where('token', $token)->firstOrFail();
        $qrCodeBase64 = $this->generateQrBase64($attendee->token);

        $pdf = PDF::loadView('public.ticket_pdf', compact('attendee', 'qrCodeBase64'));

        $pdf->setPaper([0, 0, 283.46, 453.54], 'portrait'); 

        return $pdf->download('tiket-muhammadiyah-expo-' . $attendee->token . '.pdf');
    }
}

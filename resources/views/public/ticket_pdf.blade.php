<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Ticket - {{ $attendee->token }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            background: #f1f5f9;
            text-align: center;
            margin: 0;
            padding: 20px;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .ticket-card {
            width: 380px;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            margin: 0 auto;
            position: relative;
        }

        /* Header with modern gradient */
        .ticket-header {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 50%, #0369a1 100%);
            color: white;
            padding: 24px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
            position: relative;
            z-index: 2;
        }

        .event-logo {
            font-size: 16px;
            font-weight: 900;
            color: #0284c7;
            background: linear-gradient(135deg, #ffffff 0%, #f0f9ff 100%);
            padding: 8px 16px;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .event-year {
            font-size: 14px;
            font-weight: 800;
            opacity: 0.9;
            background: rgba(255, 255, 255, 0.15);
            padding: 4px 12px;
            border-radius: 20px;
        }

        .ticket-title {
            font-size: 24px;
            font-weight: 900;
            margin-bottom: 8px;
            position: relative;
            z-index: 2;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .event-name {
            font-size: 13px;
            font-weight: 600;
            opacity: 0.9;
            position: relative;
            z-index: 2;
            letter-spacing: 0.5px;
        }

        /* Ticket body */
        .ticket-body {
            padding: 28px;
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
        }

        .section-title {
            font-size: 12px;
            font-weight: 800;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 20px;
            position: relative;
            padding-left: 16px;
        }

        .section-title::before {
            content: "";
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 16px;
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
            border-radius: 2px;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 18px;
            margin-bottom: 24px;
        }

        .detail-item {
            background: white;
            padding: 16px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
        }

        .detail-label {
            font-size: 11px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }

        .detail-value {
            font-size: 15px;
            font-weight: 700;
            color: #1e293b;
            line-height: 1.4;
        }

        /* Token section with attractive design */
        .token-section {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border-radius: 16px;
            padding: 24px;
            text-align: center;
            margin-top: 24px;
            border: 2px solid #bae6fd;
            position: relative;
        }

        .token-label {
            font-size: 12px;
            font-weight: 800;
            color: #0369a1;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
        }

        .token-value {
            font-size: 28px;
            font-weight: 900;
            color: #0284c7;
            font-family: 'Plus Jakarta Sans', sans-serif;
            letter-spacing: 2px;
            margin: 12px 0;
            padding: 16px;
            background: white;
            border-radius: 12px;
            border: 2px solid #7dd3fc;
            box-shadow: 0 8px 16px -4px rgba(14, 165, 233, 0.2);
        }

        .token-instruction {
            font-size: 11px;
            color: #0369a1;
            font-weight: 600;
            margin-top: 12px;
            background: rgba(255, 255, 255, 0.8);
            padding: 8px 12px;
            border-radius: 20px;
            display: inline-block;
        }

        /* Footer with elegant design */
        .ticket-footer {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            padding: 20px 28px;
            color: white;
        }

        .footer-text {
            font-size: 11px;
            color: #cbd5e1;
            line-height: 1.6;
            text-align: center;
        }

        .footer-highlight {
            font-weight: 800;
            color: #38bdf8;
        }

        /* Print styles */
        @media print {
            @page {
                size: A4;
                margin: 0;
            }

            body {
                background: white;
                padding: 0;
            }

            .ticket-card {
                box-shadow: none;
                border: 1px solid #ccc;
                max-width: 100%;
                margin: 0;
            }
        }
    </style>
</head>

<body>
    <div class="ticket-card">
        <div class="ticket-header">
            <div class="header-top">
                <div class="event-logo">MJE</div>
                <div class="event-year">2025</div>
            </div>
            <h1 class="ticket-title">E-TICKET</h1>
            <p class="event-name">MUHAMMADIYAH JOGJA EXPO</p>
        </div>

        <div class="ticket-body">
            <h2 class="section-title">Informasi Peserta</h2>

            <div class="detail-grid">
                <div class="detail-item">
                    <div class="detail-label">Nama Lengkap</div>
                    <div class="detail-value">{{ $attendee->name }}</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Alamat</div>
                    <div class="detail-value">{{ $attendee->full_address }}</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Kabupaten/Kota</div>
                    <div class="detail-value">{{ $attendee->regency }}</div>
                </div>
            </div>

            <div class="token-section">
                <div class="token-label">Kode Tiket Anda</div>
                <div class="token-value">{{ $attendee->token }}</div>
                <div class="flex justify-center mt-4">
                    <img src="data:image/png;base64,{{ $qrCodeBase64 }}" alt="QR Code" width="150">
                </div>
                <div class="token-instruction">Tunjukkan kode ini saat registrasi</div>
            </div>
        </div>

        <div class="ticket-footer">
            <p class="footer-text">
                <span class="footer-highlight">Harap simpan tiket ini dengan baik.</span><br>
                Tiket ini berlaku untuk satu orang dan harus ditunjukkan saat registrasi di lokasi acara.
            </p>
        </div>
    </div>
</body>

</html>

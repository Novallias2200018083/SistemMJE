<x-admin-layout>
    <x-slot name="header">Undian: {{ $prize->name }}</x-slot>
    <x-slot name="subheader">Roulette Animasi Sinkron</x-slot>

    <div class="flex flex-col items-center justify-center py-12">
        <div class="relative">
            <canvas id="rouletteCanvas" width="600" height="600"></canvas>
            <!-- Pointer -->
            <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-4">
                <svg width="36" height="36" viewBox="0 0 20 20">
                    <polygon points="0,0 20,0 10,20" fill="#e11d48"/>
                </svg>
            </div>
        </div>

        <button id="btnSpin" class="mt-6 px-6 py-3 bg-teal-600 text-white rounded-lg font-semibold">Spin!</button>
        <div id="winner" class="mt-6 text-center text-2xl font-bold text-green-600"></div>

        <a href="{{ route('admin.lottery.index') }}" class="mt-6 px-4 py-2 bg-gray-800 text-white rounded-lg">Kembali ke Daftar Hadiah</a>
    </div>

    @php
        $attendeesArray = $attendees->map(function($a) {
            return [
                'id' => $a->id,
                'name' => $a->name,
                'phone' => $a->phone_number ?? ''
            ];
        })->values();
    @endphp

    <script>
        const attendees = @json($attendeesArray);
        const prizeId = {{ $prize->id }};
        const canvas = document.getElementById('rouletteCanvas');
        const ctx = canvas.getContext('2d');
        const radius = canvas.width / 2;
        const btnSpin = document.getElementById('btnSpin');
        const winnerDiv = document.getElementById('winner');

        if (!attendees || attendees.length === 0) {
            btnSpin.disabled = true;
            winnerDiv.innerText = 'Tidak ada peserta eligible untuk diundi.';
        }

        const segments = attendees; // tetap urut
        const anglePerSegmentDeg = 360 / segments.length;

        function drawWheel(rotationDeg = 0) {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.save();
            ctx.translate(radius, radius);
            ctx.rotate(rotationDeg * Math.PI / 180);
            ctx.translate(-radius, -radius);

            segments.forEach((seg, i) => {
                const startAngle = (i * anglePerSegmentDeg) * Math.PI / 180;
                const endAngle = ((i + 1) * anglePerSegmentDeg) * Math.PI / 180;

                ctx.beginPath();
                ctx.moveTo(radius, radius);
                ctx.arc(radius, radius, radius - 10, startAngle, endAngle);
                ctx.closePath();
                ctx.fillStyle = i % 2 === 0 ? '#D32F2F' : '#388E3C';
                ctx.fill();
                ctx.strokeStyle = '#111';
                ctx.lineWidth = 2;
                ctx.stroke();

                // Nama peserta
                ctx.save();
                ctx.translate(radius, radius);
                ctx.rotate(startAngle + (endAngle - startAngle)/2);
                ctx.textAlign = "right";
                ctx.fillStyle = "#fff";
                ctx.font = "bold 14px Poppins, Arial";
                const label = seg.name.length > 18 ? seg.name.substring(0,18)+'…' : seg.name;
                ctx.fillText(label, radius - 30, 5);
                ctx.restore();
            });

            // Lingkaran tengah
            ctx.beginPath();
            ctx.arc(radius, radius, 50, 0, 2*Math.PI);
            ctx.fillStyle = '#111';
            ctx.fill();
            ctx.strokeStyle = '#000';
            ctx.lineWidth = 2;
            ctx.stroke();

            ctx.restore();
        }

        drawWheel(); // render awal

        btnSpin.addEventListener('click', async () => {
    btnSpin.disabled = true;
    winnerDiv.innerText = '';

    try {
        const res = await fetch(`/admin/lottery/draw/${prizeId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        const data = await res.json();
        if(!data.success) throw new Error('Pemenang tidak valid');

        const attendees = data.attendees.map(a => ({
            id: a.id,
            name: a.name,
            phone: a.phone_number || ''
        }));

        const winnerIndex = data.winner_index;
        const winner = attendees[winnerIndex];

        // Optional: bisa shuffle peserta dulu tapi tetap sisipkan pemenang di segmen tertentu
        const segments = [...attendees]; // urutannya sesuai backend

        const anglePerSegmentDeg = 360 / segments.length;
        const targetAngleDeg = winnerIndex * anglePerSegmentDeg + anglePerSegmentDeg/2;

        const spins = 8 + Math.floor(Math.random()*4);
        const finalRotationDeg = spins*360 + targetAngleDeg;
        const duration = 5500 + Math.floor(Math.random()*1200);
        const startTime = performance.now();

        function animate(now) {
            const elapsed = now - startTime;
            const t = Math.min(elapsed/duration, 1);
            const ease = 1 - Math.pow(1-t, 3);
            const currentDeg = ease * finalRotationDeg;

            drawWheel(currentDeg);

            if(t < 1) requestAnimationFrame(animate);
            else {
                drawWheel(finalRotationDeg);
                winnerDiv.innerText = `🎉 Pemenang: ${winner.name} (${winner.phone})`;
                btnSpin.disabled = false;
            }
        }

        requestAnimationFrame(animate);

    } catch(e) {
        console.error(e);
        alert('Terjadi kesalahan server.');
        btnSpin.disabled = false;
    }
});

    </script>
</x-admin-layout>

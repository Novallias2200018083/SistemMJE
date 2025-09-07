<x-admin-layout>
    <x-slot name="header">Undian: {{ $prize->name }}</x-slot>
    <x-slot name="subheader">Roulette Animasi</x-slot>

    <div class="flex flex-col items-center justify-center py-12 relative">
        <div class="relative">
            <canvas id="rouletteCanvas" width="600" height="600"></canvas>
            <!-- Pointer -->
            <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-4 z-10">
                <svg width="36" height="36" viewBox="0 0 20 20">
                    <polygon points="0,0 20,0 10,20" fill="#e11d48"/>
                </svg>
            </div>
        </div>

        <button id="btnSpin" class="mt-6 px-6 py-3 bg-teal-600 text-white rounded-lg font-semibold z-10">Spin!</button>

        <a href="{{ route('admin.lottery.index') }}" class="mt-6 px-4 py-2 bg-gray-800 text-white rounded-lg z-10">Kembali ke Daftar Hadiah</a>
    </div>

    <!-- Overlay Pemenang -->
    <div id="winnerOverlay" class="fixed inset-0 bg-black bg-opacity-90 flex items-center justify-center hidden z-50">
        <div id="winnerText" class="text-5xl md:text-7xl text-white font-bold animate-winner"></div>
    </div>

    @php
        $attendeesArray = $attendees->map(function($a){
            return [
                'id' => $a->id,
                'name' => $a->name,
                'phone' => $a->phone_number ?? ''
            ];
        })->values();
    @endphp

    <script>
        const TOTAL_SEGMENTS = 20;
        const actualSegments = @json($attendeesArray);

        // Buat segmen hingga total 20
        const segments = [...actualSegments];
        while (segments.length < TOTAL_SEGMENTS) {
            segments.push({ id: null, name: '' }); // dummy
        }

        const canvas = document.getElementById('rouletteCanvas');
        const ctx = canvas.getContext('2d');
        const radius = canvas.width / 2;
        const btnSpin = document.getElementById('btnSpin');
        const winnerOverlay = document.getElementById('winnerOverlay');
        const winnerText = document.getElementById('winnerText');
        const prizeId = {{ $prize->id }};
        const anglePerSegmentDeg = 360 / TOTAL_SEGMENTS;

        function drawWheel(rotationDeg = 0) {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.save();
            ctx.translate(radius, radius);
            ctx.rotate(rotationDeg * Math.PI / 180);
            ctx.translate(-radius, -radius);

            segments.forEach((seg, i) => {
                const startAngle = i * anglePerSegmentDeg * Math.PI / 180;
                const endAngle = (i + 1) * anglePerSegmentDeg * Math.PI / 180;

                ctx.beginPath();
                ctx.moveTo(radius, radius);
                ctx.arc(radius, radius, radius - 10, startAngle, endAngle);
                ctx.closePath();
                ctx.fillStyle = i % 2 === 0 ? '#D32F2F' : '#388E3C';
                ctx.fill();
                ctx.strokeStyle = '#111';
                ctx.lineWidth = 2;
                ctx.stroke();
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

        drawWheel();

        btnSpin.addEventListener('click', async () => {
            btnSpin.disabled = true;

            try {
                const res = await fetch(`/admin/lottery/draw/${prizeId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                const data = await res.json();
                if (!data.success || !data.winner) throw new Error('Pemenang tidak valid.');

                const winner = data.winner;
                const winnerIndex = data.winner_index;

                // Hitung rotasi agar berhenti di segmen random (animasi saja)
                const targetAngleDeg = (TOTAL_SEGMENTS - Math.floor(Math.random()*TOTAL_SEGMENTS)) * anglePerSegmentDeg - anglePerSegmentDeg/2;
                const spins = 6 + Math.floor(Math.random()*3);
                const finalRotationDeg = spins * 360 + targetAngleDeg;
                const duration = 4000; // 4 detik spin
                const startTime = performance.now();

                function animate(now){
                    const elapsed = now - startTime;
                    const t = Math.min(elapsed/duration, 1);
                    const ease = 1 - Math.pow(1 - t, 3); // cubic ease-out
                    const currentDeg = ease * finalRotationDeg;

                    drawWheel(currentDeg);

                    if(t < 1) requestAnimationFrame(animate);
                    else showWinner();
                }

                requestAnimationFrame(animate);

                function showWinner(){
                    winnerText.innerText = `${winner.name} (${winner.phone_number ?? ''})`;
                    winnerOverlay.classList.remove('hidden');

                    setTimeout(() => {
                        winnerOverlay.classList.add('hidden');
                        window.location.href = "{{ route('admin.lottery.index') }}";
                    }, 3500); // tampil 3.5 detik
                }

            } catch(e) {
                console.error(e);
                alert('Terjadi kesalahan jaringan/server.');
                btnSpin.disabled = false;
            }
        });
    </script>

    <style>
        @keyframes winnerAnimation {
            0% { transform: translateY(-50px) scale(0.5); opacity: 0; }
            50% { transform: translateY(20px) scale(1.2); opacity: 1; }
            100% { transform: translateY(0) scale(1); opacity: 1; }
        }
        .animate-winner {
            animation: winnerAnimation 3.5s ease forwards;
        }
    </style>
</x-admin-layout>

<x-admin-layout>
    <x-slot name="header">Undian: {{ $prize->name }}</x-slot>
    <x-slot name="subheader">Roulette Animasi Realistis</x-slot>

    <div class="flex flex-col items-center justify-center py-12">
        <div class="relative">
            <canvas id="rouletteCanvas" width="500" height="500"></canvas>
            <!-- Pointer -->
            <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-4">
                <svg width="30" height="30" viewBox="0 0 20 20">
                    <!-- Panah menghadap ke bawah -->
                    <polygon points="0,0 20,0 10,20" fill="red"/>
                </svg>
            </div>
        </div>

        <button id="btnSpin" class="mt-6 px-6 py-3 bg-teal-600 text-white rounded-lg font-semibold">Spin!</button>
        <div id="winner" class="mt-6 text-center text-2xl font-bold text-green-600"></div>

        <a href="{{ route('admin.lottery.index') }}" class="mt-6 px-4 py-2 bg-gray-800 text-white rounded-lg">Kembali ke Daftar Hadiah</a>
    </div>

    <script>
        const attendees = @json($attendees);
        const prizeId = {{ $prize->id }};
        const canvas = document.getElementById('rouletteCanvas');
        const ctx = canvas.getContext('2d');
        const radius = canvas.width / 2;
        const btnSpin = document.getElementById('btnSpin');
        const winnerDiv = document.getElementById('winner');

        // Pastikan minimal 20 segmen
        const segments = Math.max(attendees.length, 20);
        const anglePerSegment = 2 * Math.PI / segments;
        let currentAngle = 0;

        function drawRoulette() {
            for (let i = 0; i < segments; i++) {
                const startAngle = i * anglePerSegment;
                const endAngle = startAngle + anglePerSegment;

                // Warna segmen berulang merah/hijau seperti roulette asli
                ctx.fillStyle = i % 2 === 0 ? '#D32F2F' : '#388E3C';
                ctx.strokeStyle = '#000';
                ctx.lineWidth = 2;
                ctx.beginPath();
                ctx.moveTo(radius, radius);
                ctx.arc(radius, radius, radius - 10, startAngle, endAngle);
                ctx.closePath();
                ctx.fill();
                ctx.stroke();

                // Nama peserta di segmen, hanya jika ada peserta
                if (attendees[i % attendees.length]) {
                    ctx.save();
                    ctx.translate(radius, radius);
                    ctx.rotate(startAngle + anglePerSegment / 2);
                    ctx.textAlign = "right";
                    ctx.fillStyle = "#fff";
                    ctx.font = "12px Arial";
                    ctx.fillText(attendees[i % attendees.length].name, radius - 20, 5);
                    ctx.restore();
                }
            }

            // Lingkaran tengah seperti roulette asli
            ctx.beginPath();
            ctx.arc(radius, radius, 40, 0, 2*Math.PI);
            ctx.fillStyle = '#222';
            ctx.fill();
            ctx.strokeStyle = '#000';
            ctx.lineWidth = 2;
            ctx.stroke();
        }

        drawRoulette();

        btnSpin.addEventListener('click', async () => {
            btnSpin.disabled = true;
            winnerDiv.innerText = '';

            // Tentukan pemenang acak
            const randomIndex = Math.floor(Math.random() * attendees.length);
            const winner = attendees[randomIndex];

            // Hitung sudut target sehingga panah menujuk ke pemenang
            const targetSegment = randomIndex;
            const targetAngle = (segments - targetSegment) * anglePerSegment - anglePerSegment/2;

            // Tambahkan beberapa putaran penuh untuk efek spin
            const spins = 15;
            const totalRotation = spins * 2 * Math.PI + targetAngle;
            const duration = 6000;
            const start = performance.now();

            function animate(now) {
                const elapsed = now - start;
                const progress = Math.min(elapsed / duration, 1);
                const easeOut = 1 - Math.pow(1 - progress, 3); // ease-out cubic
                currentAngle = easeOut * totalRotation;

                ctx.clearRect(0, 0, canvas.width, canvas.height);
                ctx.save();
                ctx.translate(radius, radius);
                ctx.rotate(currentAngle);
                ctx.translate(-radius, -radius);
                drawRoulette();
                ctx.restore();

                if(progress < 1){
                    requestAnimationFrame(animate);
                } else {
                    winnerDiv.innerText = `Pemenang: ${winner.name} (${winner.phone_number})`;

                    // Kirim ke backend
                    fetch(`/admin/lottery/draw/${prizeId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ attendee_id: winner.id })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if(data.success){
                            console.log('Pemenang tersimpan.');
                        }
                    });
                }
            }

            requestAnimationFrame(animate);
        });
    </script>
</x-admin-layout>

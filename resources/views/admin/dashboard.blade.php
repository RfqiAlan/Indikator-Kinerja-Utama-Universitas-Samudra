<x-admin-layout activePage="dashboard">
    <div class="mb-6 lg:mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between" data-aos="fade-up">
        <div>
            <h1 class="text-2xl lg:text-3xl font-bold text-slate-800">Dashboard Admin</h1>
            <p class="text-slate-500 mt-1 text-sm lg:text-base">Pantau data IKU seluruh fakultas</p>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="self-start sm:self-auto">
            @csrf
            <button type="submit" class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-rose-600 text-white text-sm font-semibold hover:bg-rose-700 transition">
                Logout
            </button>
        </form>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6 mb-6 lg:mb-8" data-aos="fade-up" data-aos-delay="100">
        <div class="bg-white rounded-xl lg:rounded-2xl shadow-sm p-4 lg:p-6">
            <div class="flex items-center gap-3 lg:gap-4">
                <div class="w-12 h-12 lg:w-14 lg:h-14 rounded-xl bg-emerald-100 flex items-center justify-center">
                    <svg class="w-6 h-6 lg:w-7 lg:h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs lg:text-sm text-slate-500">Total User</p>
                    <p class="text-2xl lg:text-3xl font-bold text-slate-800">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl lg:rounded-2xl shadow-sm p-4 lg:p-6">
            <div class="flex items-center gap-3 lg:gap-4">
                <div class="w-12 h-12 lg:w-14 lg:h-14 rounded-xl bg-cyan-100 flex items-center justify-center">
                    <svg class="w-6 h-6 lg:w-7 lg:h-7 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs lg:text-sm text-slate-500">Total Fakultas</p>
                    <p class="text-2xl lg:text-3xl font-bold text-slate-800">{{ count($fakultasStats) }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl lg:rounded-2xl shadow-sm p-4 lg:p-6 sm:col-span-2 lg:col-span-1">
            <div class="flex items-center gap-3 lg:gap-4">
                <div class="w-12 h-12 lg:w-14 lg:h-14 rounded-xl bg-amber-100 flex items-center justify-center">
                    <svg class="w-6 h-6 lg:w-7 lg:h-7 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs lg:text-sm text-slate-500">Total Aktivitas</p>
                    <p class="text-2xl lg:text-3xl font-bold text-slate-800">{{ $totalActivities }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Export Section -->
    <div class="bg-gradient-to-r from-emerald-500 to-teal-600 rounded-xl lg:rounded-2xl shadow-sm p-4 lg:p-6 mb-6 lg:mb-8 text-white" data-aos="fade-up" data-aos-delay="200">
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
            <div>
                <h2 class="text-lg lg:text-xl font-bold flex items-center gap-2">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Download Rekap IKU
                </h2>
                <p class="text-emerald-100 text-sm mt-1">Export data IKU dalam format Excel (XLSX)</p>
            </div>
            <form action="{{ route('admin.export') }}" method="GET" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 w-full lg:w-auto">
                <select name="fakultas" class="px-3 py-2 rounded-lg bg-white/20 border border-white/30 text-white text-sm focus:ring-2 focus:ring-white/50 focus:border-transparent backdrop-blur-sm">
                    <option value="" class="text-slate-800">Semua Fakultas</option>
                    @foreach(config('unsam.fakultas') as $kode => $data)
                        <option value="{{ $kode }}" class="text-slate-800">{{ $data['nama'] }}</option>
                    @endforeach
                </select>
                <select name="tahun" class="px-3 py-2 rounded-lg bg-white/20 border border-white/30 text-white text-sm focus:ring-2 focus:ring-white/50 focus:border-transparent backdrop-blur-sm">
                    @foreach($availableYears as $year)
                        <option value="{{ $year }}" class="text-slate-800" {{ $tahunAkademik === $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
                <button type="submit" class="inline-flex items-center justify-center px-4 py-2 bg-white text-emerald-600 rounded-lg font-semibold text-sm hover:bg-emerald-50 transition-colors shadow-md">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Download XLSX
                </button>
            </form>
        </div>
    </div>

    @php
        $chartLabels = collect($fakultasStats)->pluck('nama')->values();
        $iku1Counts = collect($fakultasStats)->pluck('iku1_count')->values();
        $iku2Counts = collect($fakultasStats)->pluck('iku2_count')->values();
        $iku3Counts = collect($fakultasStats)->pluck('iku3_count')->values();
        $iku4Counts = collect($fakultasStats)->pluck('iku4_count')->values();
        $iku5Counts = collect($fakultasStats)->pluck('iku5_count')->values();
        $iku6Counts = collect($fakultasStats)->pluck('iku6_count')->values();
        $iku7Counts = collect($fakultasStats)->pluck('iku7_count')->values();
        $iku8Counts = collect($fakultasStats)->pluck('iku8_count')->values();
        $iku9Counts = collect($fakultasStats)->pluck('iku9_count')->values();
        $iku10Counts = collect($fakultasStats)->pluck('iku10_count')->values();
        $iku11Counts = collect($fakultasStats)->pluck('iku11_count')->values();
        $userCounts = collect($fakultasStats)->pluck('user_count')->values();
        $totalIkuByFaculty = collect($fakultasStats)->map(fn ($item) =>
            $item['iku1_count'] + $item['iku2_count'] + $item['iku3_count'] + $item['iku4_count'] +
            $item['iku5_count'] + $item['iku6_count'] + $item['iku7_count'] + $item['iku8_count'] +
            $item['iku9_count'] + $item['iku10_count'] + $item['iku11_count']
        )->values();
        $ikuTotals = [
            $iku1Counts->sum(),
            $iku2Counts->sum(),
            $iku3Counts->sum(),
            $iku4Counts->sum(),
            $iku5Counts->sum(),
            $iku6Counts->sum(),
            $iku7Counts->sum(),
            $iku8Counts->sum(),
            $iku9Counts->sum(),
            $iku10Counts->sum(),
            $iku11Counts->sum(),
        ];
    @endphp

    <!-- Charts Section -->
    <div class="grid grid-cols-1 xl:grid-cols-2 2xl:grid-cols-4 gap-4 lg:gap-6 mb-6 lg:mb-8" data-aos="fade-up">
        <div class="bg-white rounded-xl lg:rounded-2xl shadow-sm p-4 lg:p-6">
            <h2 class="text-base lg:text-lg font-bold text-slate-800 mb-4">Sebaran IKU per Fakultas</h2>
            <div class="h-64">
                <canvas id="ikuStackedChart"></canvas>
            </div>
        </div>
        <div class="bg-white rounded-xl lg:rounded-2xl shadow-sm p-4 lg:p-6">
            <h2 class="text-base lg:text-lg font-bold text-slate-800 mb-4">Jumlah User per Fakultas</h2>
            <div class="h-64">
                <canvas id="userFacultyChart"></canvas>
            </div>
        </div>
        <div class="bg-white rounded-xl lg:rounded-2xl shadow-sm p-4 lg:p-6">
            <h2 class="text-base lg:text-lg font-bold text-slate-800 mb-4">Proporsi Total IKU 1-11</h2>
            <div class="h-64">
                <canvas id="ikuShareChart"></canvas>
            </div>
        </div>
        <div class="bg-white rounded-xl lg:rounded-2xl shadow-sm p-4 lg:p-6">
            <h2 class="text-base lg:text-lg font-bold text-slate-800 mb-4">Total Data IKU per Fakultas</h2>
            <div class="h-64">
                <canvas id="ikuTotalFacultyChart"></canvas>
            </div>
        </div>
    </div>
    <!-- Faculty Overview -->
    <div class="bg-white rounded-xl lg:rounded-2xl shadow-sm p-4 lg:p-6 mb-6 lg:mb-8" data-aos="fade-up">
        <h2 class="text-lg lg:text-xl font-bold text-slate-800 mb-4 lg:mb-6">Data per Fakultas ({{ $tahunAkademik }})</h2>
        @php
            $ikuMeta = [
                ['key' => 'iku1_count', 'label' => 'IKU1', 'text_class' => 'text-emerald-600', 'badge_class' => 'bg-emerald-100 text-emerald-600'],
                ['key' => 'iku2_count', 'label' => 'IKU2', 'text_class' => 'text-cyan-600', 'badge_class' => 'bg-cyan-100 text-cyan-600'],
                ['key' => 'iku3_count', 'label' => 'IKU3', 'text_class' => 'text-teal-600', 'badge_class' => 'bg-teal-100 text-teal-600'],
                ['key' => 'iku4_count', 'label' => 'IKU4', 'text_class' => 'text-blue-600', 'badge_class' => 'bg-blue-100 text-blue-600'],
                ['key' => 'iku5_count', 'label' => 'IKU5', 'text_class' => 'text-indigo-600', 'badge_class' => 'bg-indigo-100 text-indigo-600'],
                ['key' => 'iku6_count', 'label' => 'IKU6', 'text_class' => 'text-violet-600', 'badge_class' => 'bg-violet-100 text-violet-600'],
                ['key' => 'iku7_count', 'label' => 'IKU7', 'text_class' => 'text-purple-600', 'badge_class' => 'bg-purple-100 text-purple-600'],
                ['key' => 'iku8_count', 'label' => 'IKU8', 'text_class' => 'text-fuchsia-600', 'badge_class' => 'bg-fuchsia-100 text-fuchsia-600'],
                ['key' => 'iku9_count', 'label' => 'IKU9', 'text_class' => 'text-amber-600', 'badge_class' => 'bg-amber-100 text-amber-600'],
                ['key' => 'iku10_count', 'label' => 'IKU10', 'text_class' => 'text-orange-600', 'badge_class' => 'bg-orange-100 text-orange-600'],
                ['key' => 'iku11_count', 'label' => 'IKU11', 'text_class' => 'text-rose-600', 'badge_class' => 'bg-rose-100 text-rose-600'],
            ];
        @endphp
        
        <!-- Mobile Cards -->
        <div class="lg:hidden space-y-4">
            @foreach($fakultasStats as $kode => $data)
            <div class="border border-slate-200 rounded-xl p-4">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <p class="font-semibold text-slate-800">{{ $data['nama'] }}</p>
                        <p class="text-xs text-slate-500">{{ strtoupper($kode) }}</p>
                    </div>
                    <a href="{{ route('admin.fakultas', $kode) }}" class="text-sm text-emerald-600 font-medium">Detail →</a>
                </div>
                <div class="grid grid-cols-3 gap-2 text-center">
                    <div class="bg-slate-50 rounded-lg p-2">
                        <p class="text-xs text-slate-500">User</p>
                        <p class="font-bold text-emerald-600">{{ $data['user_count'] }}</p>
                    </div>
                    @foreach($ikuMeta as $iku)
                    <div class="bg-slate-50 rounded-lg p-2">
                        <p class="text-xs text-slate-500">{{ $iku['label'] }}</p>
                        <p class="font-bold {{ $data[$iku['key']] > 0 ? $iku['text_class'] : 'text-slate-400' }}">{{ $data[$iku['key']] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        <!-- Desktop Table -->
        <div class="hidden lg:block overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50">
                        <th class="px-4 py-3 text-left text-sm font-semibold text-slate-600">Fakultas</th>
                        <th class="px-4 py-3 text-center text-sm font-semibold text-slate-600">User</th>
                        @foreach($ikuMeta as $iku)
                        <th class="px-4 py-3 text-center text-sm font-semibold text-slate-600">{{ $iku['label'] }}</th>
                        @endforeach
                        <th class="px-4 py-3 text-center text-sm font-semibold text-slate-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($fakultasStats as $kode => $data)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-4">
                            <p class="font-semibold text-slate-800">{{ $data['nama'] }}</p>
                            <p class="text-xs text-slate-500">{{ strtoupper($kode) }}</p>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 font-semibold">
                                {{ $data['user_count'] }}
                            </span>
                        </td>
                        @foreach($ikuMeta as $iku)
                        <td class="px-4 py-4 text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full {{ $data[$iku['key']] > 0 ? $iku['badge_class'] : 'bg-slate-100 text-slate-400' }} font-semibold">
                                {{ $data[$iku['key']] }}
                            </span>
                        </td>
                        @endforeach
                        <td class="px-4 py-4 text-center">
                            <a href="{{ route('admin.fakultas', $kode) }}" class="text-sm text-emerald-600 hover:text-emerald-800 font-medium">
                                Detail →
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        const chartLabels = @json($chartLabels);
        const iku1Counts = @json($iku1Counts);
        const iku2Counts = @json($iku2Counts);
        const iku3Counts = @json($iku3Counts);
        const iku4Counts = @json($iku4Counts);
        const iku5Counts = @json($iku5Counts);
        const iku6Counts = @json($iku6Counts);
        const iku7Counts = @json($iku7Counts);
        const iku8Counts = @json($iku8Counts);
        const iku9Counts = @json($iku9Counts);
        const iku10Counts = @json($iku10Counts);
        const iku11Counts = @json($iku11Counts);
        const userCounts = @json($userCounts);
        const ikuTotals = @json($ikuTotals);
        const totalIkuByFaculty = @json($totalIkuByFaculty);

        const ikuLabels = [
            'IKU 1', 'IKU 2', 'IKU 3', 'IKU 4', 'IKU 5',
            'IKU 6', 'IKU 7', 'IKU 8', 'IKU 9', 'IKU 10', 'IKU 11'
        ];
        const ikuColors = [
            '#10b981', '#0ea5e9', '#14b8a6', '#a855f7', '#f97316',
            '#facc15', '#22c55e', '#38bdf8', '#fb7185', '#6366f1', '#f59e0b'
        ];

        const stackedCtx = document.getElementById('ikuStackedChart');
        if (stackedCtx) {
            new Chart(stackedCtx, {
                type: 'bar',
                data: {
                    labels: chartLabels,
                    datasets: [
                        { label: 'IKU 1', data: iku1Counts, backgroundColor: ikuColors[0] },
                        { label: 'IKU 2', data: iku2Counts, backgroundColor: ikuColors[1] },
                        { label: 'IKU 3', data: iku3Counts, backgroundColor: ikuColors[2] },
                        { label: 'IKU 4', data: iku4Counts, backgroundColor: ikuColors[3] },
                        { label: 'IKU 5', data: iku5Counts, backgroundColor: ikuColors[4] },
                        { label: 'IKU 6', data: iku6Counts, backgroundColor: ikuColors[5] },
                        { label: 'IKU 7', data: iku7Counts, backgroundColor: ikuColors[6] },
                        { label: 'IKU 8', data: iku8Counts, backgroundColor: ikuColors[7] },
                        { label: 'IKU 9', data: iku9Counts, backgroundColor: ikuColors[8] },
                        { label: 'IKU 10', data: iku10Counts, backgroundColor: ikuColors[9] },
                        { label: 'IKU 11', data: iku11Counts, backgroundColor: ikuColors[10] },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom' },
                    },
                    scales: {
                        x: { stacked: true },
                        y: { stacked: true, beginAtZero: true, ticks: { precision: 0 } },
                    },
                },
            });
        }

        const userCtx = document.getElementById('userFacultyChart');
        if (userCtx) {
            new Chart(userCtx, {
                type: 'bar',
                data: {
                    labels: chartLabels,
                    datasets: [
                        { label: 'Jumlah User', data: userCounts, backgroundColor: '#fbbf24' },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true, ticks: { precision: 0 } } },
                },
            });
        }

        const shareCtx = document.getElementById('ikuShareChart');
        if (shareCtx) {
            new Chart(shareCtx, {
                type: 'doughnut',
                data: {
                    labels: ikuLabels,
                    datasets: [{
                        data: ikuTotals,
                        backgroundColor: ikuColors,
                        borderWidth: 0,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom' },
                    },
                    cutout: '65%',
                },
            });
        }

        const totalFacultyCtx = document.getElementById('ikuTotalFacultyChart');
        if (totalFacultyCtx) {
            new Chart(totalFacultyCtx, {
                type: 'line',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: 'Total Data IKU',
                        data: totalIkuByFaculty,
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.2)',
                        fill: true,
                        tension: 0.3,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, ticks: { precision: 0 } },
                    },
                },
            });
        }
    </script>
</x-admin-layout>

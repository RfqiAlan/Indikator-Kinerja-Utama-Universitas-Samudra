<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'IKU UNSAM') }} - Dashboard Fakultas</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}?v=2" type="image/x-icon"/>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <x-theme-script />
</head>
<body class="font-[Inter] antialiased bg-semantic-bg text-semantic-text min-h-screen flex flex-col">
    <x-user-layout activePage="dashboard">    <!-- Main Content -->
    <div class="w-full max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Header Section -->
        <div class="mb-8" >
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <div class="flex items-center gap-2 text-xs font-bold text-slate-500 mb-3">
                        <span class="flex items-center gap-1.5 px-2.5 py-1 bg-white border border-slate-200 rounded-lg shadow-sm">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                            Universitas Samudra
                        </span>
                    </div>
                    
                    <h1 class="text-3xl md:text-4xl font-extrabold text-slate-800 dark:text-[#E5E7EB] dark:text-[#E5E7EB] tracking-tight mb-2">
                        Selamat datang, <span class="text-blue-600">{{ $user->name }}</span>! 👋
                    </h1>
                    <p class="text-sm font-medium text-slate-500">
                        Pantau kemajuan dan kelola capaian Indikator Kinerja Utama (IKU) Anda di sini.
                    </p>
                </div>
                
                <div class="shrink-0">
                    <form action="{{ route('user.dashboard') }}" method="GET">
                        <div class="relative">
                            <select name="tahun" onchange="this.form.submit()" class="pl-10 pr-10 py-2.5 bg-white border border-slate-200 text-sm font-bold text-slate-700 rounded-xl cursor-pointer hover:bg-slate-50 focus:ring-2 focus:ring-blue-500 shadow-sm appearance-none outline-none transition">
                                @foreach($availableYears as $year)
                                    <option value="{{ $year }}" {{ $tahunAkademik == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            </div>
                            <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4" /></svg>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>



        <!-- Layout Grid for Cards & Chart -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6"  data-aos-delay="150">
            
            <!-- Left Side: Cards (2 cols on xl) -->
            <div class="xl:col-span-2 flex flex-col gap-6">
                
                <!-- OVERALL CAPAIAN -->
                <div class="bg-gradient-to-r from-[#2980b9] to-[#3498db] rounded-2xl p-8 shadow-sm text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/3"></div>
                    
                    <h3 class="text-[11px] font-bold text-white/80 uppercase tracking-widest flex items-center gap-2 mb-4 relative z-10">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                        OVERALL CAPAIAN {{ $tahunAkademik }}
                    </h3>
                    
                    <div class="relative z-10">
                        <h2 class="text-6xl font-extrabold leading-none tracking-tight">{{ $overallCapaian }}<span class="text-3xl">%</span></h2>
                        <p class="text-white/80 text-sm font-medium mt-2">Rata-rata kumulatif 4 Triwulan</p>
                    </div>
                </div>

                <!-- Grid 2x2 for TW -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($twData as $tw => $data)
                        @php
                            $colors = [
                                1 => ['dot' => 'bg-rose-500', 'border' => 'border-rose-500', 'text' => 'text-rose-600'],
                                2 => ['dot' => 'bg-amber-500', 'border' => 'border-amber-500', 'text' => 'text-amber-500'],
                                3 => ['dot' => 'bg-emerald-500', 'border' => 'border-emerald-500', 'text' => 'text-emerald-600'],
                                4 => ['dot' => 'bg-indigo-500', 'border' => 'border-indigo-500', 'text' => 'text-indigo-600']
                            ];
                            $c = $colors[$tw];
                            $capaianStr = str_replace('.', ',', $data['capaian']);
                            $isianStr = str_replace('.', ',', $data['isian_percentage']);
                        @endphp
                        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-white/5 dark:ring-1 dark:ring-white/5 rounded-2xl p-5 shadow-sm">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full {{ $c['dot'] }}"></div>
                                    <h4 class="text-xs font-bold text-slate-700">TW {{ $tw }}</h4>
                                    <span class="text-[9px] font-extrabold {{ $data['isian_count'] > 0 ? 'text-blue-600 bg-blue-50 border border-blue-100' : 'text-slate-400 bg-slate-50 border border-slate-200' }} px-1.5 py-0.5 rounded ml-1">
                                        {{ $data['isian_count'] > 0 ? 'SUBMITTED' : 'DRAFT' }}
                                    </span>
                                </div>
                                <span class="text-[9px] font-extrabold text-slate-400 bg-slate-50 border border-slate-200 px-1.5 py-0.5 rounded flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                                    {{ $data['status'] }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between mt-6">
                                <div class="w-12 h-12 rounded-full border-[3px] {{ $c['border'] }} flex items-center justify-center text-[10px] font-extrabold text-slate-700">
                                    {{ $capaianStr }}%
                                </div>
                                <div class="flex-1 ml-4 grid grid-cols-2 gap-2">
                                    <div>
                                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-1">
                                            <svg class="w-3 h-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                                            CAPAIAN
                                        </p>
                                        <p class="text-base font-extrabold {{ $c['text'] }}">{{ $capaianStr }}%</p>
                                    </div>
                                    <div>
                                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-1">
                                            <svg class="w-3 h-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            ISIAN
                                        </p>
                                        <p class="text-base font-extrabold text-slate-700">{{ $isianStr }}%</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Right Side: Chart -->
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-white/5 dark:ring-1 dark:ring-white/5 rounded-2xl p-6 shadow-sm flex flex-col justify-between h-full min-h-[320px]">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-[11px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" /></svg>
                        SEBARAN CAPAIAN PER IKU
                    </h3>
                    <select id="twChartFilter" class="text-[10px] font-bold text-slate-600 bg-slate-50 border border-slate-200 rounded px-2 py-1 outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer transition">
                        <option value="all">Semua TW</option>
                        <option value="tw1">Triwulan 1</option>
                        <option value="tw2">Triwulan 2</option>
                        <option value="tw3">Triwulan 3</option>
                        <option value="tw4">Triwulan 4</option>
                    </select>
                </div>

                <!-- Chart Container -->
                <div id="ikuChart" class="w-full flex-1 min-h-0"></div>
            </div>

        </div>
    </div>
</x-user-layout>

<!-- Load ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var chartData = @json($ikuChartData);
        
        function getSeriesData(twKey) {
            return [
                chartData[twKey]['iku1'] || 0,
                chartData[twKey]['iku2'] || 0,
                chartData[twKey]['iku3'] || 0,
                chartData[twKey]['iku4'] || 0,
                chartData[twKey]['iku5'] || 0,
                chartData[twKey]['iku6'] || 0,
                chartData[twKey]['iku7'] || 0,
                chartData[twKey]['iku8'] || 0,
            ];
        }

        var options = {
            series: [{
                name: 'Capaian',
                data: getSeriesData('all')
            }],
            chart: {
                height: '100%',
                type: 'area',
                toolbar: { show: false },
                zoom: { enabled: false },
                fontFamily: 'inherit'
            },
            colors: ['#3b82f6'],
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 2.5
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.3,
                    opacityTo: 0.05,
                    stops: [0, 90, 100]
                }
            },
            xaxis: {
                categories: ['IKU 1', 'IKU 2', 'IKU 3', 'IKU 4', 'IKU 5', 'IKU 6', 'IKU 7', 'IKU 8'],
                labels: {
                    style: {
                        colors: '#64748b',
                        fontSize: '10px',
                        fontWeight: 700
                    }
                },
                axisBorder: { show: false },
                axisTicks: { show: false },
                crosshairs: { show: false }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: '#64748b',
                        fontSize: '10px',
                        fontWeight: 600
                    }
                }
            },
            grid: {
                borderColor: '#f1f5f9',
                strokeDashArray: 0,
                xaxis: { lines: { show: false } },
                yaxis: { lines: { show: true } },
                padding: { top: 0, right: 0, bottom: 0, left: 10 }
            },
            markers: {
                size: 4,
                colors: ['#ffffff'],
                strokeColors: '#3b82f6',
                strokeWidth: 2,
                hover: { size: 6 }
            },
            tooltip: {
                theme: 'light',
                y: {
                    formatter: function (val) {
                        return val + "%"
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#ikuChart"), options);
        chart.render();

        // Update chart when dropdown changes
        document.getElementById('twChartFilter').addEventListener('change', function(e) {
            var selectedTw = e.target.value;
            chart.updateSeries([{
                data: getSeriesData(selectedTw)
            }]);
        });
    });
</script>

</body>
</html>

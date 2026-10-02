<x-admin-layout activePage="system-logs">
    <div class="mb-8" data-aos="fade-up">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">System Logs</h1>
                <p class="text-slate-500 font-medium mt-1">Pantau error dan aktivitas sistem aplikasi secara real-time dari laravel.log.</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.logs.index') }}" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 text-sm font-bold rounded-xl hover:bg-slate-50 transition shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                    Refresh
                </a>
                <form action="{{ route('admin.logs.clear') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus semua log?')">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-rose-50 border border-rose-100 text-rose-600 text-sm font-bold rounded-xl hover:bg-rose-100 transition shadow-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                        Bersihkan Log
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="bg-slate-900 rounded-2xl shadow-xl border border-slate-800 overflow-hidden" data-aos="fade-up" data-aos-delay="50">
        <div class="px-6 py-4 border-b border-slate-700/50 bg-slate-800/50 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="flex gap-1.5">
                    <div class="w-3 h-3 rounded-full bg-rose-500"></div>
                    <div class="w-3 h-3 rounded-full bg-amber-500"></div>
                    <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                </div>
                <span class="text-slate-400 text-xs font-mono font-medium ml-2">storage/logs/laravel.log</span>
            </div>
        </div>
        
        <div id="log-container" class="p-4 max-h-[600px] overflow-y-auto font-mono text-[13px] leading-relaxed custom-scrollbar">
            @if(empty($logs))
                <div class="flex flex-col items-center justify-center py-12 text-slate-500">
                    <svg class="w-12 h-12 mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <p>File log kosong. Sistem berjalan dengan normal!</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($logs as $log)
                        @php
                            // Pisahkan baris pertama (pesan utama) dengan sisanya (stack trace)
                            $lines = explode("\n", trim($log));
                            $firstLine = array_shift($lines);
                            $stackTrace = implode("\n", $lines);

                            // Cek timestamp pada baris pertama
                            $hasTimestamp = preg_match('/^\[(.*?)\]\s(.*)/s', $firstLine, $matches);
                            $timestamp = $hasTimestamp ? $matches[1] : null;
                            $message = $hasTimestamp ? $matches[2] : $firstLine;

                            // Tentukan warna berdasarkan tipe log
                            $isError = str_contains($firstLine, '.ERROR:') || str_contains($firstLine, 'Exception');
                            $isWarning = str_contains($firstLine, '.WARNING:');
                            
                            $badgeColor = 'bg-slate-700/50 text-slate-300 border-slate-600/50';
                            $titleColor = 'text-white';
                            
                            if ($isError) {
                                $badgeColor = 'bg-rose-500/20 text-rose-300 border-rose-500/30';
                                $titleColor = 'text-rose-400 font-bold';
                            } elseif ($isWarning) {
                                $badgeColor = 'bg-amber-500/20 text-amber-300 border-amber-500/30';
                                $titleColor = 'text-amber-400';
                            }
                        @endphp
                        
                        <div x-data="{ expanded: false }" class="bg-slate-800/40 rounded-xl border border-slate-700/50 overflow-hidden transition-all duration-200 hover:bg-slate-800/60">
                            <!-- Header / Trigger (List Item) -->
                            <button @click="expanded = !expanded" class="w-full text-left p-4 flex items-start gap-4 focus:outline-none">
                                <div class="shrink-0 mt-0.5">
                                    @if($timestamp)
                                        <span class="inline-block px-2 py-1 rounded text-[11px] font-semibold border {{ $badgeColor }}">
                                            {{ $timestamp }}
                                        </span>
                                    @else
                                        <span class="inline-block px-2 py-1 rounded text-[11px] font-semibold border bg-slate-700/50 text-slate-300 border-slate-600/50">
                                            Unknown Time
                                        </span>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0 pr-4">
                                    <div class="truncate {{ $titleColor }} text-[13px] font-medium leading-relaxed">
                                        {{ $message }}
                                    </div>
                                </div>
                                <div class="shrink-0 text-slate-500 transition-transform duration-300" :class="expanded ? 'rotate-180' : ''">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </button>
                            
                            <!-- Detail / Stack Trace (Content) -->
                            <div x-show="expanded" x-collapse x-cloak>
                                <div class="p-4 pt-0 border-t border-slate-700/30">
                                    <div class="mt-4 p-4 bg-slate-900/80 rounded-lg border border-slate-700/50">
                                        <div class="whitespace-pre-wrap break-words {{ $titleColor }} text-[13px] font-semibold mb-3 pb-3 border-b border-slate-700/50">
                                            {{ $message }}
                                        </div>
                                        @if(!empty($stackTrace))
                                            <div class="whitespace-pre-wrap break-words text-slate-400 text-[12px] opacity-80 leading-relaxed font-mono custom-scrollbar overflow-x-auto max-h-[300px]">
                                                {{ $stackTrace }}
                                            </div>
                                        @else
                                            <div class="text-slate-500 text-xs italic">Tidak ada detail stack trace untuk error ini.</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <script>
        // Auto scroll ke paling bawah (error terbaru)
        document.addEventListener('DOMContentLoaded', function() {
            var logContainer = document.getElementById('log-container');
            if(logContainer) {
                logContainer.scrollTop = logContainer.scrollHeight;
            }
        });
    </script>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #0f172a; 
            border-radius: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #334155; 
            border-radius: 8px;
        }
    </style>
</x-admin-layout>

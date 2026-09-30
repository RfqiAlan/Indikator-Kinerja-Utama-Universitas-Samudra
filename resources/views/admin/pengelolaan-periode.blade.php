<x-admin-layout activePage="periode">

    <!-- Page Header -->
    <div class="mb-8" data-aos="fade-up">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-2">
            <div>
                <div class="flex items-center gap-2 text-[13px] text-slate-400 font-medium mb-3">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-600 transition">Campus</a>
                    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    <span class="text-slate-700 font-bold">Pengaturan</span>
                </div>
                <h1 class="text-3xl lg:text-4xl font-extrabold text-slate-800 tracking-tight">Pengelolaan Periode</h1>
                <p class="text-slate-500 font-medium mt-2">Atur jadwal buka/tutup pengisian capaian IKU per Triwulan dan manajemen penguncian.</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <form action="{{ route('admin.pengelolaan-periode') }}" method="GET" class="w-full sm:w-auto">
                    <select name="tahun" onchange="this.form.submit()" class="w-full sm:w-auto bg-white border border-slate-200 text-sm font-bold text-slate-700 py-2.5 pl-4 pr-10 rounded-xl cursor-pointer focus:ring-indigo-500 focus:border-indigo-500 shadow-sm appearance-none">
                        @foreach($availableYears as $year)
                            <option value="{{ $year }}" {{ $tahunAkademik == $year ? 'selected' : '' }}>Tahun {{ $year }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl font-medium">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.pengelolaan-periode.store') }}" method="POST">
        @csrf
        <input type="hidden" name="tahun_akademik" value="{{ $tahunAkademik }}">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6" data-aos="fade-up" data-aos-delay="100">
            @for($i = 1; $i <= 4; $i++)
                @php
                    $setting = $periodes->get($i);
                    $is_locked = $setting ? $setting->is_locked : false;
                    $deadline = $setting && $setting->lock_deadline ? $setting->lock_deadline->format('Y-m-d\TH:i') : '';
                    
                    // Style logic
                    $borderClass = $is_locked ? 'border-rose-200 bg-rose-50' : 'border-indigo-200 bg-indigo-50/30';
                    $badgeClass = $is_locked ? 'bg-rose-100 text-rose-600' : 'bg-emerald-100 text-emerald-600';
                    $statusText = $is_locked ? 'DIKUNCI' : 'TERBUKA';
                @endphp
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden ring-1 {{ $is_locked ? 'ring-rose-50' : 'ring-indigo-50' }}">
                    <div class="px-6 py-4 border-b {{ $borderClass }} flex items-center justify-between">
                        <h3 class="text-sm font-bold text-slate-800">Triwulan {{ $i }} <span class="text-slate-500 font-medium">({{ $tahunAkademik }})</span></h3>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $badgeClass }}">{{ $statusText }}</span>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-1.5">BATAS WAKTU PENGISIAN (DEADLINE)</label>
                                <input type="datetime-local" name="tw[{{ $i }}][lock_deadline]" class="w-full border border-slate-200 rounded-lg text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500" value="{{ $deadline }}">
                                <p class="text-xs mt-1 text-slate-400">Jika lewat waktu ini, input otomatis dikunci. Kosongkan jika tidak ada batas otomatis.</p>
                            </div>
                        </div>
                        <div class="pt-2 border-t border-slate-100">
                            <label class="flex items-center gap-2 cursor-pointer mt-3">
                                <input type="checkbox" name="tw[{{ $i }}][is_locked]" value="1" {{ $is_locked ? 'checked' : '' }} class="rounded text-rose-600 focus:ring-rose-500 w-4 h-4 border-slate-300">
                                <span class="text-sm font-bold text-rose-600">Kunci Manual Sekarang</span>
                            </label>
                            <p class="text-xs text-slate-500 mt-1 ml-6">Jika dicentang, pengguna tidak bisa mengisi data terlepas dari jadwal batas waktu di atas.</p>
                        </div>
                    </div>
                </div>
            @endfor
        </div>

        <div class="mt-8 flex justify-end" data-aos="fade-up">
            <button type="submit" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl transition flex items-center justify-center gap-2 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" /></svg>
                SIMPAN PENGATURAN PERIODE
            </button>
        </div>
    </form>

</x-admin-layout>

<x-admin-layout activePage="fakultas-manage">
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4" data-aos="fade-up">
        <div>
            <h1 class="text-2xl lg:text-3xl font-bold text-slate-800">Kelola Fakultas & Program Studi</h1>
            <p class="text-slate-500 mt-1 text-sm">Manajemen struktur akademik universitas</p>
        </div>
        <div x-data="{ showForm: false }" class="relative z-20">
            <button @click="showForm = !showForm" 
                    class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 transition shadow-sm hover:shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                <span x-text="showForm ? 'Batal Tambah' : 'Tambah Fakultas'"></span>
            </button>

            {{-- Flyout Add Fakultas Form --}}
            <div x-show="showForm" 
                 @click.away="showForm = false"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                 x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                 class="absolute right-0 mt-3 w-80 bg-white rounded-2xl shadow-xl border border-slate-100 p-5 origin-top-right">
                <h3 class="font-bold text-slate-800 mb-4 pb-2 border-b border-slate-100">Fakultas Baru</h3>
                <form action="{{ route('admin.fakultas.store') }}" method="POST" class="space-y-4" onsubmit="confirmSubmit(event, 'Simpan Fakultas baru?')">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-wide">Kode Fakultas <span class="text-rose-500">*</span></label>
                        <input type="text" name="kode" value="{{ old('kode') }}" required
                               placeholder="contoh: ft" pattern="[a-z_]+"
                               class="w-full rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase tracking-wide">Nama Fakultas <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama') }}" required
                               placeholder="contoh: Fakultas Teknik"
                               class="w-full rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500 text-sm">
                    </div>
                    <button type="submit" class="w-full py-2.5 bg-slate-900 text-white rounded-lg font-semibold text-sm hover:bg-slate-800 transition shadow-sm mt-2">
                        Simpan Fakultas
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Validation Errors --}}
    @if($errors->any())
    <div class="bg-rose-50 border border-rose-200 rounded-xl p-4 mb-6 text-sm text-rose-700 flex items-start gap-3" data-aos="fade-in">
        <svg class="w-5 h-5 text-rose-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- 1-Column Layout: Accordion/Stacked List --}}
    <div class="space-y-4" data-aos="fade-up" data-aos-delay="100">
        @forelse($fakultasList as $fakultas)
        <div x-data="{ expanded: false, editFakultas: false }" class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden transition-all duration-300" :class="expanded ? 'ring-1 ring-blue-500/50 shadow-md' : 'hover:border-blue-200 hover:shadow-md'">
            
            {{-- Header Fakultas (Klik untuk Expand) --}}
            <div class="p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 cursor-pointer" @click="expanded = !expanded">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-50 to-blue-100 text-blue-600 flex items-center justify-center font-bold text-lg shrink-0 border border-blue-200">
                        {{ strtoupper(substr($fakultas->kode, 0, 2)) }}
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 text-lg leading-tight">{{ $fakultas->nama }}</h3>
                        <div class="mt-1 flex items-center gap-3">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold tracking-widest bg-slate-100 text-slate-500 uppercase">KODE: {{ $fakultas->kode }}</span>
                            <span class="text-sm font-medium" :class="expanded ? 'text-blue-600' : 'text-slate-400'">
                                {{ $fakultas->prodi->count() }} Program Studi
                            </span>
                        </div>
                    </div>
                </div>
                
                {{-- Tombol Aksi Fakultas --}}
                <div class="flex items-center gap-3" @click.stop>
                    <button @click="editFakultas = !editFakultas; expanded = true" class="px-3 py-1.5 bg-white border border-slate-200 text-slate-600 rounded-lg text-sm font-medium hover:bg-slate-50 hover:text-blue-600 transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Edit
                    </button>
                    
                    <form action="{{ route('admin.fakultas.destroy', $fakultas) }}" method="POST" class="inline"
                          onsubmit="confirmDelete(event, 'Semua prodi di Fakultas {{ $fakultas->nama }} juga akan terhapus!')">
                        @csrf @method('DELETE')
                        <button type="submit" class="px-3 py-1.5 bg-rose-50 text-rose-600 rounded-lg text-sm font-medium hover:bg-rose-100 transition flex items-center gap-2 border border-rose-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            Hapus
                        </button>
                    </form>

                    <div class="w-8 h-8 rounded-full flex items-center justify-center bg-slate-50 text-slate-400 transition-transform duration-300" :class="expanded ? 'rotate-180 bg-blue-50 text-blue-600' : ''">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>
            </div>

            {{-- Expandable Content --}}
            <div x-show="expanded" x-collapse class="border-t border-slate-100 bg-slate-50/50 p-5">
                
                {{-- Form Edit Fakultas --}}
                <div x-show="editFakultas" class="mb-6 p-4 bg-white rounded-xl shadow-sm border border-blue-100">
                    <form action="{{ route('admin.fakultas.update', $fakultas) }}" method="POST" class="flex flex-col sm:flex-row gap-3 items-end" onsubmit="confirmSubmit(event, 'Simpan perubahan Fakultas ini?')">
                        @csrf @method('PUT')
                        <div class="flex-grow w-full">
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Nama Fakultas</label>
                            <input type="text" name="nama" value="{{ $fakultas->nama }}" required
                                   class="w-full rounded-lg border-slate-300 focus:ring-blue-500 text-sm">
                        </div>
                        <div class="flex gap-2 w-full sm:w-auto">
                            <button type="button" @click="editFakultas = false" class="flex-1 sm:flex-none px-4 py-2 bg-slate-100 text-slate-600 rounded-lg text-sm font-semibold hover:bg-slate-200">Batal</button>
                            <button type="submit" class="flex-1 sm:flex-none px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700">Simpan Nama</button>
                        </div>
                    </form>
                </div>

                {{-- Bagian Prodi --}}
                <div x-data="{ showAddProdi: false, editProdiId: null }" class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                    
                    {{-- Header Prodi & Tambah --}}
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 border-b border-slate-100 bg-slate-50/80 gap-3">
                        <h4 class="font-bold text-slate-700 uppercase tracking-wider text-sm flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002 2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            Daftar Program Studi
                        </h4>
                        <button @click="showAddProdi = !showAddProdi" 
                                class="inline-flex items-center justify-center gap-2 px-3 py-1.5 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-md text-sm font-semibold transition border border-blue-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Tambah Prodi
                        </button>
                    </div>

                    {{-- Form Tambah Prodi --}}
                    <div x-show="showAddProdi" x-collapse class="border-b border-slate-100 bg-blue-50/30 p-4">
                        <form action="{{ route('admin.prodi.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="fakultas_id" value="{{ $fakultas->id }}">
                            <div class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-end">
                                <div class="sm:col-span-3">
                                    <label class="block text-xs font-semibold text-slate-600 mb-1">Kode</label>
                                    <input type="text" name="kode" required placeholder="Contoh: if" pattern="[a-z_]+"
                                           class="w-full rounded-lg border-blue-300 focus:ring-blue-500 focus:border-blue-500 text-sm py-2">
                                </div>
                                <div class="sm:col-span-4">
                                    <label class="block text-xs font-semibold text-slate-600 mb-1">Nama Program Studi</label>
                                    <input type="text" name="nama" required placeholder="Contoh: Informatika"
                                           class="w-full rounded-lg border-blue-300 focus:ring-blue-500 focus:border-blue-500 text-sm py-2">
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="block text-xs font-semibold text-slate-600 mb-1">Jenjang</label>
                                    <select name="jenjang" required class="w-full rounded-lg border-blue-300 focus:ring-blue-500 focus:border-blue-500 text-sm py-2">
                                        <option value="S1">S1</option>
                                        <option value="S2">S2</option>
                                        <option value="Profesi">Profesi</option>
                                        <option value="D4">D4</option>
                                    </select>
                                </div>
                                <div class="sm:col-span-3 pb-[1px]">
                                    <button type="submit" class="w-full py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 transition shadow-sm">
                                        Simpan Prodi
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- Daftar List Prodi --}}
                    @if($fakultas->prodi->count() > 0)
                        <div class="divide-y divide-slate-100">
                            @foreach($fakultas->prodi as $prodi)
                            <div class="px-4 py-3 hover:bg-slate-50 transition flex flex-col sm:flex-row sm:items-center justify-between gap-4 w-full">
                                
                                {{-- Read Display --}}
                                <div x-show="editProdiId !== {{ $prodi->id }}" class="flex flex-col sm:flex-row sm:items-center justify-between w-full">
                                    <div class="flex items-center gap-3">
                                        <span class="inline-flex items-center justify-center min-w-[3.5rem] px-2 py-1 rounded-md text-xs font-bold tracking-widest bg-slate-100 border border-slate-200 text-slate-600 uppercase">{{ $prodi->kode }}</span>
                                        <div class="flex items-center gap-2">
                                            <span class="font-medium text-slate-700 text-sm">{{ $prodi->nama }}</span>
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold tracking-wide uppercase shadow-sm border {{ $prodi->jenjang === 'S1' ? 'bg-blue-100 text-blue-700 border-blue-200' : ($prodi->jenjang === 'S2' ? 'bg-blue-100 text-blue-700 border-blue-200' : ($prodi->jenjang === 'Profesi' ? 'bg-purple-100 text-purple-700 border-purple-200' : 'bg-amber-100 text-amber-700 border-amber-200')) }}">{{ $prodi->jenjang }}</span>
                                        </div>
                                    </div>
                                    
                                    {{-- ALWAYS VISIBLE ACTION ICONS --}}
                                    <div class="flex items-center gap-2 mt-2 sm:mt-0 justify-end">
                                        <button @click="editProdiId = {{ $prodi->id }}" class="flex items-center gap-1.5 px-2.5 py-1.5 text-sm bg-white border border-slate-200 text-slate-600 hover:text-blue-600 hover:border-blue-300 rounded-md transition font-medium">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            <span class="hidden sm:inline">Edit</span>
                                        </button>
                                        
                                        <form action="{{ route('admin.prodi.destroy', $prodi) }}" method="POST"
                                              onsubmit="confirmDelete(event, 'Hapus program studi {{ $prodi->nama }}?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="flex items-center gap-1.5 px-2.5 py-1.5 text-sm bg-rose-50 border border-rose-100 text-rose-600 hover:bg-rose-100 rounded-md transition font-medium">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                <span class="hidden sm:inline">Hapus</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                
                                {{-- Edit Display --}}
                                <div x-show="editProdiId === {{ $prodi->id }}" style="display: none;" class="w-full">
                                    <form action="{{ route('admin.prodi.update', $prodi) }}" method="POST" class="flex flex-col sm:flex-row items-center gap-3 w-full p-2 bg-blue-50/50 rounded-lg border border-blue-100" onsubmit="confirmSubmit(event, 'Simpan perubahan Program Studi ini?')">
                                        @csrf @method('PUT')
                                        <div class="flex-grow w-full flex items-center gap-2">
                                            <input type="text" name="nama" value="{{ $prodi->nama }}" required
                                                   class="w-full rounded-md border-slate-300 focus:ring-blue-500 text-sm py-1.5 px-3">
                                            <select name="jenjang" required class="w-32 rounded-md border-slate-300 focus:ring-blue-500 text-sm py-1.5 px-2">
                                                @foreach(['S1', 'S2', 'Profesi', 'D4'] as $j)
                                                    <option value="{{ $j }}" {{ $prodi->jenjang === $j ? 'selected' : '' }}>{{ $j }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="flex items-center gap-2 w-full sm:w-auto">
                                            <button type="submit" class="flex-1 sm:flex-none px-4 py-1.5 bg-blue-600 text-white rounded-md text-sm font-semibold hover:bg-blue-700 whitespace-nowrap shadow-sm">Simpan</button>
                                            <button type="button" @click="editProdiId = null" class="flex-1 sm:flex-none px-4 py-1.5 bg-white text-slate-600 border border-slate-300 rounded-md text-sm font-medium hover:bg-slate-50 whitespace-nowrap">Batal</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 px-4 bg-slate-50">
                            <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-3 text-slate-300 border border-slate-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002 2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </div>
                            <p class="text-base font-medium text-slate-600">Belum ada program studi</p>
                            <p class="text-sm text-slate-400 mt-1">Silakan klik tombol "Tambah Prodi" di atas.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="py-16 px-6 text-center text-slate-500 bg-white rounded-2xl border border-slate-100 shadow-sm border-dashed">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-slate-50 mb-4 border border-slate-100 shadow-inner">
                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
            <h3 class="font-bold text-xl text-slate-700">Belum ada fakultas terdaftar</h3>
            <p class="text-slate-500 mt-2 max-w-sm mx-auto">Sistem kamu masih kosong. Tambahkan fakultas pertama dengan tombol "Tambah Fakultas" di pojok kanan atas.</p>
        </div>
        @endforelse
    </div>
</x-admin-layout>

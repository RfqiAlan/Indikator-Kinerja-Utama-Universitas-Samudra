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
                <form action="{{ route('admin.fakultas.store') }}" method="POST" class="space-y-4">
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

    {{-- Desktop Main Table View --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden" data-aos="fade-up" data-aos-delay="100">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100">
                        <th class="py-4 px-6 font-semibold text-xs text-slate-500 uppercase tracking-wider w-1/3">Fakultas</th>
                        <th class="py-4 px-6 font-semibold text-xs text-slate-500 uppercase tracking-wider w-2/3">Program Studi & Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($fakultasList as $fakultas)
                    <tr x-data="{ expanded: false, editFakultas: false }" class="hover:bg-slate-50/50 transition-colors group">
                        
                        {{-- Kolom Fakultas --}}
                        <td class="py-5 px-6 align-top border-r border-slate-50 relative">
                            <!-- Detail View -->
                            <div x-show="!editFakultas">
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-sm shrink-0 border border-blue-100">
                                        {{ strtoupper(substr($fakultas->kode, 0, 2)) }}
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-slate-800 text-base leading-tight">{{ $fakultas->nama }}</h3>
                                        <div class="mt-1 flex items-center gap-2">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold tracking-widest bg-slate-100 text-slate-500 uppercase">{{ $fakultas->kode }}</span>
                                            <span class="text-xs text-slate-400 font-medium whitespace-nowrap">{{ $fakultas->prodi->count() }} Prodi</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-4 flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button @click="editFakultas = true" class="text-xs font-medium text-slate-500 hover:text-blue-600 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        Edit
                                    </button>
                                    <span class="text-slate-300">|</span>
                                    <form action="{{ route('admin.fakultas.destroy', $fakultas) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Hapus fakultas {{ $fakultas->nama }}? Semua prodi juga akan terhapus!')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-xs font-medium text-slate-500 hover:text-rose-600 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                            
                            <!-- Edit Form -->
                            <div x-show="editFakultas" style="display: none;" class="bg-white p-4 rounded-xl shadow-sm border border-blue-100">
                                <form action="{{ route('admin.fakultas.update', $fakultas) }}" method="POST" class="space-y-3">
                                    @csrf @method('PUT')
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-600 mb-1">Nama Fakultas</label>
                                        <input type="text" name="nama" value="{{ $fakultas->nama }}" required
                                               class="w-full rounded-lg border-slate-300 focus:ring-blue-500 text-sm py-1.5 px-3">
                                    </div>
                                    <div class="flex items-center gap-2 pt-1">
                                        <button type="submit" class="px-3 py-1.5 bg-blue-600 text-white rounded-lg text-xs font-semibold hover:bg-blue-700">Update</button>
                                        <button type="button" @click="editFakultas = false" class="px-3 py-1.5 bg-slate-100 text-slate-600 rounded-lg text-xs font-semibold hover:bg-slate-200">Batal</button>
                                    </div>
                                </form>
                            </div>
                        </td>
                        
                        {{-- Kolom Prodi --}}
                        <td class="py-3 px-6 align-top">
                            <div class="w-full" x-data="{ showAddProdi: false, editProdiId: null }">
                                
                                {{-- Header & Tambah Prodi Btn --}}
                                <div class="flex justify-between items-center mb-3 mt-1">
                                    <span class="text-xs font-bold text-slate-400 tracking-wider uppercase">Daftar Prodi</span>
                                    <button @click="showAddProdi = !showAddProdi" 
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 text-emerald-600 hover:bg-emerald-100 rounded-md text-xs font-semibold transition border border-emerald-100">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                        Tambah Prodi
                                    </button>
                                </div>
                                
                                {{-- Add Prodi Form --}}
                                <div x-show="showAddProdi" x-collapse>
                                    <form action="{{ route('admin.prodi.store') }}" method="POST" class="bg-slate-50 border border-slate-200 rounded-xl p-4 mb-4">
                                        @csrf
                                        <input type="hidden" name="fakultas_id" value="{{ $fakultas->id }}">
                                        <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
                                            <div class="md:col-span-4">
                                                <label class="block text-xs font-semibold text-slate-600 mb-1">Kode / Singkatan</label>
                                                <input type="text" name="kode" required placeholder="Cth: if" pattern="[a-z_]+"
                                                       class="w-full rounded-lg border-slate-300 focus:ring-emerald-500 text-sm py-1.5">
                                            </div>
                                            <div class="md:col-span-5">
                                                <label class="block text-xs font-semibold text-slate-600 mb-1">Nama Program Studi</label>
                                                <input type="text" name="nama" required placeholder="Cth: Informatika"
                                                       class="w-full rounded-lg border-slate-300 focus:ring-emerald-500 text-sm py-1.5">
                                            </div>
                                            <div class="md:col-span-3">
                                                <button type="submit" class="w-full py-1.5 bg-emerald-600 text-white rounded-lg text-sm font-semibold hover:bg-emerald-700 transition">
                                                    Simpan
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                
                                {{-- Daftar Prodi Inner Table --}}
                                @if($fakultas->prodi->count() > 0)
                                    <div class="border border-slate-100 rounded-xl overflow-hidden bg-white">
                                        <table class="w-full text-sm">
                                            <tbody class="divide-y divide-slate-100">
                                                @foreach($fakultas->prodi as $prodi)
                                                <tr class="hover:bg-slate-50 transition-colors group/prodi">
                                                    <td class="py-2.5 px-3 w-1/4">
                                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold tracking-widest bg-slate-100 text-slate-600 uppercase">{{ $prodi->kode }}</span>
                                                    </td>
                                                    <td class="py-2.5 px-3 font-medium text-slate-700">
                                                        {{-- Read State --}}
                                                        <div x-show="editProdiId !== {{ $prodi->id }}" class="flex items-center justify-between w-full">
                                                            <span>{{ $prodi->nama }}</span>
                                                            
                                                            {{-- Actions (Hover) --}}
                                                            <div class="flex items-center gap-2 opacity-0 group-hover/prodi:opacity-100 transition-opacity justify-end">
                                                                <button @click="editProdiId = {{ $prodi->id }}" class="text-slate-400 hover:text-blue-600 bg-white shadow-sm border border-slate-200 rounded p-1" title="Edit Prodi">
                                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                                </button>
                                                                <form action="{{ route('admin.prodi.destroy', $prodi) }}" method="POST"
                                                                      onsubmit="return confirm('Hapus prodi {{ $prodi->nama }}?')">
                                                                    @csrf @method('DELETE')
                                                                    <button type="submit" class="text-slate-400 hover:text-rose-600 bg-white shadow-sm border border-slate-200 rounded p-1" title="Hapus Prodi">
                                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        
                                                        {{-- Edit State --}}
                                                        <div x-show="editProdiId === {{ $prodi->id }}" style="display: none;">
                                                            <form action="{{ route('admin.prodi.update', $prodi) }}" method="POST" class="flex items-center gap-2 w-full">
                                                                @csrf @method('PUT')
                                                                <input type="text" name="nama" value="{{ $prodi->nama }}" required
                                                                       class="w-full rounded border-slate-300 focus:ring-blue-500 text-xs py-1 px-2">
                                                                <button type="submit" class="px-2 py-1 bg-blue-600 text-white rounded text-xs font-semibold hover:bg-blue-700 whitespace-nowrap">Simpan</button>
                                                                <button type="button" @click="editProdiId = null" class="px-2 py-1 bg-slate-100 text-slate-600 rounded text-xs font-medium border border-slate-200 whitespace-nowrap">Batal</button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-6 px-4 bg-slate-50 border border-slate-100 rounded-xl border-dashed">
                                        <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-2 text-slate-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002 2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                        </div>
                                        <p class="text-sm font-medium text-slate-600">Belum ada program studi</p>
                                        <p class="text-xs text-slate-400 mt-1">Tambahkan prodi pertama pada fakultas ini.</p>
                                    </div>
                                @endif
                                
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="py-12 px-6 text-center text-slate-500">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-50 mb-3 border border-slate-100">
                                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <p class="font-medium text-base text-slate-600">Belum ada data fakultas</p>
                            <p class="text-sm text-slate-400 mt-1">Gunakan tombol "Tambah Fakultas" di kanan atas.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>

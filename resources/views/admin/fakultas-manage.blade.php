<x-admin-layout activePage="fakultas-manage">
    <div class="mb-6" data-aos="fade-up">
        <h1 class="text-2xl lg:text-3xl font-bold text-slate-800">Kelola Fakultas & Program Studi</h1>
        <p class="text-slate-500 mt-1 text-sm">Tambah, edit, dan hapus fakultas beserta program studinya</p>
    </div>

    {{-- Tambah Fakultas --}}
    <div class="bg-white rounded-2xl shadow-sm p-6 mb-6" data-aos="fade-up" data-aos-delay="100"
         x-data="{ showForm: false }">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-slate-800">Tambah Fakultas Baru</h2>
            <button @click="showForm = !showForm" 
                    class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white rounded-lg text-sm font-semibold hover:bg-emerald-700 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                <span x-text="showForm ? 'Batal' : 'Tambah Fakultas'"></span>
            </button>
        </div>
        <form action="{{ route('admin.fakultas.store') }}" method="POST" x-show="showForm" x-collapse class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Kode <span class="text-rose-500">*</span></label>
                    <input type="text" name="kode" value="{{ old('kode') }}" required
                           placeholder="contoh: ftk" pattern="[a-z_]+"
                           class="w-full rounded-lg border-slate-300 focus:ring-emerald-500 text-sm">
                    <p class="text-xs text-slate-400 mt-1">Huruf kecil & underscore saja</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Fakultas <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama') }}" required
                           placeholder="contoh: Fakultas Teknik"
                           class="w-full rounded-lg border-slate-300 focus:ring-emerald-500 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Jenjang <span class="text-rose-500">*</span></label>
                    <select name="jenjang" class="w-full rounded-lg border-slate-300 focus:ring-emerald-500 text-sm">
                        <option value="S1" {{ old('jenjang') === 'S1' ? 'selected' : '' }}>S1</option>
                        <option value="S2" {{ old('jenjang') === 'S2' ? 'selected' : '' }}>S2</option>
                        <option value="S3" {{ old('jenjang') === 'S3' ? 'selected' : '' }}>S3</option>
                        <option value="D3" {{ old('jenjang') === 'D3' ? 'selected' : '' }}>D3</option>
                        <option value="D4" {{ old('jenjang') === 'D4' ? 'selected' : '' }}>D4</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2 bg-emerald-600 text-white rounded-lg font-semibold text-sm hover:bg-emerald-700 transition">
                    Simpan Fakultas
                </button>
            </div>
        </form>
    </div>

    {{-- Validation Errors --}}
    @if($errors->any())
    <div class="bg-rose-50 border border-rose-200 rounded-xl p-4 mb-6 text-sm text-rose-700">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Daftar Fakultas --}}
    @foreach($fakultasList as $fakultas)
    <div class="bg-white rounded-2xl shadow-sm mb-6 overflow-hidden" data-aos="fade-up" x-data="{ editFak: false, showAddProdi: false, editProdiId: null }">
        {{-- Fakultas Header --}}
        <div class="p-6 border-b border-slate-100">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold text-lg flex-shrink-0">
                        {{ strtoupper(substr($fakultas->kode, 0, 2)) }}
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 text-lg">{{ $fakultas->nama }}</h3>
                        <div class="flex items-center gap-3 text-sm text-slate-500">
                            <span>Kode: <strong>{{ $fakultas->kode }}</strong></span>
                            <span>•</span>
                            <span>Jenjang: <strong>{{ $fakultas->jenjang }}</strong></span>
                            <span>•</span>
                            <span>{{ $fakultas->prodi->count() }} Prodi</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button @click="editFak = !editFak" class="px-3 py-1.5 text-sm font-medium text-cyan-600 hover:bg-cyan-50 rounded-lg transition">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Edit
                    </button>
                    <form action="{{ route('admin.fakultas.destroy', $fakultas) }}" method="POST" 
                          onsubmit="return confirm('Hapus fakultas {{ $fakultas->nama }}? Semua prodi di dalamnya juga akan terhapus!')">
                        @csrf @method('DELETE')
                        <button type="submit" class="px-3 py-1.5 text-sm font-medium text-rose-600 hover:bg-rose-50 rounded-lg transition">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>

            {{-- Edit Fakultas Form --}}
            <form action="{{ route('admin.fakultas.update', $fakultas) }}" method="POST" x-show="editFak" x-collapse class="mt-4 pt-4 border-t border-slate-100">
                @csrf @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nama Fakultas</label>
                        <input type="text" name="nama" value="{{ $fakultas->nama }}" required
                               class="w-full rounded-lg border-slate-300 focus:ring-emerald-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Jenjang</label>
                        <select name="jenjang" class="w-full rounded-lg border-slate-300 focus:ring-emerald-500 text-sm">
                            @foreach(['S1', 'S2', 'S3', 'D3', 'D4'] as $j)
                                <option value="{{ $j }}" {{ $fakultas->jenjang === $j ? 'selected' : '' }}>{{ $j }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="flex justify-end gap-2 mt-3">
                    <button type="button" @click="editFak = false" class="px-4 py-2 text-slate-600 text-sm">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-lg text-sm font-semibold hover:bg-emerald-700 transition">Update</button>
                </div>
            </form>
        </div>

        {{-- Prodi List --}}
        <div class="p-6">
            <div class="flex items-center justify-between mb-3">
                <h4 class="font-semibold text-slate-700 text-sm uppercase tracking-wider">Program Studi</h4>
                <button @click="showAddProdi = !showAddProdi" class="text-sm font-medium text-emerald-600 hover:text-emerald-700 transition">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    Tambah Prodi
                </button>
            </div>

            {{-- Add Prodi Form --}}
            <form action="{{ route('admin.prodi.store') }}" method="POST" x-show="showAddProdi" x-collapse class="mb-4 p-4 bg-slate-50 rounded-xl">
                @csrf
                <input type="hidden" name="fakultas_id" value="{{ $fakultas->id }}">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Kode Prodi</label>
                        <input type="text" name="kode" required placeholder="contoh: teknik_kimia" pattern="[a-z_]+"
                               class="w-full rounded-lg border-slate-300 focus:ring-emerald-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nama Prodi</label>
                        <input type="text" name="nama" required placeholder="contoh: Teknik Kimia"
                               class="w-full rounded-lg border-slate-300 focus:ring-emerald-500 text-sm">
                    </div>
                </div>
                <div class="flex justify-end gap-2 mt-3">
                    <button type="button" @click="showAddProdi = false" class="px-4 py-2 text-slate-600 text-sm">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-lg text-sm font-semibold hover:bg-emerald-700 transition">Simpan</button>
                </div>
            </form>

            @if($fakultas->prodi->count() > 0)
            <div class="space-y-2">
                @foreach($fakultas->prodi as $prodi)
                <div class="flex items-center justify-between p-3 rounded-lg hover:bg-slate-50 transition group">
                    <div class="flex items-center gap-3">
                        <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                        <div>
                            <template x-if="editProdiId !== {{ $prodi->id }}">
                                <div>
                                    <span class="text-sm font-medium text-slate-800">{{ $prodi->nama }}</span>
                                    <span class="text-xs text-slate-400 ml-2">{{ $prodi->kode }}</span>
                                </div>
                            </template>
                            <template x-if="editProdiId === {{ $prodi->id }}">
                                <form action="{{ route('admin.prodi.update', $prodi) }}" method="POST" class="flex items-center gap-2">
                                    @csrf @method('PUT')
                                    <input type="text" name="nama" value="{{ $prodi->nama }}" required
                                           class="rounded-lg border-slate-300 focus:ring-emerald-500 text-sm py-1">
                                    <button type="submit" class="px-3 py-1 bg-emerald-600 text-white rounded-lg text-xs font-semibold hover:bg-emerald-700 transition">Simpan</button>
                                    <button type="button" @click="editProdiId = null" class="px-3 py-1 text-slate-500 text-xs">Batal</button>
                                </form>
                            </template>
                        </div>
                    </div>
                    <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition" x-show="editProdiId !== {{ $prodi->id }}">
                        <button @click="editProdiId = {{ $prodi->id }}" class="p-1.5 text-cyan-600 hover:bg-cyan-50 rounded-lg transition" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </button>
                        <form action="{{ route('admin.prodi.destroy', $prodi) }}" method="POST"
                              onsubmit="return confirm('Hapus prodi {{ $prodi->nama }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-1.5 text-rose-600 hover:bg-rose-50 rounded-lg transition" title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-sm text-slate-400 text-center py-4">Belum ada program studi</p>
            @endif
        </div>
    </div>
    @endforeach
</x-admin-layout>

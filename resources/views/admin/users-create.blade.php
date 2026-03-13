<x-admin-layout activePage="users">
    <!-- Premium Header Banner -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 lg:p-8 w-full relative overflow-hidden mb-6 lg:mb-8" data-aos="fade-up">
        <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-blue-500 to-indigo-500"></div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-5">
            <div class="flex items-center gap-4 mb-2 md:mb-0">
                <div class="w-14 h-14 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 font-bold text-xl border border-blue-100 shadow-sm cursor-pointer hover:bg-blue-100 transition" onclick="window.history.back()">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl lg:text-3xl font-extrabold text-slate-800 tracking-tight">Tambah User</h1>
                    <p class="text-slate-500 text-sm font-medium mt-1">Buat akun akses baru untuk operator fakultas atau administrator.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-2xl">
        <form action="{{ route('admin.users.store') }}" method="POST" class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 lg:p-8 space-y-6 relative overflow-hidden" data-aos="fade-up" onsubmit="confirmSubmit(event, 'Buat pengguna baru ini?')">
            @csrf
            <div class="absolute top-0 right-0 p-16 bg-slate-50 rounded-bl-full -z-10 opacity-50"></div>
            
            <div class="space-y-5 relative z-10">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 transition-colors" required placeholder="Masukkan nama lengkap">
                    @error('name')<p class="text-rose-500 text-sm mt-1 flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> {{ $message }}</p>@enderror
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Alamat Email <span class="text-rose-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 transition-colors" required placeholder="nama@email.com">
                    @error('email')<p class="text-rose-500 text-sm mt-1 flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> {{ $message }}</p>@enderror
                </div>
                
                <div x-data="{ showPassword: false }">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Password <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <input :type="showPassword ? 'text' : 'password'" name="password" class="w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 transition-colors pr-12" required minlength="6" placeholder="Minimal 6 karakter">
                        <button type="button"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-blue-600 transition-colors focus:outline-none"
                                @click="showPassword = !showPassword"
                                :aria-label="showPassword ? 'Hide password' : 'Show password'"
                                :aria-pressed="showPassword.toString()">
                            <svg x-show="!showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <svg x-show="showPassword" class="h-5 w-5 block" style="display: none;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                    @error('password')<p class="text-rose-500 text-sm mt-1 flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> {{ $message }}</p>@enderror
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pt-2">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Role Akses <span class="text-rose-500">*</span></label>
                        <select name="role" class="w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 transition-colors" required>
                            <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User (Operator Fakultas)</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin (Sistem Universial)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Penempatan Fakultas</label>
                        <select name="fakultas" class="w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 transition-colors">
                            <option value="">-- Pilih Fakultas (Semua untuk Admin) --</option>
                            @foreach($fakultasConfig as $kode => $data)
                                <option value="{{ $kode }}" {{ old('fakultas') == $kode ? 'selected' : '' }}>{{ $data['nama'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-6 mt-6 border-t border-slate-100">
                <button type="submit" class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 font-bold transition-all duration-200 shadow-sm hover:shadow-blue-200 ring-1 ring-blue-500 hover:ring-2 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan User Baru
                </button>
                <a href="{{ route('admin.users') }}" class="px-6 py-3 text-slate-600 bg-slate-100 hover:bg-slate-200 hover:text-slate-800 rounded-xl font-semibold transition-colors border border-slate-200">Batal</a>
            </div>
        </form>
    </div>
</x-admin-layout>

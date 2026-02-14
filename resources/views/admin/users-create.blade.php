<x-admin-layout activePage="users">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-800">Tambah User</h1>
        <p class="text-slate-500 mt-1">Buat akun baru untuk fakultas</p>
    </div>

    <div class="max-w-2xl">
        <form action="{{ route('admin.users.store') }}" method="POST" class="bg-white rounded-2xl shadow-sm p-6 space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" required>
                @error('name')<p class="text-rose-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" required>
                @error('email')<p class="text-rose-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div x-data="{ showPassword: false }">
                <label class="block text-sm font-medium text-slate-700 mb-2">Password</label>
                <div class="relative">
                    <input :type="showPassword ? 'text' : 'password'" name="password" class="w-full rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 pr-12" required minlength="6">
                    <button type="button"
                            class="absolute inset-y-0 end-0 flex items-center px-3 text-slate-500 hover:text-slate-700"
                            @click="showPassword = !showPassword"
                            :aria-label="showPassword ? 'Hide password' : 'Show password'"
                            :aria-pressed="showPassword.toString()">
                        <svg x-show="!showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <svg x-show="showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.477 10.477a3 3 0 004.243 4.243" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.88 4.243A9.956 9.956 0 0112 4c4.477 0 8.268 2.943 9.542 7a9.992 9.992 0 01-4.046 5.197M6.61 6.61A9.988 9.988 0 002.458 12c1.274 4.057 5.065 7 9.542 7 1.238 0 2.429-.225 3.53-.637" />
                        </svg>
                    </button>
                </div>
                @error('password')<p class="text-rose-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Role</label>
                    <select name="role" class="w-full rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" required>
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Fakultas</label>
                    <select name="fakultas" class="w-full rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                        <option value="">-- Pilih Fakultas --</option>
                        @foreach($fakultasConfig as $kode => $data)
                            <option value="{{ $kode }}" {{ old('fakultas') == $kode ? 'selected' : '' }}>{{ $data['nama'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="flex gap-3 pt-4">
                <a href="{{ route('admin.users') }}" class="px-4 py-2 text-slate-600 hover:text-slate-800">Batal</a>
                <button type="submit" class="px-6 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 font-semibold">Simpan</button>
            </div>
        </form>
    </div>
</x-admin-layout>

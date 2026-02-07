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
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Password</label>
                <input type="password" name="password" class="w-full rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" required minlength="6">
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

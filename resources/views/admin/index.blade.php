<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white border border-blue-100 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-5xl font-bold text-blue-600">{{ \App\Models\RekapIku::count() }}</div>
                    <div class="text-slate-500 mt-2">Total Data IKU</div>
                </div>
                <div class="bg-white border border-blue-100 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-5xl font-bold text-green-600">{{ \App\Models\User::count() }}</div>
                    <div class="text-slate-500 mt-2">Total Pengguna</div>
                </div>
                <div class="bg-white border border-blue-100 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-5xl font-bold text-purple-600">{{ \App\Models\ActivityLog::count() }}</div>
                    <div class="text-slate-500 mt-2">Total Aktivitas</div>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="bg-white border border-blue-100 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-slate-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold">Aktivitas Terbaru</h3>
                        <a href="{{ route('admin.activities') }}" class="text-blue-600 hover:text-blue-800">Lihat Semua →</a>
                    </div>
                    
                    @if($activities->count() > 0)
                        <table class="min-w-full divide-y divide-blue-100">
                            <thead class="bg-blue-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Waktu</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Pengguna</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Aksi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Deskripsi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-blue-100">
                                @foreach($activities as $activity)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-slate-500">{{ $activity->created_at->diffForHumans() }}</td>
                                        <td class="px-6 py-4 text-sm font-medium">{{ $activity->user->name }}</td>
                                        <td class="px-6 py-4 text-sm">
                                            @if($activity->action == 'create')
                                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">CREATE</span>
                                            @elseif($activity->action == 'update')
                                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">UPDATE</span>
                                            @elseif($activity->action == 'delete')
                                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">DELETE</span>
                                            @else
                                                <span class="bg-slate-100 text-slate-800 px-2 py-1 rounded text-xs">{{ strtoupper($activity->action) }}</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm">{{ $activity->description }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-slate-500 text-center py-4">Belum ada aktivitas tercatat.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

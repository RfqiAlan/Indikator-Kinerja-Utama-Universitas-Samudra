<x-admin-layout activePage="activities">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-800">Log Aktivitas</h1>
        <p class="text-slate-500 mt-1">Semua aktivitas user dalam sistem</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="bg-slate-50">
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600">User</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600">Aksi</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600">Deskripsi</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600">Waktu</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($activities as $activity)
                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 font-semibold text-sm">
                                {{ substr($activity->user->name ?? 'S', 0, 1) }}
                            </div>
                            <span class="text-slate-800">{{ $activity->user->name ?? 'System' }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold 
                            {{ $activity->action === 'create' ? 'bg-emerald-100 text-emerald-700' : '' }}
                            {{ $activity->action === 'update' ? 'bg-amber-100 text-amber-700' : '' }}
                            {{ $activity->action === 'delete' ? 'bg-rose-100 text-rose-700' : '' }}
                            {{ $activity->action === 'login' ? 'bg-cyan-100 text-cyan-700' : '' }}">
                            {{ ucfirst($activity->action) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-slate-600">{{ $activity->description }}</td>
                    <td class="px-6 py-4 text-slate-500 text-sm">{{ $activity->created_at->format('d M Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-slate-500">Belum ada aktivitas</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $activities->links() }}</div>
</x-admin-layout>

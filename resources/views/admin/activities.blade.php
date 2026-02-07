<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Log Aktivitas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-blue-100 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-slate-900">
                    @if($activities->count() > 0)
                        <table class="min-w-full divide-y divide-blue-100">
                            <thead class="bg-blue-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Waktu</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Pengguna</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Aksi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Model</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Deskripsi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-blue-100">
                                @foreach($activities as $activity)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-slate-500">{{ $activity->created_at->format('d/m/Y H:i') }}</td>
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
                                        <td class="px-6 py-4 text-sm">{{ $activity->model }}</td>
                                        <td class="px-6 py-4 text-sm">{{ $activity->description }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        <div class="mt-4">
                            {{ $activities->links() }}
                        </div>
                    @else
                        <p class="text-slate-500 text-center py-4">Belum ada aktivitas tercatat.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

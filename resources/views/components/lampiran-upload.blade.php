{{-- Lampiran Bukti Pendukung Section (Multi-file upload) --}}
<div class="border-t pt-6">
    <h3 class="font-semibold text-slate-800 mb-4 flex items-center">
        <span class="bg-amber-100 text-amber-600 w-7 h-7 rounded-full flex items-center justify-center text-sm mr-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" /></svg>
        </span>
        Lampiran Bukti Pendukung
    </h3>

    {{-- Link ke Google Drive Template --}}
    @php
        $driveLink = isset($ikuNumber) ? get_iku_drive_links($ikuNumber) : null;
    @endphp

    @if($driveLink)
        <a href="{{ $driveLink }}" target="_blank" rel="noopener noreferrer"
           class="mb-4 inline-flex items-center gap-3 px-4 py-2.5 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg border border-blue-200 transition-colors group">
            <svg class="h-6 w-6 text-blue-500 flex-shrink-0" viewBox="0 0 87.3 78" xmlns="http://www.w3.org/2000/svg">
                <path d="m6.6 66.85 3.85 6.65c.8 1.4 1.95 2.5 3.3 3.3l13.75-23.8h-27.5c0 1.55.4 3.1 1.2 4.5z" fill="#0066da"/>
                <path d="m43.65 25-13.75-23.8c-1.35.8-2.5 1.9-3.3 3.3l-20.4 35.3c-.8 1.4-1.2 2.95-1.2 4.5h27.5z" fill="#00ac47"/>
                <path d="m73.55 76.8c1.35-.8 2.5-1.9 3.3-3.3l1.6-2.75 7.65-13.25c.8-1.4 1.2-2.95 1.2-4.5h-27.5l5.4 13.8z" fill="#ea4335"/>
                <path d="m43.65 25 13.75-23.8c-1.35-.8-2.9-1.2-4.5-1.2h-18.5c-1.6 0-3.15.45-4.5 1.2z" fill="#00832d"/>
                <path d="m59.8 53h-32.3l-13.75 23.8c1.35.8 2.9 1.2 4.5 1.2h50.8c1.6 0 3.15-.45 4.5-1.2z" fill="#2684fc"/>
                <path d="m73.4 26.5-10.1-17.5c-.8-1.4-1.95-2.5-3.3-3.3l-13.75 23.8 16.15 23.5h27.45c0-1.55-.4-3.1-1.2-4.5z" fill="#ffba00"/>
            </svg>
            <div>
                <span class="font-semibold text-sm">Buka Template IKU {{ $ikuNumber }} di Google Drive</span>
                <span class="block text-xs text-blue-500">Download template, isi, lalu upload kembali sebagai bukti pendukung</span>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-400 ml-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
            </svg>
        </a>
    @endif

    <div>
        @php
            $driveConnected = auth()->check() && auth()->user()->googleDriveToken;
        @endphp

        {{-- DEBUG: selalu tampil, hapus setelah konfirmasi --}}
        <p style="color:red;font-size:11px;margin:0 0 4px;">
            [DEBUG] driveConnected = {{ $driveConnected ? 'TRUE' : 'FALSE' }}
        </p>

        @if($driveConnected)
            {{-- Badge: Google Drive sudah terhubung --}}
            <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:0.5rem;padding:0.75rem;display:flex;align-items:center;justify-content:space-between;gap:0.75rem;margin-bottom:0.75rem;">
                <div style="display:flex;align-items:center;gap:0.625rem;">
                    {{-- Google Drive icon --}}
                    <svg style="height:1.25rem;width:1.25rem;flex-shrink:0;" viewBox="0 0 87.3 78" xmlns="http://www.w3.org/2000/svg">
                        <path d="m6.6 66.85 3.85 6.65c.8 1.4 1.95 2.5 3.3 3.3l13.75-23.8h-27.5c0 1.55.4 3.1 1.2 4.5z" fill="#0066da"/>
                        <path d="m43.65 25-13.75-23.8c-1.35.8-2.5 1.9-3.3 3.3l-20.4 35.3c-.8 1.4-1.2 2.95-1.2 4.5h27.5z" fill="#00ac47"/>
                        <path d="m73.55 76.8c1.35-.8 2.5-1.9 3.3-3.3l1.6-2.75 7.65-13.25c.8-1.4 1.2-2.95 1.2-4.5h-27.5l5.4 13.8z" fill="#ea4335"/>
                        <path d="m43.65 25 13.75-23.8c-1.35-.8-2.9-1.2-4.5-1.2h-18.5c-1.6 0-3.15.45-4.5 1.2z" fill="#00832d"/>
                        <path d="m59.8 53h-32.3l-13.75 23.8c1.35.8 2.9 1.2 4.5 1.2h50.8c1.6 0 3.15-.45 4.5-1.2z" fill="#2684fc"/>
                        <path d="m73.4 26.5-10.1-17.5c-.8-1.4-1.95-2.5-3.3-3.3l-13.75 23.8 16.15 23.5h27.45c0-1.55-.4-3.1-1.2-4.5z" fill="#ffba00"/>
                    </svg>
                    <div>
                        <p style="font-size:0.875rem;font-weight:600;color:#15803d;margin:0;">Google Drive Terhubung</p>
                        <p style="font-size:0.75rem;color:#16a34a;margin:0;">File lampiran yang Anda upload akan otomatis tersimpan ke Google Drive.</p>
                    </div>
                </div>
                {{-- Checkmark --}}
                <span style="flex-shrink:0;width:1.5rem;height:1.5rem;border-radius:9999px;background:#16a34a;display:flex;align-items:center;justify-content:center;">
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:0.875rem;height:0.875rem;color:white;" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                </span>
            </div>
        @else
            {{-- Banner: Google Drive belum terhubung --}}
            <div style="background:#fffbeb;border:1px solid #fde68a;border-radius:0.5rem;padding:0.75rem;display:flex;align-items:center;justify-content:space-between;gap:0.75rem;margin-bottom:0.75rem;">
                <div style="display:flex;align-items:center;gap:0.625rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" style="height:1.25rem;width:1.25rem;color:#d97706;flex-shrink:0;" fill="none" viewBox="0 0 24 24" stroke="#d97706">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                    </svg>
                    <div>
                        <p style="font-size:0.875rem;font-weight:600;color:#92400e;margin:0;">Google Drive Belum Terhubung</p>
                        <p style="font-size:0.75rem;color:#b45309;margin:0;">Anda harus menghubungkan Google Drive sebelum bisa upload lampiran.</p>
                    </div>
                </div>
                <a href="{{ route('user.drive.connect') }}"
                   style="flex-shrink:0;display:inline-flex;align-items:center;gap:0.375rem;padding:0.375rem 0.75rem;background:#f59e0b;color:white;font-size:0.75rem;font-weight:700;border-radius:0.5rem;text-decoration:none;white-space:nowrap;"
                   onmouseover="this.style.background='#d97706'" onmouseout="this.style.background='#f59e0b'">
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:0.875rem;height:0.875rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                    </svg>
                    Hubungkan Sekarang
                </a>
            </div>
        @endif



        <label class="block text-sm font-medium text-slate-700 mb-2">Upload File (PDF, JPG, PNG, DOC - Max 10MB per file)</label>
        <input type="file" name="lampiran[]" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" multiple
            class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer border border-slate-300 rounded-lg focus:ring-blue-500">
        <p class="text-xs text-slate-400 mt-1">Bisa upload lebih dari 1 file sekaligus. File akan diupload ke Google Drive sebagai bukti pendukung.</p>

        {{-- Display existing uploaded files --}}
        @php
            $links = [];
            if (isset($existingLinks) && is_array($existingLinks)) {
                $links = $existingLinks;
            } elseif (isset($existingLink) && $existingLink) {
                $links = is_array($existingLink) ? $existingLink : [$existingLink];
            }
        @endphp

        @if(count($links) > 0)
            <div class="mt-3 bg-blue-50 rounded-lg p-3 space-y-2">
                <div class="flex items-center gap-2 mb-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                    <p class="text-xs text-slate-500 font-medium">File lampiran yang sudah diupload ({{ count($links) }} file):</p>
                </div>
                @foreach($links as $index => $link)
                    <div class="flex items-center gap-2 pl-7">
                        <span class="text-xs text-slate-400 font-mono">{{ $index + 1 }}.</span>
                        <a href="{{ $link }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800 underline font-medium truncate">Lampiran {{ $index + 1 }} &rarr;</a>
                    </div>
                @endforeach
                <p class="text-xs text-slate-400 pl-7 mt-1">Upload file baru untuk menambah lampiran</p>
            </div>
        @endif
    </div>
</div>

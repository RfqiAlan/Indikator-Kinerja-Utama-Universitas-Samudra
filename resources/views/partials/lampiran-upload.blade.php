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



        {{-- Get existing uploaded files --}}
        @php
            $links = [];
            if (isset($existingLinks) && is_array($existingLinks)) {
                $links = $existingLinks;
            } elseif (isset($existingLink) && $existingLink) {
                $links = is_array($existingLink) ? $existingLink : [$existingLink];
            }
        @endphp

        <label class="block text-sm font-medium text-slate-700 mb-2">
            Upload File Lampiran <span class="text-slate-400 font-normal">(PDF, JPG, PNG, DOC, RAR, ZIP — Maks. 50MB/file)</span>
            @if(count($links) === 0) <span class="text-red-500">*</span> @endif
        </label>

        {{-- Error Display --}}
        @error('lampiran')
            <p class="text-xs text-rose-500 mb-2 font-medium flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                {{ $message }}
            </p>
        @enderror
        @if($errors->has('lampiran.*'))
            <div class="mb-2 space-y-1">
                @foreach($errors->get('lampiran.*') as $messages)
                    @foreach($messages as $message)
                        <p class="text-xs text-rose-500 font-medium flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                            {{ $message }}
                        </p>
                    @endforeach
                @endforeach
            </div>
        @endif


        {{-- Drop zone wrapper --}}
        <div x-data="lampiranUpload()" class="relative">
            {{-- Visual drop zone --}}
            <label
                @dragover.prevent="dragging = true"
                @dragleave.prevent="dragging = false"
                @drop.prevent="onDrop($event)"
                :class="dragging ? 'border-blue-400 bg-blue-50' : 'border-slate-300 bg-white hover:bg-slate-50'"
                class="flex flex-col items-center justify-center w-full px-4 py-6 border-2 border-dashed rounded-xl cursor-pointer transition-colors duration-200 group"
            >
                <input
                    type="file"
                    name="lampiran[]"
                    accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.rar,.zip"
                    multiple
                    @if(count($links) === 0) required @endif
                    class="sr-only"
                    @change="onFileChange($event)"
                    x-ref="fileInput"
                >
                {{-- Icon --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mb-2 text-slate-400 group-hover:text-blue-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                </svg>
                <p class="text-sm text-slate-600 font-medium">Klik untuk pilih file <span class="text-blue-600">atau seret & lepas di sini</span></p>
                <p class="text-xs text-slate-400 mt-1">PDF · JPG · PNG · DOC · DOCX · <strong>RAR · ZIP</strong> — Maks. 50MB per file</p>
            </label>

            {{-- Selected files preview --}}
            <template x-if="selectedFiles.length > 0">
                <ul class="mt-3 space-y-1.5">
                    <template x-for="(f, i) in selectedFiles" :key="i">
                        <li class="flex items-center gap-2 px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span class="truncate text-slate-700 flex-1" x-text="f.name"></span>
                            <span class="text-xs text-slate-400 flex-shrink-0" x-text="formatSize(f.size)"></span>
                            <button type="button" @click="removeFile(i)" class="text-slate-400 hover:text-red-500 transition-colors flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </li>
                    </template>
                </ul>
            </template>
        </div>

        <script>
        function lampiranUpload() {
            return {
                dragging: false,
                selectedFiles: [],
                dt: null,
                onFileChange(e) {
                    const files = Array.from(e.target.files || []);
                    this.selectedFiles = files;
                },
                onDrop(e) {
                    this.dragging = false;
                    const files = Array.from(e.dataTransfer.files || []);
                    this.selectedFiles = files;
                    // Transfer to actual input via DataTransfer
                    const dt = new DataTransfer();
                    files.forEach(f => dt.items.add(f));
                    this.$refs.fileInput.files = dt.files;
                },
                removeFile(index) {
                    this.selectedFiles.splice(index, 1);
                    const dt = new DataTransfer();
                    this.selectedFiles.forEach(f => dt.items.add(f));
                    this.$refs.fileInput.files = dt.files;
                },
                formatSize(bytes) {
                    if (bytes < 1024) return bytes + ' B';
                    if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
                    return (bytes / 1048576).toFixed(1) + ' MB';
                }
            }
        }
        </script>

        <p class="text-xs text-slate-400 mt-2">File akan diupload ke Google Drive sebagai bukti pendukung. Bisa pilih lebih dari 1 file.</p>

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

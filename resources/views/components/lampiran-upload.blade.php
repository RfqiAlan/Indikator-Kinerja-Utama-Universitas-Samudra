{{-- Lampiran Bukti Pendukung Section --}}
<div class="border-t pt-6">
    <h3 class="font-semibold text-slate-800 mb-4 flex items-center">
        <span class="bg-amber-100 text-amber-600 w-7 h-7 rounded-full flex items-center justify-center text-sm mr-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" /></svg>
        </span>
        Lampiran Bukti Pendukung
    </h3>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-2">Upload File (PDF, JPG, PNG, DOC - Max 10MB)</label>
        <input type="file" name="lampiran" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"
            class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer border border-slate-300 rounded-lg focus:ring-emerald-500">
        <p class="text-xs text-slate-400 mt-1">File akan diupload ke Google Drive sebagai bukti pendukung.</p>
        @if(isset($existingLink) && $existingLink)
            <div class="mt-3 flex items-center gap-2 bg-blue-50 rounded-lg p-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                <div>
                    <p class="text-xs text-slate-500">File lampiran sudah ada:</p>
                    <a href="{{ $existingLink }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800 underline font-medium">Lihat Lampiran Saat Ini →</a>
                </div>
                <span class="text-xs text-slate-400 ml-auto">Upload file baru untuk mengganti</span>
            </div>
        @endif
    </div>
</div>

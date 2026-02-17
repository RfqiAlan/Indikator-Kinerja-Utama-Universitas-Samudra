@props(['selected' => null])

@php
    $tahunList = get_tahun_akademik_list();
    $currentTahun = $selected ?? get_tahun_akademik();
@endphp

<select name="tahun_akademik" {{ $attributes->merge(['class' => 'w-full rounded-lg border-slate-300 focus:ring-emerald-500', 'required' => true]) }}>
    <option value="">-- Pilih Tahun Akademik --</option>
    @foreach($tahunList as $tahun)
        <option value="{{ $tahun }}" {{ old('tahun_akademik', $currentTahun) == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
    @endforeach
</select>

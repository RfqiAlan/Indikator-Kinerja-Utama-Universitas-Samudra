@props(['name', 'model', 'value' => 0, 'class' => 'w-full rounded-lg border-slate-300'])

<div class="relative" x-data="{
    raw: {{ $value ?: 0 }},
    display: '',
    init() {
        this.display = this.raw ? new Intl.NumberFormat('id-ID').format(this.raw) : '';
        // Sync raw value to parent model initially
        this.{{ $model }} = this.raw;
    },
    update(val) {
        let num = val.replace(/[^0-9]/g, '');
        this.raw = num ? parseInt(num, 10) : 0;
        this.display = num ? new Intl.NumberFormat('id-ID').format(this.raw) : '';
        // Sync to parent component model
        this.{{ $model }} = this.raw;
    }
}">
    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
        <span class="text-slate-500 font-medium sm:text-sm">Rp</span>
    </div>
    <input type="text" x-model="display" @input="update($event.target.value)" class="{{ $class }}" style="padding-left: 2.75rem !important;" placeholder="0">
    <input type="hidden" name="{{ $name }}" x-bind:value="raw">
</div>

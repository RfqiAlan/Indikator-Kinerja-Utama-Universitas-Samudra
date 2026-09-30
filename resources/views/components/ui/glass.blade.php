<div {{ $attributes->merge(['class' => '
    relative isolation-auto overflow-hidden rounded-2xl
    bg-white/70 dark:bg-slate-800/40 
    backdrop-blur-xl saturate-[1.8] contrast-[1.05]
    border border-slate-200/50 dark:border-white/10
    shadow-[inset_0_1px_0_rgba(255,255,255,0.6)] dark:shadow-[inset_0_1px_0_rgba(255,255,255,0.1)]
    ring-1 ring-black/5 dark:ring-0
']) }}>
    <!-- Inner highlight for extra depth (optional pseudo-element approx) -->
    <div class="absolute inset-0 z-[-1] pointer-events-none rounded-inherit 
                bg-gradient-to-br from-white/40 to-transparent dark:from-white/5 dark:to-transparent">
    </div>
    <div class="relative z-10">
        {{ $slot }}
    </div>
</div>

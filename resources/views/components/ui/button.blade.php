@props(['variant' => 'primary', 'type' => 'button', 'href' => null])

@php
    $baseClasses = 'inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 transform active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-slate-950 whitespace-nowrap';
    
    $variants = [
        'primary' => 'bg-blue-600 text-white hover:bg-blue-700 shadow-md shadow-blue-600/20 ring-1 ring-blue-500 focus:ring-blue-500',
        'secondary' => 'bg-white dark:bg-slate-800 text-slate-700 dark:text-[#E5E7EB] border border-slate-200 dark:border-white/10 hover:bg-slate-50 dark:hover:bg-slate-700 focus:ring-slate-200',
        'danger' => 'bg-rose-50 dark:bg-rose-500/10 text-rose-600 dark:text-rose-400 hover:bg-rose-100 dark:hover:bg-rose-500/20 ring-1 ring-rose-100 dark:ring-rose-500/20 focus:ring-rose-500',
        'ghost' => 'bg-transparent text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-[#E5E7EB]',
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif

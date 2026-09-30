@props(['padding' => 'p-6'])

<div {{ $attributes->merge(['class' => 'bg-semantic-surface rounded-2xl shadow-sm border border-semantic-border ' . $padding]) }}>
    {{ $slot }}
</div>

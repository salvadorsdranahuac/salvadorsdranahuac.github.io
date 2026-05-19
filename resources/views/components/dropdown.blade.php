{{-- resources/views/components/dropdown.blade.php --}}
@props([
    'id' => 'dropdown-'.uniqid(),
    'label' => null,
    'align' => 'left', // left | right
])

@php
    $alignment = $align === 'right'
        ? 'right-0 origin-top-right'
        : 'left-0 origin-top-left';
@endphp

<div
    x-data="{}"
    class="relative inline-block"
    data-dropdown
    id="{{ $id }}"
>
    {{-- Trigger --}}
    <div data-dropdown-trigger>
        {{ $label ?? $trigger }}
    </div>

    {{-- Menu --}}
    <div
        data-dropdown-menu
        class="absolute z-50 mt-2 hidden min-w-32 overflow-hidden rounded-2xl border border-slate-200 bg-[var(--bg)] text-[var(--text)] px-1.5 py-2 shadow-xl {{ $alignment }}"
    >
        {{ $slot }}
    </div>
</div>
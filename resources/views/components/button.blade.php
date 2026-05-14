@props([
    'color' => 'orange',
    'shade' => 500,
    'outline' => false,
])

@php
    $hoverShade = min($shade + 100, 900);
    $lightShade = max($shade - 100, 50);

    $baseClasses = 'rounded-xl px-4 py-2 font-medium transition';

    $background = "bg-{$color}-{$shade} hover:bg-{$color}-{$hoverShade}";
    $border = '';
    $text = $shade >= 500 ? 'text-white' : "text-{$color}-900";

    if ($outline) {
        $background = "hover:bg-{$color}-{$lightShade}";
        $border = "border border-{$color}-{$shade}";
        $hoverText = $lightShade >= 500 ? 'hover:text-white' : "hover:text-{$color}-900";

        $text = "text-{$color}-{$shade} {$hoverText}";
    }

    $classes = implode(' ', [
        $baseClasses,
        $background,
        $border,
        $text,
    ]);
@endphp

<button {{ $attributes->twMerge(['class' => $classes]) }}>
    {{ $slot }}
</button>
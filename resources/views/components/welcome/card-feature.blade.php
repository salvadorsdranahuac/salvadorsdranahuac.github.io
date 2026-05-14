@props([
    'image',
    'breakpoint' => 'lg',
])

<div {{ $attributes->twMerge("
    min-w-[30rem] {$breakpoint}:min-w-0 flex-1 p-6 bg-orange-800 rounded-3xl
    flex flex-row {$breakpoint}:flex-col items-center gap-3
") }}>
    <img class="rounded-3xl max-{{$breakpoint}}:max-h-40" src="{{ $image }}" />

    {{ $slot }}
</div>
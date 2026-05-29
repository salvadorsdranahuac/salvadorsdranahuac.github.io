@props([
    'image',
    'breakpoint' => 'lg',
])

    <div {{ $attributes->twMerge("
    min-w-[min(30rem,75vw)] {$breakpoint}:min-w-[33rem] flex-1 p-6 bg-orange-800 rounded-3xl overflow-hidden
    flex flex-row {$breakpoint}:flex-col items-center gap-3") }}>
        <div class="rounded-3xl min-h-32  {{$breakpoint}}:min-h-[20rem] {{$breakpoint}}:w-full {{$breakpoint}}:flex-1 overflow-hidden">
            <img class="w-full h-full pointer-events-none object-cover mt-[-15%] {{$breakpoint}}:mt-0" src="{{ $image }}" />
        </div>
    <div class="{{$breakpoint}}:h-[3em]">
    {{ $slot }}
    </div>
</div>
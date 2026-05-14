<div {{
    $attributes->twMerge([
        'class' => 'flex-1 p-6 bg-zinc-950 rounded-2xl border border-zinc-900 flex items-center gap-4 overflow-hidden card-black'
    ])
}}>
    @if(!empty($img))
        <img class="h-20 w-20 lg:hidden xl:block" src="{{ $img }}" />
    @endif

    <div class="flex flex-col items-start gap-1 min-w-0">
        <div class="text-white text-2xl font-extrabold font-['Zilla_Slab'] inline-flex items-center gap-3">
            @if(!empty($img))
                <img class="h-20 w-20 max-lg:hidden xl:hidden" src="{{ $img }}" />
            @endif

            {{ $title ?? '' }}
        </div>

        <div class="text-zinc-400 text-xl">
            {{ $slot }}
        </div>
    </div>
</div>
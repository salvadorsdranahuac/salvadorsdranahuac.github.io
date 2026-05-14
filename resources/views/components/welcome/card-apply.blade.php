@props([
    'href' => '#',
])

<div {{
    $attributes->merge([
        'class' => 'flex-1 rounded-3xl border-2 border-[currentcolor] p-5 hover:text-orange-500 hover:bg-zinc-800 transition flex flex-col gap-5 text-left group'
    ])
}}>
    <div>
        <div class="text-3xl font-extrabold">
            {{ $title }}
        </div>

        {{ $slot }}
    </div>

    <a
        href="{{ $href }}"
        class="self-center mt-auto rounded-full bg-white px-4 py-3 text-xl text-zinc-900 transition hover:text-white group-hover:bg-orange-500"
    >
        {{ $button }}
    </a>
</div>
@props([
    'title',
    'btn_text' => null,
    'btn_link' => null,
    'count' => null,
    'grow' => true,
    'loader' => true,
    'footer' => null,
])

<div {{ $attributes->merge([
    'class' => 'relative h-auto flex flex-col bg-white/50 dark:bg-neutral-950 backdrop-filter backdrop-blur-md dark:backdrop-blur-none text-zinc-900 dark:text-white border border-zinc-300/60 dark:border-none rounded-2xl p-2 overflow-clip shadow-[0px_11px_21px_0px_rgba(0,_0,_0,_0.07)] transition-all duration-200 ease-in-out'
]) }}>
    @if($loader)
        <div wire:loading.delay x-cloak class="z-40 absolute inset-0">
            <div class="relative w-full h-full flex bg-white/60 justify-center items-center dark:bg-zinc-900/75">
                <x-loading-spinner class="relative z-50 size-6 text-indigo-500 dark:text-pink-500" />
            </div>
        </div>
    @endif
    @isset($tableHeader)
        {{ $tableHeader }}
    @else
        <div class="w-full flex justify-between items-center p-2 pr-4 pb-3">
            <div class="flex items-center space-x-2">
                @isset($icon)
                    {{ $icon }}
                @else
                    <i class="fa-light fa-file-chart-column text-lg text-zinc-800 dark:text-green-400"></i>
                @endisset

                <h2 class="font-medium text-zinc-700 dark:text-white">{{ $title }}</h2>
            </div>

            @if ($btn_text && $btn_link)
                <a href="{{ $btn_link }}"
                   class="w-auto bg-white hover:bg-white/70 dark:bg-white/20 dark:hover:bg-white/25 text-zinc-900 dark:text-white px-2 py-1 rounded-md text-xs"
                >{{ $btn_text }}</a>
            @endif
        </div>
    @endif

    <div class="relative z-0 scroll-content w-full h-full {{ $grow ? 'grow' : '' }} flex flex-col gap-1 bg-white dark:bg-white/5 border border-zinc-300/70 dark:border-transparent rounded-xl p-1 box-border shadow-sm overflow-clip overflow-y-scroll no-scrollbar">
        <div class="relative h-full z-0">
            {{ $slot }}
        </div>
    </div>

    @isset($footer)
        {{ $footer }}
    @endisset

    @if($count >= 10)
        <div x-ref="shadow"
             class="z-10 absolute left-2 bottom-2 w-[calc(100%-1rem)] h-4 bg-gradient-to-b from-transparent via-zinc-900/5 dark:via-zinc-900/30 to-zinc-900/10 dark:to-zinc-900/50 rounded-b-xl pointer-events-none"
        ></div>
    @endif

</div>

<header class=" text-2xl bg-[url('/public/img/logo-image.jpg')] h-screen bg-cover">

    {{-- toast --}}
    @if (session()->has('message'))
        <div x-data="{
            show: true,
            asd: 'asd',
            init() {
                setTimeout(() => this.show = false, 4000)
            }
        }" class="bg-orange-400 text-white rounded px-10 py-4 absolute top-32 left-[50%] z-20 -translate-x-1/2 text-center"
          x-show="show">
            <p>{{ session()->get('message') }}</p>
        </div>
    @endif
    {{-- /toast --}}

    <div class="absolute w-full h-full bottom-0 left-0
    bg-gradient-to-r from-transparent to-white">
        <div class="absolute top-[30%] right-[12%] w-[70%] md:w-[30%] ">
            <p class="font-amatic text-4xl md:text-6xl md:leading-[60px]">тортики, які створені
                з любов’ю
                <span class="text-red-300 pl-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-12 h-12 inline">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                    </svg>
                </span>
            </p>
            <p class="mt-10 font-caveat text-3xl md:text-4xl text-red-800">
                Скуштувавши це, ви залишитеся з нами назавжди!
            </p>
        </div>
    </div>
    @include('layouts.nav-menu')
</header>

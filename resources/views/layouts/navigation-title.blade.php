<header class="text-2xl bg-[url('/public/img/logo-image.jpg')] h-[90vh] bg-cover bg-center relative">

    {{-- toast --}}
    @if (session()->has('message'))
        <div x-data="{
            show: true,
            init() { setTimeout(() => this.show = false, 4000) }
        }" class="bg-brand-rose text-white rounded-xl px-10 py-4 absolute top-32 left-[50%] z-20 -translate-x-1/2 text-center shadow-lg"
          x-show="show">
            <p>{{ session()->get('message') }}</p>
        </div>
    @endif
    {{-- /toast --}}

    <!-- Gradient overlay -->
    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-transparent to-white/90"></div>

    <!-- Text block -->
    <div class="absolute top-[28%] right-[6%] w-[72%] md:w-[32%]">
        <p class="font-amatic text-6xl md:text-7xl md:leading-[82px] text-brand-text drop-shadow-sm">
            тортики, які створені
            з любов'ю
            <span class="text-brand-rose pl-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                    class="w-10 h-10 inline">
                    <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
                </svg>
            </span>
        </p>
        <p class="mt-6 font-caveat text-2xl md:text-3xl text-brand-muted">
            Скуштувавши це, ви залишитеся з нами назавжди!
        </p>
        <a href="{{ route('filling', App\Models\Type::first()) }}"
            class="inline-block mt-8 px-8 py-3 bg-brand-rose text-white rounded-full text-xl font-alice
            hover:bg-brand-rose-dark transition-colors duration-200 shadow-md">
            Переглянути каталог
        </a>
    </div>

    @include('layouts.nav-menu')
</header>

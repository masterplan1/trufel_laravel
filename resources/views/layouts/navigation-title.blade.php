<header class="text-2xl bg-[url('/public/img/logo-image.jpg')] h-[42vh] min-h-[420px] bg-cover bg-center relative">
<div class="absolute inset-0 bg-white/20"></div>
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
    <!-- <div class="absolute inset-0 bg-gradient-to-r from-transparent via-transparent to-white/90"></div> -->

    <!-- Text block -->
    <div class="absolute top-[22%] right-[4%] w-auto
                backdrop-blur-sm bg-white/30 rounded-2xl p-2">
        <p class="font-amatic text-4xl md:text-7xl md:leading-[82px] text-brand-text">
            тортики, які створені
            з любов'ю
        </p>
        <!-- <p class="mt-6 font-caveat text-2xl md:text-3xl text-brand-muted">
            Скуштувавши це, ви залишитеся з нами назавжди!
        </p> -->
    </div>

    @include('layouts.nav-menu')
</header>

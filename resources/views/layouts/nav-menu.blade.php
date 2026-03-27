<?php
  $types = App\Models\Type::getAll();
?>
<div x-data="{
  cartItemsCount: {{ App\Http\Helpers\Cart::getCartItemsCount() }},
  openMobileCatalogMenu: false,
  showMobileMenu: false,
  cartChange($event){
    this.cartItemsCount = $event.detail.count
  },
}"
  class="bg-brand-cream z-20 absolute w-full"
  @cart-change.window="cartChange($event)"
>

  <!-- Mobile Nav -->
  <nav x-cloak :class="showMobileMenu ? 'left-0' : '-left-[220px]'"
    x-transition class="block md:hidden fixed top-0 bottom-0 bg-brand-cream w-[220px] h-full pt-20 shadow-xl transition-all z-30">
    <ul @click.outside="showMobileMenu = false">
      <li><a class="p-navbar-item block hover:bg-brand-blush transition-colors" href="/">Головна</a></li>
      <li class="relative">
        <a @click="openMobileCatalogMenu = !openMobileCatalogMenu"
          class="cursor-pointer p-navbar-item block hover:bg-brand-blush transition-colors">
          <span class="flex items-center justify-between">
            Каталог
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
              class="w-5 h-5 -ml-8 transition-transform duration-200"
              :class="openMobileCatalogMenu ? 'rotate-180' : ''">
              <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
            </svg>
          </span>
        </a>
        <ul x-show="openMobileCatalogMenu" x-transition class="bg-brand-cream text-left text-xl">
          @foreach ($types as $type)
            <li class="cursor-pointer hover:bg-brand-blush transition-colors">
              <a class="py-1 px-6 block" href="{{ route('filling', $type) }}">{{ $type->name }}</a>
            </li>
          @endforeach
        </ul>
      </li>
      <li><a class="p-navbar-item block hover:bg-brand-blush transition-colors" href="{{ route('testimonials') }}">Відгуки</a></li>
      <li><a class="p-navbar-item block hover:bg-brand-blush transition-colors" href="{{ route('contacts') }}">Контакти</a></li>
    </ul>
  </nav>

  <!-- Overlay for mobile menu -->
  <div x-cloak x-show="showMobileMenu" @click="showMobileMenu = false"
    class="block md:hidden fixed inset-0 bg-black/20 z-20"></div>

  <div class="flex justify-between items-center max-w-5xl m-auto">

    <!-- Burger button -->
    <button @click="showMobileMenu = !showMobileMenu" class="block md:hidden p-navbar-item z-40">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
      </svg>
    </button>

    <!-- Logo -->
    <div class="p-navbar-item">
      <a href="/" class="flex font-marck text-3xl text-brand-text hover:text-brand-rose transition-colors duration-200">
        <span>tru</span>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
          stroke="currentColor" class="w-8 h-8">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.87c1.355 0 2.697.055 4.024.165C17.155 8.51 18 9.473 18 10.608v2.513m-3-4.87v-1.5m-6 1.5v-1.5m12 9.75l-1.5.75a3.354 3.354 0 01-3 0 3.354 3.354 0 00-3 0 3.354 3.354 0 01-3 0 3.354 3.354 0 00-3 0 3.354 3.354 0 01-3 0L3 16.5m15-3.38a48.474 48.474 0 00-6-.37c-2.032 0-4.034.125-6 .37m12 0c.39.049.777.102 1.163.16 1.07.16 1.837 1.094 1.837 2.175v5.17c0 .62-.504 1.124-1.125 1.124H4.125A1.125 1.125 0 013 20.625v-5.17c0-1.08.768-2.014 1.837-2.174A47.78 47.78 0 016 13.12M12.265 3.11a.375.375 0 11-.53 0L12 2.845l.265.265zm-3 0a.375.375 0 11-.53 0L9 2.845l.265.265zm6 0a.375.375 0 11-.53 0L15 2.845l.265.265z" />
        </svg>
        <span>fel</span>
      </a>
    </div>

    <!-- Desktop nav -->
    <nav x-data="{ openCatalogMenu: false }" class="flex-1 hidden md:block">
      <ul @click.outside="openCatalogMenu = false" class="grid grid-flow-col text-center">
        <li>
          <a class="p-navbar-item block hover:text-brand-rose transition-colors duration-200" href="/">Головна</a>
        </li>
        <li class="relative cursor-pointer">
          <a @click="openCatalogMenu = !openCatalogMenu"
            class="p-navbar-item block hover:text-brand-rose transition-colors duration-200">
            <span class="flex items-center justify-center gap-1">
              Каталог
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-4 h-4 transition-transform duration-200"
                :class="openCatalogMenu ? 'rotate-180' : ''">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
              </svg>
            </span>
          </a>
          <ul x-cloak x-show="openCatalogMenu" x-transition
            class="absolute top-full left-0 bg-brand-cream text-left shadow-lg rounded-b-xl border border-t-0 border-brand-blush overflow-hidden min-w-[160px] z-50">
            @foreach ($types as $type)
              <li class="cursor-pointer hover:bg-brand-blush transition-colors">
                <a class="py-2.5 px-5 block" href="{{ route('filling', $type) }}">{{ $type->name }}</a>
              </li>
            @endforeach
          </ul>
        </li>
        <li>
          <a class="p-navbar-item block hover:text-brand-rose transition-colors duration-200" href="{{ route('testimonials') }}">Відгуки</a>
        </li>
        <li>
          <a class="p-navbar-item block hover:text-brand-rose transition-colors duration-200" href="{{ route('contacts') }}">Контакти</a>
        </li>
      </ul>
    </nav>

    <!-- Cart -->
    <div class="p-navbar-item">
      <a href="{{ route('cart.index') }}" class="flex relative text-brand-text hover:text-brand-rose transition-colors duration-200">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
          stroke="currentColor" class="w-8 h-8">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
        </svg>
        <small x-cloak
          class="absolute -bottom-1 -left-1 z-10 p-3 w-3 h-3 leading-none text-white text-xs flex items-center justify-center bg-brand-rose rounded-full"
          x-show="cartItemsCount > 0" x-text="cartItemsCount"></small>
      </a>
    </div>

  </div>
</div>

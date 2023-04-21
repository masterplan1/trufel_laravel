<?php
  $types = App\Models\Type::getAll();
  // print_r($types);
?>
<div x-data="{
  cartItemsCount: {{ App\Http\Helpers\Cart::getCartItemsCount() }},
  openMobileGalleryMenu: false, 
  openMobileOrderMenu: false,
  showMobileMenu: false,
  toggleMobileGallaryMenu(){
    this.openMobileGalleryMenu = !this.openGalleryMenu
    this.openMobileOrderMenu = false
  },
  toggleMobileOrderMenu(){
    this.openMobileOrderMenu = !this.openOrderMenu
    this.openMobileGalleryMenu = false
  },
  closeAllMobileMenus(){
    this.openMobileGalleryMenu = false 
    this.openMobileOrderMenu = false
  },
  cartChange($event){
    console.log('asdasdads', $event.detail.count)
    this.cartItemsCount = $event.detail.count
  },
}" 
  class="bg-amber-50 z-20 absolute w-full"
  @cart-change.window="cartChange($event)"
  {{-- @cart-change.window="cartItemsCount = $event.detail.count" --}}
 
>

  <!-- Mobile Nav -->
  <nav x-cloak :class="showMobileMenu ? 'left-0' : '-left-[220px]'" x-transition class="block md:hidden fixed top-0 bottom-0 bg-amber-50 w-[220px] h-full pt-20
    shadow-xl transition-all">
    <ul class="">
      <li><a class="p-navbar-item block hover:bg-amber-100 transition-colors" href="/">Головна</a></li>
      <li class="relative">
        <a @click="toggleMobileGallaryMenu" class="cursor-pointer p-navbar-item block hover:bg-amber-100 transition-colors">
          <span class="flex items-center justify-between">
            Галерея
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 -ml-8">
              <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
            </svg>
          </span>
        </a>
        <ul x-show="openMobileGalleryMenu" x-transition class="bg-amber-50 text-left h-[180px] transition-all text-xl overflow-hidden">
          @foreach ($types as $type)
            <li class="cursor-pointer hover:bg-amber-100 transition-colors"><a class="py-1 px-6 block" href="{{ route('product', $type) }}">{{ $type->name }}</a></li>
          @endforeach
        </ul>
      </li>
      <li class="relative">
        <a @click="toggleMobileOrderMenu" class="cursor-pointer p-navbar-item block hover:bg-amber-100 transition-colors" href="javascript:void(0)">
          <span class="flex items-center justify-between">
            Замовити
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 -ml-8">
              <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
            </svg>
          </span>
        </a>
        <ul x-show="openMobileOrderMenu" x-transition class="bg-amber-50 text-left h-[180px] transition-all text-xl overflow-hidden">
          @foreach ($types as $type)
            <li class="cursor-pointer hover:bg-amber-100 transition-colors"><a class="py-1 px-6 block" href="{{ route('filling', $type) }}">{{ $type->name }}</a></li>
          @endforeach
        </ul>
      </li>
      <li><a class="p-navbar-item block hover:bg-amber-100 transition-colors" href="{{ route('contacts') }}">Контакти</a></li>
      <li><a class="p-navbar-item block hover:bg-amber-100 transition-colors" href="{{ route('testimonials') }}">Відгуки</a></li>
    </ul>
  </nav>
  <div class="flex justify-between max-w-5xl m-auto">
    <button @click="showMobileMenu = !showMobileMenu" class="block md:hidden p-navbar-item z-20">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
      </svg>
    </button>
    <div class="p-navbar-item">
      <a href="/" class="flex font-marck text-3xl">
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
    <nav x-data="{
      openGalleryMenu: false, 
      openOrderMenu: false,
      toggleGallaryMenu(){
        this.openGalleryMenu = !this.openGalleryMenu
        this.openOrderMenu = false
      },
      toggleOrderMenu(){
        this.openOrderMenu = !this.openOrderMenu
        this.openGalleryMenu = false
      },
      closeAllMenus(){
        this.openGalleryMenu = false 
        this.openOrderMenu = false
      }
    }" class="flex-1 hidden md:block">
      <ul @click.outside="closeAllMenus" class="grid grid-flow-col text-center">
        <li><a class="p-navbar-item block hover:text-gray-400 transition-colors" href="/">Головна</a></li>
        <li class="relative cursor-pointer">
          <a @click="toggleGallaryMenu" class="p-navbar-item block hover:text-gray-400 transition-colors">
            <span class="flex items-center justify-between">
              Галерея
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 -ml-8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
              </svg>
            </span>
          </a>
          <ul x-cloak x-show="openGalleryMenu" x-transition class="absolute left-1 bg-amber-50 text-left text-xl">
            @foreach ($types as $type)
              <li class="cursor-pointer hover:bg-amber-100  transition-colors"><a class="py-2 px-4 block" href="{{ route('product', $type) }}">{{ $type->name }}</a></li>
            @endforeach
          </ul>
        </li>
        <li class="relative cursor-pointer">
          <a @click="toggleOrderMenu" class="p-navbar-item block hover:text-gray-400 transition-colors">
            <span class="flex items-center justify-between">
              Замовити
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 -ml-8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
              </svg>
            </span>
          </a>
          <ul x-cloak x-show="openOrderMenu" x-transition class="absolute left-1 bg-amber-50 text-left text-xl">
            @foreach ($types as $type)
             <li class="cursor-pointer hover:bg-amber-100 transition-colors"><a class="py-2 px-4 block" href="{{ route('filling', $type) }}">{{ $type->name }}</a></li>
            @endforeach
          </ul>
        </li>
        <li><a class="p-navbar-item block hover:text-gray-400 transition-colors" href="{{ route('contacts') }}">Контакти</a></li>
        <li><a class="p-navbar-item block hover:text-gray-400 transition-colors" href="{{ route('testimonials') }}">Відгуки</a></li>
      </ul>
    </nav>
    <div class="p-navbar-item">
      <a href="{{ route('cart.index') }}" class="flex relative">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
          stroke="currentColor" class="w-8 h-8tr">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
        </svg>
        <small x-cloak class="absolute -bottom-1 -left-1 z-10 p-3 w-3 h-3 leading-none text-white text-sm flex items-center justify-center bg-red-400 rounded-full" x-show="cartItemsCount > 0" x-text="cartItemsCount"></small>
      </a>
    </div>
  </div>
</div>
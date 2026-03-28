<footer class="w-full bg-[url('/public/img/footer-image.jpg')] bg-cover">
  <div class="max-w-6xl mx-auto px-6 pt-10 pb-6">
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 text-white">

      <!-- Logo & contacts -->
      <div>
        <div class="flex font-marck text-3xl mb-3">
          <span>tru</span>
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="w-8 h-8">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.87c1.355 0 2.697.055 4.024.165C17.155 8.51 18 9.473 18 10.608v2.513m-3-4.87v-1.5m-6 1.5v-1.5m12 9.75l-1.5.75a3.354 3.354 0 01-3 0 3.354 3.354 0 00-3 0 3.354 3.354 0 01-3 0 3.354 3.354 0 00-3 0 3.354 3.354 0 01-3 0L3 16.5m15-3.38a48.474 48.474 0 00-6-.37c-2.032 0-4.034.125-6 .37m12 0c.39.049.777.102 1.163.16 1.07.16 1.837 1.094 1.837 2.175v5.17c0 .62-.504 1.124-1.125 1.124H4.125A1.125 1.125 0 013 20.625v-5.17c0-1.08.768-2.014 1.837-2.174A47.78 47.78 0 016 13.12M12.265 3.11a.375.375 0 11-.53 0L12 2.845l.265.265zm-3 0a.375.375 0 11-.53 0L9 2.845l.265.265zm6 0a.375.375 0 11-.53 0L15 2.845l.265.265z" />
          </svg>
          <span>fel</span>
        </div>
        <p class="text-white/80 text-sm mb-1">м. Обухів, Київська область</p>
        <p class="text-white/80 text-sm mb-3">вул. Дзюбівка, 9</p>
        <a href="tel:+380934978646" class="text-white hover:text-white/70 transition-colors text-lg font-medium">
          +38 093 497 86 46
        </a>
      </div>

      <!-- Navigation -->
      <div>
        <h3 class="text-white font-semibold mb-3 text-sm uppercase tracking-wider">Навігація</h3>
        <ul class="space-y-2 text-white/80">
          <li><a href="/" class="hover:text-white transition-colors">Головна</a></li>
          <li><a href="{{ route('testimonials') }}" class="hover:text-white transition-colors">Відгуки</a></li>
          <li><a href="{{ route('contacts') }}" class="hover:text-white transition-colors">Контакти</a></li>
          <li><a href="{{ route('cart.index') }}" class="hover:text-white transition-colors">Кошик</a></li>
        </ul>
      </div>

      <!-- Social -->
      <div>
        <h3 class="text-white font-semibold mb-3 text-sm uppercase tracking-wider">Соцмережі</h3>
        <a href="https://www.instagram.com/tru._.fel/" target="_blank" rel="noopener"
          class="inline-flex items-center gap-2 text-white/80 hover:text-white transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
          </svg>
          @tru._.fel
        </a>
      </div>

    </div>

    <div class="border-t border-white/20 mt-8 pt-4 flex flex-col sm:flex-row items-center justify-between gap-2">
      <p class="text-white/50 text-xs">&copy; {{ date('Y') }} Trufel. Всі права захищені.</p>
      <a href="{{ route('privacy') }}" class="text-white/50 hover:text-white text-xs transition-colors">
        Політика конфіденційності
      </a>
    </div>
  </div>
</footer>

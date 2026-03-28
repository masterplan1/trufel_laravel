<template x-teleport="body">
  <div
    x-data="modal"
    x-show="$store.cart.openModal"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm overflow-y-auto"
    @click.self="closeModal"
  >
    <div
      x-transition:enter="transition ease-out duration-200"
      x-transition:enter-start="opacity-0 scale-95 translate-y-2"
      x-transition:enter-end="opacity-100 scale-100 translate-y-0"
      x-transition:leave="transition ease-in duration-150"
      x-transition:leave-start="opacity-100 scale-100 translate-y-0"
      x-transition:leave-end="opacity-0 scale-95 translate-y-2"
      class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md mx-auto my-8"
      @click.stop
    >

      {{-- Close button --}}
      <button
        @click="closeModal"
        class="absolute top-3 right-3 w-8 h-8 flex items-center justify-center
               rounded-full text-brand-muted hover:text-brand-rose hover:bg-brand-blush
               transition-colors duration-200 z-10"
      >
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
             stroke-width="2" stroke="currentColor" class="w-5 h-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>

      {{-- Image --}}
      <img
        class="w-full rounded-t-2xl max-h-72 object-cover object-center"
        :src="$store.cart.currentFilling.image"
        alt=""
      >

      {{-- Content --}}
      <div class="p-6">

        {{-- Title --}}
        <h3
          class="font-caveat text-3xl text-brand-rose-dark mb-5 text-center"
          x-text="$store.cart.currentFilling.type_name"
        ></h3>

        <div class="flex flex-col gap-4">

          {{-- Filling name / select --}}
          <div>
            <p class="text-brand-muted text-sm mb-1.5">Начинка</p>
            <template x-if="!$store.cart.currentFilling.type_is_candybar">
              <div class="bg-brand-blush rounded-xl px-4 py-2.5 text-brand-text truncate"
                   x-text="$store.cart.currentFilling.title">
              </div>
            </template>
            <template x-if="!!$store.cart.currentFilling.type_is_candybar">
              <select
                :disabled="isCandybarSelectDisabled"
                x-model="candybarFillingId"
                class="w-full bg-brand-blush rounded-xl px-4 py-2.5 text-brand-text
                       border-0 focus:ring-2 focus:ring-brand-rose focus:outline-none
                       disabled:opacity-60"
              >
                <template x-for="filling in $store.cart.currentFilling.fillings" :key="filling.id">
                  <option :value="filling.id" x-text="filling.title"></option>
                </template>
              </select>
            </template>
          </div>

          {{-- Weight control --}}
          <template x-if="$store.cart.currentFilling.type_weight_quantity === 'weight'">
            <div>
              <p class="text-brand-muted text-sm mb-1.5">Вага</p>
              <div class="flex items-center gap-3">
                <div class="flex items-center bg-brand-blush rounded-xl overflow-hidden">
                  <button
                    @click="minusItemWeight"
                    class="w-10 h-10 flex items-center justify-center text-xl text-brand-muted
                           hover:bg-brand-rose hover:text-white transition-colors duration-200"
                  >−</button>
                  <span
                    class="min-w-[52px] text-center text-brand-text font-medium"
                    x-text="$store.cart.totalAmount"
                  ></span>
                  <button
                    @click="plusItemWeight"
                    class="w-10 h-10 flex items-center justify-center text-xl text-brand-muted
                           hover:bg-brand-rose hover:text-white transition-colors duration-200"
                  >+</button>
                </div>
                <span class="text-brand-muted">кг</span>
              </div>
            </div>
          </template>

          {{-- Quantity control --}}
          <template x-if="$store.cart.currentFilling.type_weight_quantity === 'quantity'">
            <div>
              <p class="text-brand-muted text-sm mb-1.5">Кількість</p>
              <div class="flex items-center gap-3">
                <div class="flex items-center bg-brand-blush rounded-xl overflow-hidden">
                  <button
                    @click="minusItemQuantity"
                    class="w-10 h-10 flex items-center justify-center text-xl text-brand-muted
                           hover:bg-brand-rose hover:text-white transition-colors duration-200"
                  >−</button>
                  <span
                    class="min-w-[52px] text-center text-brand-text font-medium"
                    x-text="$store.cart.totalAmount"
                  ></span>
                  <button
                    @click="plusItemQuantity"
                    class="w-10 h-10 flex items-center justify-center text-xl text-brand-muted
                           hover:bg-brand-rose hover:text-white transition-colors duration-200"
                  >+</button>
                </div>
                <span class="text-brand-muted">шт</span>
              </div>
            </div>
          </template>

          {{-- Price --}}
          <div class="flex justify-end pt-1">
            <p class="text-2xl font-medium text-brand-rose">
              <span x-text="$store.cart.totalPrice"></span> грн
            </p>
          </div>

        </div>

        {{-- Actions --}}
        <div class="flex flex-col sm:flex-row items-center gap-3 mt-5 pt-5 border-t border-brand-blush">

          <template x-if="!isShownGoToCart">
            <button
              @click="addToCart"
              class="button !my-0 !mx-0 w-full sm:w-auto px-10"
            >
              Додати в кошик
            </button>
          </template>

          <template x-if="isShownGoToCart">
            <a
              href="{{ route('cart.index') }}"
              class="button !my-0 !mx-0 w-full sm:w-auto px-10 text-center"
            >
              До кошика →
            </a>
          </template>

          <button
            @click="closeModal"
            class="text-brand-muted hover:text-brand-rose transition-colors duration-200
                   text-base underline underline-offset-2 w-full sm:w-auto text-center py-2"
          >
            Продовжити покупки
          </button>

        </div>
      </div>

    </div>
  </div>
</template>

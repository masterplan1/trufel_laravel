<template x-teleport="body">
  <div x-data="modal" x-show="$store.cart.openModal" class="fixed top-0 left-0 z-30 w-full h-full bg-pink-100/70">
    <div class="bg-white w-3/4 pt-10 sm:p-16 rounded mx-auto mt-5 sm:mt-20">
      <div>
        <div class="px-4 mb-6 relative flex flex-col items-center sm:flex-row sm:text-2xl min-h-[308px]">
          <div @click="closeModal" class="absolute sm:top-0 -top-10 right-1 p-1 rounded cursor-pointer bg-amber-50">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </div>
          <img class="w-[240px] h-[240px] rounded-md object-cover" :src="$store.cart.currentFilling.image" alt="">
          <div class="sm:ml-16 p-4">
            <h3 class="font-caveat text-center text-5xl text-red-800 mb-4" x-text="$store.cart.currentFilling.type?.name"></h3>
            <div class="flex gap-1 sm:gap-6">
              <div class="hidden lg:block">
                <p class="mb-3 p-1">Начинка</span></p>
                <p  @click="console.log(candybarFillingId)">Кількість</p>
              </div>
              <div>
                <template x-if="$store.cart.currentFilling.type?.is_candybar == 0">
                  <p class="bg-red-100 p-1 rounded mb-3 w-full overflow-hidden" x-text="$store.cart.currentFilling.title"></p>
                </template>
                <template x-if="$store.cart.currentFilling.type?.is_candybar == 1">
                  <select x-model="candybarFillingId" class="bg-red-100 p-1 rounded mb-3 w-full overflow-hidden">
                    <template x-for="filling in $store.cart.currentFilling.fillings" :key="filling.id">
                      <option :value="filling.id" x-text="filling.title"></option>
                    </template>
                  </select>
                </template>
                <template x-if="$store.cart.currentFilling.type?.weight_quantity === 'weight'">
                  <div class="flex mb-3">
                    <span class="block mr-3 lg:hidden">Кількість</span>
                    <div class="px-3 bg-red-100 flex gap-4 mr-4 rounded">
                      <p class="cursor-pointer" @click="plusItemWeight">+</p>
                      <p x-text="$store.cart.totalAmount"></p>
                      <p class="cursor-pointer" @click="minusItemWeight">-</p>
                    </div>
                    <p>кг.</p>
                  </div>
                </template>
                <template x-if="$store.cart.currentFilling.type?.weight_quantity === 'quantity'">
                  <div class="flex mb-3">
                    <span class="block mr-3 lg:hidden">Кількість</span>
                    <div class="px-3 bg-red-100 flex gap-4 mr-4 rounded">
                      <p class="cursor-pointer" @click="plusItemQuantity">+</p>
                      <p x-text="$store.cart.totalAmount"></p>
                      <p class="cursor-pointer" @click="minusItemQuantity">-</p>
                    </div>
                    <p>шт.</p>
                  </div>
                </template>
                
                <div class="text-left text-3xl text-red-600 w-full flex justify-end">
                  <span x-text="$store.cart.totalPrice"></span> грн
                </div>
              </div>
              
            </div>
            <div class="flex flex-col lg:flex-row pt-6 min-h-[92px] items-center">
              <button @click="closeModal" class="text-xl px-6 text-gray-600 decoration-slate-500 underline">
                Продовжити покупки
              </button>
              <template x-if="!isShownGoToCart">
                <button @click="addToCart" class="button px-6">Додати до кошика</button>
              </template>
              <template x-if="isShownGoToCart">
                <a href="{{ route('cart.index') }}" @click="addToCart" class="cursor-pointer block text-xl px-6 text-gray-600 decoration-slate-500 underline">
                  Перейти до кошика
                </a>
              </template>
            </div>
          </div>
        </div>
      </div>
    </div>      
  </div>
</template>
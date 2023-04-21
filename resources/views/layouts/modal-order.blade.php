<template x-teleport="body">
  <div x-data="modal" x-show="$store.cart.openModal" class="fixed overflow-y-scroll top-0 left-0 z-30 w-full h-full bg-pink-100/70 p-1">
    <div class="bg-white w-fit pt-10 lg:p-12 rounded mx-auto mt-5 lg:mt-20">
      <div>
        <div class="px-4 relative flex flex-col items-center justify-center lg:flex-row lg:text-2xl min-h-[308px]">
          <div @click="closeModal" class="absolute lg:top-0 -top-10 right-1 p-1 rounded cursor-pointer bg-amber-50">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </div>
          <img class="w-[200px] h-[200px] rounded-md object-cover" :src="$store.cart.currentFilling.image" alt="">
          <div class="lg:ml-16 p-4">
            <h3 class="font-caveat text-center text-5xl text-red-800 mb-4" x-text="$store.cart.currentFilling.type_name"></h3>
            <div class="flex gap-1 lg:gap-6">
              <div class="hidden lg:block">
                <p class="mb-3 p-1">Начинка</span></p>
                <p x-show="$store.cart.currentFilling.type_weight_quantity === 'weight'">Вага</p>
                <p x-show="$store.cart.currentFilling.type_weight_quantity != 'weight'">Кількість</p>
              </div>
              <div class="text-2xl">
                <template x-if="$store.cart.currentFilling.type_is_candybar == 0">
                  <p class="bg-red-100 p-1 rounded mb-3 w-full overflow-hidden whitespace-nowrap max-w-[250px]" x-text="$store.cart.currentFilling.title"></p>
                </template>
                <template x-if="$store.cart.currentFilling.type_is_candybar == 1">
                  <select :disabled="isCandybarSelectDisabled" x-model="candybarFillingId" class="bg-red-100 p-1 rounded mb-3 w-full overflow-hidden">
                    <template x-for="filling in $store.cart.currentFilling.fillings" :key="filling.id">
                      <option :value="filling.id" x-text="filling.title"></option>
                    </template>
                  </select>
                </template>
                <template x-if="$store.cart.currentFilling.type_weight_quantity === 'weight'">
                  <div class="flex mb-3">
                    <span class="block mr-3 lg:hidden">Вага</span>
                    <div class="px-3 bg-red-100 flex justify-center items-center gap-4 mr-4 rounded">
                      <p class="cursor-pointer" @click="plusItemWeight">+</p>
                      <p x-text="$store.cart.totalAmount" class="min-w-[40px] text-center"></p>
                      <p class="cursor-pointer" @click="minusItemWeight">-</p>
                    </div>
                    <p>кг.</p>
                  </div>
                </template>
                <template x-if="$store.cart.currentFilling.type_weight_quantity === 'quantity'">
                  <div class="flex mb-3">
                    <span class="block mr-3 lg:hidden">Кількість</span>
                    <div class="px-3 bg-red-100 flex justify-center items-center gap-4 mr-4 rounded">
                      <p class="cursor-pointer" @click="plusItemQuantity">+</p>
                      <p x-text="$store.cart.totalAmount" class="min-w-[20px] text-center"></p>
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
            <div class="flex flex-col  lg:flex-row pt-3 min-h-[92px] items-center">
              <template x-if="!isShownGoToCart">
                <button @click="addToCart" class="button px-6">Додати</button>
              </template>
              <template x-if="isShownGoToCart">
                <a href="{{ route('cart.index') }}" class="cursor-pointer py-4 block text-xl lg:text-lg px-6 text-gray-600 decoration-slate-500 underline">
                  До кошика
                </a>
              </template>
              <button @click="closeModal" class="text-xl lg:text-lg px-6 text-gray-600 decoration-slate-500 underline">
                Продовжити покупки
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>      
  </div>
</template>
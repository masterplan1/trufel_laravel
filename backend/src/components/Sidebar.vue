<template>
  <div class="bg-blue-700 overflow-hidden">
    <router-link :to="{name: 'app.dashboard'}" class="flex text-gray-100 items-center
      hover:bg-black/30 px-4 py-2 rounded transition-colors mb-2" active-class="bg-gray-100 text-gray-800">
      <span class="w-5 mr-2"><HomeIcon /></span>
      <span class="text-lg font-semibold">Головна</span>
    </router-link>
    <router-link :to="{name: 'app.gallary'}" class="flex text-gray-100 items-center
      hover:bg-black/30 px-4 py-2 rounded transition-colors mb-1" active-class="bg-gray-100 text-gray-800">
      <span class="w-5 mr-2"><PhotoIcon /></span>
      <span class="text-lg font-semibold">Галерея</span>
    </router-link>
    <router-link :to="{name: 'app.filling'}" class="flex text-gray-100 items-center
      hover:bg-black/30 px-4 py-2 rounded transition-colors mb-2" active-class="bg-gray-100 text-gray-800">
      <span class="w-5 mr-2"><CakeIcon /></span>
      <span class="text-lg font-semibold">Начинки</span>
    </router-link>
    <router-link :to="{name: 'app.order'}" class="flex text-gray-100 items-center
      hover:bg-black/30 px-4 py-2 rounded transition-colors mb-2" active-class="bg-gray-100 text-gray-800">
      <span class="w-5 mr-2"><ShoppingBagIcon /></span>
      <span class="text-lg font-semibold">Замовлення(2)</span>
    </router-link>
    <router-link :to="{name: 'app.statistic'}" class="flex text-gray-100 items-center
      hover:bg-black/30 px-4 py-2 rounded transition-colors mb-2" active-class="bg-gray-100 text-gray-800">
      <span class="w-5 mr-2"><ChartPieIcon /></span>
      <span class="text-lg font-semibold">Статистика</span>
    </router-link>
    <router-link :to="{name: 'app.comment'}" class="flex text-gray-100 items-center
      hover:bg-black/30 px-4 py-2 rounded transition-colors mb-2" active-class="bg-gray-100 text-gray-800">
      <span class="w-5 mr-2"><ChatBubbleBottomCenterIcon /></span>
      <span class="text-lg font-semibold">Коментарі</span>
    </router-link>
  </div>
</template>

<script setup>
import { CakeIcon, ChartPieIcon, ChatBubbleBottomCenterIcon, HomeIcon, PhotoIcon, ShoppingBagIcon } from '@heroicons/vue/20/solid';

</script>
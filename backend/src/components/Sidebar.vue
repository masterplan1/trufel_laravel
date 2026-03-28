<template>
  <div class="bg-brand-text py-4 overflow-hidden fixed sm:static h-full sm:h-auto z-50">
    <router-link :to="{name: 'app.dashboard'}" class="flex text-gray-200 items-center
      hover:bg-white/10 px-8 pb-2 py-2 transition-colors mb-2" active-class="bg-brand-rose text-white">
      <span class="w-5 mr-2"><HomeIcon /></span>
      <span class="text-lg font-semibold">Головна</span>
    </router-link>
    <router-link :to="{name: 'app.gallary'}" class="flex text-gray-200 items-center
      hover:bg-white/10 px-8 py-2 transition-colors mb-1" active-class="bg-brand-rose text-white">
      <span class="w-5 mr-2"><PhotoIcon /></span>
      <span class="text-lg font-semibold">Галерея</span>
    </router-link>
    <router-link :to="{name: 'app.filling'}" class="flex text-gray-200 items-center
      hover:bg-white/10 px-8 py-2 transition-colors mb-2" active-class="bg-brand-rose text-white">
      <span class="w-5 mr-2"><CakeIcon /></span>
      <span class="text-lg font-semibold">Начинки</span>
    </router-link>
    <router-link :to="{name: 'app.category'}" class="flex text-gray-200 items-center
      hover:bg-white/10 px-8 py-2 transition-colors mb-2" active-class="bg-brand-rose text-white">
      <span class="w-5 mr-2"><FolderIcon /></span>
      <span class="text-lg font-semibold">Категорії</span>
    </router-link>
    <router-link :to="{name: 'app.types'}" class="flex text-gray-200 items-center
      hover:bg-white/10 px-8 py-2 transition-colors mb-2" active-class="bg-brand-rose text-white">
      <span class="w-5 mr-2"><TagIcon /></span>
      <span class="text-lg font-semibold">Типи</span>
    </router-link>
    <router-link :to="{name: 'app.order'}" class="flex text-gray-200 items-center
      hover:bg-white/10 px-8 py-2 transition-colors mb-2" active-class="bg-brand-rose text-white">
      <span class="w-5 mr-2"><ShoppingBagIcon /></span>
      <span class="text-lg font-semibold">Замовлення</span>
    </router-link>
    <router-link :to="{name: 'app.statistic'}" class="flex text-gray-200 items-center
      hover:bg-white/10 px-8 py-2 transition-colors mb-2" active-class="bg-brand-rose text-white">
      <span class="w-5 mr-2"><ChartPieIcon /></span>
      <span class="text-lg font-semibold">Статистика</span>
    </router-link>
    <router-link :to="{name: 'app.comment'}" class="flex text-gray-200 items-center
      hover:bg-white/10 px-8 pt-2 py-2 transition-colors mb-2" active-class="bg-brand-rose text-white">
      <span class="w-5 mr-2"><ChatBubbleBottomCenterIcon /></span>
      <span class="text-lg font-semibold">Коментарі</span>
    </router-link>
  </div>
</template>

<script setup>
import { CakeIcon, ChartPieIcon, ChatBubbleBottomCenterIcon, HomeIcon, PhotoIcon, ShoppingBagIcon, FolderIcon, TagIcon } from '@heroicons/vue/20/solid';

</script>
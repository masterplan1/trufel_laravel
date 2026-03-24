<template>
  <div>
    <h1 class="text-3xl font-semibold mb-6">Статистика</h1>
    <div v-if="loading" class="flex justify-center p-10">
      <Spinner :width="8" :height="8"/>
    </div>
    <template v-else>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Orders by status -->
        <div class="bg-white rounded-xl shadow p-5">
          <h2 class="text-lg font-semibold mb-4">Замовлення по статусу</h2>
          <div class="space-y-3">
            <div class="flex items-center justify-between">
              <span class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-brand-blush border border-brand-rose inline-block"></span>
                Нові
              </span>
              <div class="flex items-center gap-3">
                <div class="w-40 bg-gray-100 rounded-full h-2">
                  <div class="bg-brand-rose h-2 rounded-full" :style="{width: barWidth(stats.orders_new, stats.orders_total)}"></div>
                </div>
                <span class="font-semibold w-8 text-right">{{ stats.orders_new }}</span>
              </div>
            </div>
            <div class="flex items-center justify-between">
              <span class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-yellow-100 border border-yellow-400 inline-block"></span>
                В роботі
              </span>
              <div class="flex items-center gap-3">
                <div class="w-40 bg-gray-100 rounded-full h-2">
                  <div class="bg-yellow-400 h-2 rounded-full" :style="{width: barWidth(stats.orders_active, stats.orders_total)}"></div>
                </div>
                <span class="font-semibold w-8 text-right">{{ stats.orders_active }}</span>
              </div>
            </div>
            <div class="flex items-center justify-between">
              <span class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-green-100 border border-green-400 inline-block"></span>
                Виконані
              </span>
              <div class="flex items-center gap-3">
                <div class="w-40 bg-gray-100 rounded-full h-2">
                  <div class="bg-green-500 h-2 rounded-full" :style="{width: barWidth(stats.orders_completed, stats.orders_total)}"></div>
                </div>
                <span class="font-semibold w-8 text-right">{{ stats.orders_completed }}</span>
              </div>
            </div>
            <div class="pt-3 border-t mt-3 flex justify-between font-semibold">
              <span>Всього замовлень</span>
              <span>{{ stats.orders_total }}</span>
            </div>
          </div>
        </div>

        <!-- Revenue -->
        <div class="bg-white rounded-xl shadow p-5">
          <h2 class="text-lg font-semibold mb-4">Фінанси</h2>
          <div class="space-y-4">
            <div class="flex justify-between items-center py-3 border-b">
              <span class="text-gray-600">Виручка (виконані)</span>
              <span class="text-2xl font-bold text-green-600">{{ stats.revenue_total }} грн</span>
            </div>
            <div class="flex justify-between items-center py-3 border-b">
              <span class="text-gray-600">Середній чек</span>
              <span class="text-xl font-semibold">
                {{ stats.orders_completed > 0 ? Math.round(stats.revenue_total / stats.orders_completed) : 0 }} грн
              </span>
            </div>
          </div>
        </div>

        <!-- Catalog -->
        <div class="bg-white rounded-xl shadow p-5">
          <h2 class="text-lg font-semibold mb-4">Каталог</h2>
          <div class="space-y-3">
            <div class="flex justify-between py-2 border-b">
              <span class="text-gray-600">Начинок</span>
              <span class="font-semibold">{{ stats.fillings_count }}</span>
            </div>
            <div class="flex justify-between py-2 border-b">
              <span class="text-gray-600">Фото в галереї</span>
              <span class="font-semibold">{{ stats.products_count }}</span>
            </div>
            <div class="flex justify-between py-2">
              <span class="text-gray-600">Відгуків</span>
              <span class="font-semibold">{{ stats.comments_count }}</span>
            </div>
          </div>
        </div>
      </div>
    </template>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useStore } from 'vuex'
import Spinner from '../components/Spinner.vue'

const store = useStore()
const loading = ref(true)
const stats = ref({
  orders_total: 0, orders_new: 0, orders_active: 0, orders_completed: 0,
  revenue_total: 0, fillings_count: 0, products_count: 0, comments_count: 0,
})

function barWidth(value, total) {
  if (!total) return '0%'
  return Math.round((value / total) * 100) + '%'
}

onMounted(() => {
  store.dispatch('getDashboard').then(({ data }) => {
    stats.value = data
    loading.value = false
  })
})
</script>

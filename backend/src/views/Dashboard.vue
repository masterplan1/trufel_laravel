<template>
  <div>
    <h1 class="text-3xl font-semibold mb-6">Головна</h1>
    <div v-if="loading" class="flex justify-center p-10">
      <Spinner :width="8" :height="8"/>
    </div>
    <template v-else>
      <!-- Stats cards -->
      <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl shadow p-5 flex flex-col gap-1">
          <span class="text-sm text-gray-500">Замовлень всього</span>
          <span class="text-3xl font-bold text-brand-text">{{ stats.orders_total }}</span>
        </div>
        <div class="bg-white rounded-xl shadow p-5 flex flex-col gap-1">
          <span class="text-sm text-gray-500">Нових</span>
          <span class="text-3xl font-bold text-brand-rose">{{ stats.orders_new }}</span>
        </div>
        <div class="bg-white rounded-xl shadow p-5 flex flex-col gap-1">
          <span class="text-sm text-gray-500">В роботі</span>
          <span class="text-3xl font-bold text-yellow-500">{{ stats.orders_active }}</span>
        </div>
        <div class="bg-white rounded-xl shadow p-5 flex flex-col gap-1">
          <span class="text-sm text-gray-500">Виконано</span>
          <span class="text-3xl font-bold text-green-600">{{ stats.orders_completed }}</span>
        </div>
        <div class="bg-white rounded-xl shadow p-5 flex flex-col gap-1">
          <span class="text-sm text-gray-500">Виручка (виконані)</span>
          <span class="text-3xl font-bold text-brand-text">{{ stats.revenue_total }} <span class="text-base font-normal">грн</span></span>
        </div>
        <div class="bg-white rounded-xl shadow p-5 flex flex-col gap-1">
          <span class="text-sm text-gray-500">Начинок</span>
          <span class="text-3xl font-bold text-brand-text">{{ stats.fillings_count }}</span>
        </div>
        <div class="bg-white rounded-xl shadow p-5 flex flex-col gap-1">
          <span class="text-sm text-gray-500">Фото</span>
          <span class="text-3xl font-bold text-brand-text">{{ stats.products_count }}</span>
        </div>
        <div class="bg-white rounded-xl shadow p-5 flex flex-col gap-1">
          <span class="text-sm text-gray-500">Відгуків</span>
          <span class="text-3xl font-bold text-brand-text">{{ stats.comments_count }}</span>
        </div>
      </div>

      <!-- Recent orders -->
      <div class="bg-white rounded-xl shadow p-5">
        <h2 class="text-xl font-semibold mb-4">Останні замовлення</h2>
        <table class="w-full text-sm">
          <thead>
            <tr class="border-b-2">
              <th class="p-2 text-left">ID</th>
              <th class="p-2 text-left">Клієнт</th>
              <th class="p-2 text-left">Дата виконання</th>
              <th class="p-2 text-left">Сума</th>
              <th class="p-2 text-left">Статус</th>
              <th class="p-2 text-left">Створено</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="order in stats.recent_orders" :key="order.id" class="border-b hover:bg-gray-50">
              <td class="p-2">{{ order.id }}</td>
              <td class="p-2">{{ order.customer_name }}</td>
              <td class="p-2">{{ order.order_date }}</td>
              <td class="p-2">{{ order.total_price }} грн</td>
              <td class="p-2">
                <StatusBadge :status="order.status"/>
              </td>
              <td class="p-2 text-gray-500">{{ order.created_at }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </template>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useStore } from 'vuex'
import Spinner from '../components/Spinner.vue'
import StatusBadge from '../components/StatusBadge.vue'

const store = useStore()
const loading = ref(true)
const stats = ref({
  orders_total: 0, orders_new: 0, orders_active: 0, orders_completed: 0,
  revenue_total: 0, fillings_count: 0, products_count: 0, comments_count: 0,
  recent_orders: []
})

onMounted(() => {
  store.dispatch('getDashboard').then(({ data }) => {
    stats.value = data
    loading.value = false
  })
})
</script>

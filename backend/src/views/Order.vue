<template>
  <div>
    <div class="flex items-center justify-between mb-3">
      <h1 class="text-3xl font-semibold">Замовлення</h1>
    </div>
    <div class="bg-white p-4 rounded-lg shadow animate-fade-in-down">
      <div class="flex justify-between border-b-2 pb-3 gap-4 flex-wrap">
        <div class="flex items-center">
          <span class="whitespace-nowrap">на сторінці</span>
          <select @change="getOrders(null)" v-model="perPage"
            class="appearance-none relative block w-20 px-3 py-2 border border-gray-300 text-gray-900 rounded-md ml-3 focus:ring-brand-rose focus:border-brand-rose sm:text-sm"
          >
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="50">50</option>
          </select>
        </div>
        <div class="flex items-center">
          <span class="whitespace-nowrap">статус</span>
          <select @change="getOrders(null)" v-model="statusFilter"
            class="appearance-none relative block w-32 px-3 py-2 border border-gray-300 text-gray-900 rounded-md ml-3 focus:ring-brand-rose focus:border-brand-rose sm:text-sm"
          >
            <option value="">Всі</option>
            <option value="new">Нові</option>
            <option value="active">В роботі</option>
            <option value="completed">Виконані</option>
          </select>
        </div>
      </div>

      <Spinner class="w-full flex items-center justify-center p-10" v-if="orders.loading"/>
      <template v-else>
        <table class="w-full text-sm">
          <thead>
            <tr>
              <th class="border-b-2 p-2 text-left">ID</th>
              <th class="border-b-2 p-2 text-left">Клієнт</th>
              <th class="border-b-2 p-2 text-left">Телефон</th>
              <th class="border-b-2 p-2 text-left">Дата вик.</th>
              <th class="border-b-2 p-2 text-left">Сума</th>
              <th class="border-b-2 p-2 text-left">Статус</th>
              <th class="border-b-2 p-2 text-left">Створено</th>
              <th class="border-b-2 p-2 text-left bg-gray-100">Дії</th>
            </tr>
          </thead>
          <tbody>
            <template v-for="(order, index) of orders.data" :key="order.id">
              <tr class="animate-fade-in-down hover:bg-gray-50 cursor-pointer"
                :style="{'animation-delay': `${index*0.04}s`}"
                @click="toggleExpand(order.id)"
              >
                <td class="border-b p-2">{{ order.id }}</td>
                <td class="border-b p-2">{{ order.customer_name }}</td>
                <td class="border-b p-2">{{ order.customer_phone }}</td>
                <td class="border-b p-2">{{ order.order_date }}</td>
                <td class="border-b p-2 whitespace-nowrap">{{ order.total_price }} грн</td>
                <td class="border-b p-2">
                  <StatusBadge :status="order.status"/>
                </td>
                <td class="border-b p-2 text-gray-500">{{ order.created_at }}</td>
                <td class="border-b p-2" @click.stop>
                  <select
                    v-model="order.status"
                    @change="changeStatus(order)"
                    class="text-xs border border-gray-200 rounded px-1 py-1 focus:ring-brand-rose focus:border-brand-rose"
                  >
                    <option value="new">Нове</option>
                    <option value="active">В роботі</option>
                    <option value="completed">Виконано</option>
                  </select>
                </td>
              </tr>
              <!-- Expanded items -->
              <tr v-if="expandedId === order.id">
                <td colspan="8" class="bg-brand-cream px-4 py-3 border-b">
                  <p v-if="order.comment" class="text-brand-muted text-xs mb-2">Коментар: {{ order.comment }}</p>
                  <table class="w-full text-xs">
                    <thead>
                      <tr class="text-gray-500">
                        <th class="text-left pb-1">Начинка</th>
                        <th class="text-left pb-1">Ціна</th>
                        <th class="text-left pb-1">Кількість</th>
                        <th class="text-left pb-1">Вага</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="item in order.items" :key="item.id">
                        <td class="py-0.5">{{ item.filling_title }}</td>
                        <td class="py-0.5">{{ item.unit_price }} грн</td>
                        <td class="py-0.5">{{ item.quantity }} шт</td>
                        <td class="py-0.5">{{ item.weight ? item.weight + ' кг' : '—' }}</td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
            </template>
          </tbody>
        </table>

        <div v-if="orders.links" class="mt-5 flex items-center justify-between">
          <span class="text-sm text-gray-500">Сторінки з {{ orders.links.from }} по {{ orders.links.to }} (всього {{ orders.links.total }})</span>
          <nav v-if="orders.links.total > orders.links.per_page"
            class="relative z-0 inline-flex justify-center rounded-md shadow-sm -space-x-px"
          >
            <a href="#"
              v-for="(link, i) of orders.links.links"
              :key="i"
              :disabled="!link.url"
              @click.prevent="getForPage($event, link)"
              class="relative inline-flex items-center px-4 py-2 border text-sm font-medium whitespace-nowrap"
              v-html="link.label"
              :class="[
                link.active ? 'z-10 bg-brand-blush border-brand-rose text-brand-rose-dark' : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                i === 0 ? 'rounded-l-md' : '',
                i === orders.links.links.length - 1 ? 'rounded-r-md' : '',
                !link.url ? 'bg-gray-100 text-gray-700 cursor-not-allowed' : ''
              ]"
            ></a>
          </nav>
        </div>
      </template>
    </div>
  </div>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue'
import { useStore } from 'vuex'
import Spinner from '../components/Spinner.vue'
import StatusBadge from '../components/StatusBadge.vue'

const store = useStore()
const perPage = ref(10)
const statusFilter = ref('')
const sortDirection = ref('desc')
const sortField = ref('created_at')
const expandedId = ref(null)

const orders = computed(() => store.state.orders)

function getOrders(payload) {
  store.dispatch('getOrders', {
    ...payload,
    perPage: perPage.value,
    status: statusFilter.value,
    sort_direction: sortDirection.value,
    sort_field: sortField.value,
  })
}

function getForPage($event, link) {
  if (!link.active && link.url) {
    const page = link.url.split('=')
    getOrders({ page: page[1] })
  }
}

function toggleExpand(id) {
  expandedId.value = expandedId.value === id ? null : id
}

function changeStatus(order) {
  store.dispatch('updateOrderStatus', { id: order.id, status: order.status })
}

onMounted(() => getOrders({}))
</script>

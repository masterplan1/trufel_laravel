<template>
  <div>
    <div class="flex items-center justify-between mb-3">
      <h1 class="text-3xl font-semibold">Начинки </h1>
      <button
        class="flex justify-center items-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-300"
      >Додати Начинку
      </button>
    </div>
    <div class="bg-white p-4 rounded-lg shadow">
      <div class="flex justify-between border-b-2 pb-3">
        <div class="flex items-center">
          <span class="whitespace-nowrap">на сторінці, шт</span>
          <select @change="getFillings(null)" v-model="perPage"
            class="appearance-none relative block w-24 px-3 py-2 border border-gray-300 placeholder:-gray-500 text-gray-900 rounded-md ml-3 focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
          >
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="50">50</option>
            <option value="100">100</option>
          </select>
        </div>
        <div class="flex items-center">
          <span class="whitespace-nowrap">тип</span>
          <select @change="getFillings(null)" v-model="type"
            class="appearance-none relative block w-24 px-3 py-2 border border-gray-300 placeholder:-gray-500 text-gray-900 rounded-md ml-3 focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
          >
            <option value="0">Всі</option>
            <option value="1">Торт</option>
            <option value="2">Капкейк</option>
            <option value="3">Кендібар</option>
            <option value="4">Бенто</option>
            <option value="5">Дієтичні десерти</option>
          </select>
        </div>
        <div>
          <input type="text" class="appearance-none relative block w-24 px-3 py-2 border border-gray-300 placeholder:-gray-500 text-gray-900 rounded-md ml-3 focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
            placeholder="Пошук"
            @change="getFillings(null)"
            v-model="search"
          >
        </div>
      </div>
      <Spinner class="w-full flex items-center justify-center p-10" v-if="fillings.loading"/>
      <template v-else>
        <table>
          <thead>
            <tr>
              <TableHeaderCell field="id" @click="handleSort" :sortDirection="sortDirection" :sortField="sortField" class="border-b-2 p-2 text-left">ID</TableHeaderCell>
              <TableHeaderCell field="" :sortDirection="sortDirection" :sortField="sortField" class="border-b-2 p-2 text-left">Фото</TableHeaderCell>
              <TableHeaderCell field="category" @click="handleSort" :sortDirection="sortDirection" :sortField="sortField" class="border-b-2 p-2 text-left">Категорія</TableHeaderCell>
              <TableHeaderCell field="title" @click="handleSort" :sortDirection="sortDirection" :sortField="sortField" class="border-b-2 p-2 text-left">Назва</TableHeaderCell>
              <TableHeaderCell field="unit_price" @click="handleSort" :sortDirection="sortDirection" :sortField="sortField" class="border-b-2 p-2 text-left">Ціна</TableHeaderCell>
              <TableHeaderCell field="updated_at" @click="handleSort" :sortDirection="sortDirection" :sortField="sortField" class="border-b-2 p-2 text-left">Оновлено</TableHeaderCell>
            </tr>
          </thead>
          <tbody>
            <tr v-for="filling of fillings.data" :key="filling.id">
              <td class="border-b p-2">{{ filling.id }}</td>
              <td class="border-b p-2">
                <img :src="filling.image" class="w-16" :alt="filling.title">
              </td>
              <td class="border-b p-2">{{ filling.category }}</td>
              <td class="border-b p-2 max-w-[200px] whitespace-nowrap overflow-hidden text-ellipsis">
                {{ filling.title }}
              </td>
              <td class="border-b p-2">{{ filling.unit_price }}</td>
              <td class="border-b p-2">{{ filling.updated_at }}</td>
            </tr>
          </tbody>
        </table>
        <div v-if="fillings.links" class="mt-5 flex items-center justify-between">
          <span>Сторінки з {{ fillings.links.from }} по {{ fillings.links.to }}</span>
          <nav
            v-if="fillings.links.total > fillings.links.per_page"
            class="relative z-0 inline-flex justify-center rounded-md shadow-sm -space-x-px"
            aria-label="Pagiation"
          >
            <a href="#"
              v-for="(link, i) of fillings.links.links"
              :key="i"
              :disabled="!link.url"
              @click.prevent="getForPage($event, link)"
              aria-current="page"
              class="relative inline-flex items-center px-4 py-2 border text-sm font-medium whitespace-nowrap"
              v-html="link.label"
              :class="[
                link.active
                  ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600'
                  : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                i === 0 ? 'rounded-l-md' : '',
                i === fillings.links.links.length - 1 ? 'rounded-r-md' : '',
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
import { computed, onMounted, ref } from 'vue';
import { useStore } from 'vuex';
import Spinner from '../components/Spinner.vue';
import TableHeaderCell from '../components/Core/Table/TableHeaderCell.vue';
import { FILLINGS_PER_PAGE } from '../constants';

const store = useStore()
const perPage = ref(FILLINGS_PER_PAGE)
const type = ref(0)
const search = ref('')
const fillings = computed(() => store.state.fillings)
const sortDirection = ref('desc')
const sortField = ref('updated_at')

function getFillings(payload){
  store.dispatch('getFillings', {
    ...payload , 
    perPage: perPage.value, 
    search: search.value, 
    type: type.value,
    sort_direction: sortDirection.value,
    sort_field: sortField.value,
  })
}
function getForPage($event, link){
  if(!link.active && link.url){
    const page = link.url.split("=")
    getFillings({page: page[1]})
  }
}
function handleSort(field){
  if(sortField.value === field){
    if(sortDirection.value === 'asc'){
      sortDirection.value = 'desc'
    } else {
      sortDirection.value = 'asc'
    }
  } else {
    sortField.value = field
    sortDirection.value = 'asc'
  }
  getFillings({})
}
onMounted(() => {
  getFillings({})
})
</script>
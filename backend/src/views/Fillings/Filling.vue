<template>
  <div>
    <div class="flex items-center justify-between mb-3">
      <h1 class="text-3xl font-semibold">Начинки</h1>
      <button
        @click="openModal"
        class="flex justify-center items-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-300"
      >Додати Начинку
      </button>
    </div>
    <div class="bg-white p-4 rounded-lg shadow animate-fade-in-down">
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
            <option :value="type.id" v-for="type of typesForSelect" :key="type.id">{{ type.name }}</option>
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
        <table class="w-full">
          <thead>
            <tr>
              <TableHeaderCell field="id" @click="handleSort" :sortDirection="sortDirection" :sortField="sortField" class="border-b-2 p-2 text-left">ID</TableHeaderCell>
              <TableHeaderCell field="" :sortDirection="sortDirection" :sortField="sortField" class="border-b-2 p-2 text-left">Фото</TableHeaderCell>
              <TableHeaderCell field="category_id" @click="handleSort" :sortDirection="sortDirection" :sortField="sortField" class="border-b-2 p-2 text-left">Категорія</TableHeaderCell>
              <TableHeaderCell field="title" @click="handleSort" :sortDirection="sortDirection" :sortField="sortField" class="border-b-2 p-2 text-left">Назва</TableHeaderCell>
              <TableHeaderCell field="unit_price" @click="handleSort" :sortDirection="sortDirection" :sortField="sortField" class="border-b-2 p-2 text-left">Ціна</TableHeaderCell>
              <TableHeaderCell field="updated_at" @click="handleSort" :sortDirection="sortDirection" :sortField="sortField" class="border-b-2 p-2 text-left">Оновлено</TableHeaderCell>
              <th class="border-b-2 p-2 text-left cursor-pointer bg-gray-100" >Дії</th>
            </tr>
        </thead>
          <tbody>
            <tr v-for="(filling, index) of fillings.data" :key="filling.id" class="animate-fade-in-down" 
              :style="{'animation-delay': `${index*0.05}s`}">
              <td class="border-b p-2">{{ filling.id }}</td>
              <td class="border-b p-2">
                <img :src="filling.image" class="w-16" :alt="filling.title">
              </td>
              <td class="border-b p-2">{{ filling.category_name }}</td>
              <td class="border-b p-2 max-w-[200px] whitespace-nowrap overflow-hidden text-ellipsis">
                {{ filling.title }}
              </td>
              <td class="border-b p-2">{{ filling.unit_price }}</td>
              <td class="border-b p-2">{{ filling.updated_at }}</td>
              <td class="border-b p-2">
                <div class="flex items-center justify-start">
                  <svg @click="editHandler(filling.id)" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-3 cursor-pointer">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                  </svg>
                  <svg @click="deleteHandler(filling.id)" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 cursor-pointer">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                  </svg>
                </div>
              </td>
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
      <FillingModal v-model="isModalOpen" :filling="fillingModal" @closeModal="closeModal" @get-fillings="getFillings({})"/>
    </div>
  </div>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import { useStore } from 'vuex';
import Spinner from '../../components/Spinner.vue';
import TableHeaderCell from '../../components/Core/Table/TableHeaderCell.vue';
import { FILLINGS_PER_PAGE } from '../../constants';
import FillingModal from './FillingModal.vue';

const store = useStore()
const perPage = ref(FILLINGS_PER_PAGE)
const type = ref(0)
const search = ref('')
const fillings = computed(() => store.state.fillings)
const sortDirection = ref('desc')
const sortField = ref('updated_at')
const EMPTY_FILLING_OBJECT = {
  title: '',
  image: '',
  description: '',
  unit_price: '',
  min_weight: '',
  min_quantity: '',
  category_id: '',}

const fillingModal = ref({
  ...EMPTY_FILLING_OBJECT
})
const isModalOpen = ref(false)
const typesForSelect = ref([])

function openModal(){
  isModalOpen.value = !isModalOpen.value
}
function editHandler(id){
  store.dispatch('getFilling', id)
    .then(res => {
      fillingModal.value = res.data
      openModal()
    })
}
function deleteHandler(id){
  if(confirm('Видалити начинку?')){
    store.dispatch('removeFilling', id)
    .then(() => {
      getFillings({})
    }).catch(({response}) => {
      // todo notification 
      getFillings({}) 
      console.log(response.data.message)
    })
  }
}
function getFillings(payload){
  console.log('get fillings')
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
  store.dispatch('getTypes').then(({data}) => {
    typesForSelect.value = data
  })
})
function closeModal(){
  fillingModal.value = {
    ...EMPTY_FILLING_OBJECT
  };
  // fillingModal.proxy?.$forceUpdate();
}
</script>
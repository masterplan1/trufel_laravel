<template>
  <div>
    <div class="flex items-center justify-between mb-3">
      <h1 class="text-3xl font-semibold">Коментарі</h1>
    </div>
    <div class="bg-white p-4 rounded-lg shadow animate-fade-in-down">
      <div class="flex items-center border-b-2 pb-3">
        <span class="whitespace-nowrap">на сторінці</span>
        <select @change="getComments(null)" v-model="perPage"
          class="appearance-none relative block w-20 px-3 py-2 border border-gray-300 text-gray-900 rounded-md ml-3 focus:ring-brand-rose focus:border-brand-rose sm:text-sm"
        >
          <option value="10">10</option>
          <option value="20">20</option>
          <option value="50">50</option>
        </select>
      </div>

      <Spinner class="w-full flex items-center justify-center p-10" v-if="comments.loading"/>
      <template v-else>
        <table class="w-full">
          <thead>
            <tr>
              <th class="border-b-2 p-2 text-left">ID</th>
              <th class="border-b-2 p-2 text-left">Автор</th>
              <th class="border-b-2 p-2 text-left">Оцінка</th>
              <th class="border-b-2 p-2 text-left">Відгук</th>
              <th class="border-b-2 p-2 text-left">Дата</th>
              <th class="border-b-2 p-2 text-left bg-gray-100">Дії</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(comment, index) of comments.data" :key="comment.id"
              class="animate-fade-in-down"
              :style="{'animation-delay': `${index*0.04}s`}"
            >
              <td class="border-b p-2">{{ comment.id }}</td>
              <td class="border-b p-2 font-medium">{{ comment.author_name }}</td>
              <td class="border-b p-2">
                <div class="flex gap-0.5">
                  <template v-for="i in 5" :key="i">
                    <svg xmlns="http://www.w3.org/2000/svg"
                      :fill="comment.estimation >= i ? 'currentColor' : 'none'"
                      viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                      class="w-4 h-4 text-brand-rose">
                      <path stroke-linecap="round" stroke-linejoin="round"
                        d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                    </svg>
                  </template>
                </div>
              </td>
              <td class="border-b p-2 max-w-xs text-sm text-gray-700">{{ comment.description }}</td>
              <td class="border-b p-2 text-gray-500 text-sm">{{ comment.created_at }}</td>
              <td class="border-b p-2">
                <svg @click="deleteHandler(comment.id)" xmlns="http://www.w3.org/2000/svg" fill="none"
                  viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                  class="w-5 h-5 cursor-pointer text-gray-500 hover:text-brand-rose transition-colors">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </svg>
              </td>
            </tr>
          </tbody>
        </table>

        <div v-if="comments.links" class="mt-5 flex items-center justify-between">
          <span class="text-sm text-gray-500">Всього: {{ comments.links.total }}</span>
          <nav v-if="comments.links.total > comments.links.per_page"
            class="relative z-0 inline-flex justify-center rounded-md shadow-sm -space-x-px"
          >
            <a href="#"
              v-for="(link, i) of comments.links.links"
              :key="i"
              :disabled="!link.url"
              @click.prevent="getForPage($event, link)"
              class="relative inline-flex items-center px-4 py-2 border text-sm font-medium whitespace-nowrap"
              v-html="link.label"
              :class="[
                link.active ? 'z-10 bg-brand-blush border-brand-rose text-brand-rose-dark' : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                i === 0 ? 'rounded-l-md' : '',
                i === comments.links.links.length - 1 ? 'rounded-r-md' : '',
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

const store = useStore()
const perPage = ref(10)
const comments = computed(() => store.state.comments)

function getComments(payload) {
  store.dispatch('getComments', {
    ...payload,
    perPage: perPage.value,
    sort_direction: 'desc',
  })
}

function getForPage($event, link) {
  if (!link.active && link.url) {
    const page = link.url.split('=')
    getComments({ page: page[1] })
  }
}

function deleteHandler(id) {
  if (confirm('Видалити коментар?')) {
    store.dispatch('removeComment', id).then(() => getComments({}))
  }
}

onMounted(() => getComments({}))
</script>

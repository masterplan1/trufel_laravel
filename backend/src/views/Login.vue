<template>
  <div class="flex min-h-full items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md space-y-8">
      <div>
        <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">Вхід</h2>
      </div>
      <form class="mt-8 space-y-6" method="POST" @submit.prevent="login">
        <div class="bg-red-300 px-4 py-2 rounded text-white flex justify-between items-center" v-if="errMsg">
          {{ errMsg }}
          <span @click="errMsg = ''" class="rounded-full bg-black/20 p-1 flex justify-center items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </span>
        </div>
        <!-- <input type="hidden" name="remember" value="true" /> -->
        <div class="-space-y-px rounded-md shadow-sm">
          <div>
            <label for="email-address" class="sr-only">Email address</label>
            <input id="email-address" name="email" type="email" v-model="user.email" autocomplete="email" required="" class="relative block w-full rounded-t-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:z-10 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Email address" />
          </div>
          <div>
            <label for="password" class="sr-only">Password</label>
            <input id="password" name="password" type="password" v-model="user.password" autocomplete="current-password" class="relative block w-full rounded-b-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:z-10 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Password" />
          </div>
        </div>
        <div class="flex items-center justify-between">
          <div class="flex items-center">
            <input id="remember" name="remember" type="checkbox" v-model="user.remember" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600" />
            <label for="remember" class="ml-2 block text-sm text-gray-900">Remember me</label>
          </div>
        </div>
        <div>
          <button type="submit" 
              class="group relative flex items-center w-full justify-center rounded-md bg-indigo-600 py-2 px-3 text-sm 
              font-semibold text-white hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 
              focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
              :class="{'bg-indigo-300': loading}"
              :disabled="loading"
              >
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
              <LockClosedIcon class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" aria-hidden="true" />
            </span>
            <Spinner :width="5" :height="5" v-if="loading"/>
            <span v-else>Увійти</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { LockClosedIcon } from '@heroicons/vue/20/solid'
import { ref } from 'vue';
import { useStore } from 'vuex';
import { useRouter } from 'vue-router';
import Spinner from '../components/Spinner.vue';

const loading = ref(false)
const errMsg = ref('')
const store = useStore()
const router = useRouter()
const user = {
  email: '',
  password: '',
  remember: false
}

function login(){
  loading.value = true
  store.dispatch('login', user)
    .then(res => {
      loading.value = false
      router.push({name: 'app.dashboard'})
    })
    .catch(({response}) => {
      loading.value = false
      errMsg.value = response.data.message
    })
}
</script>
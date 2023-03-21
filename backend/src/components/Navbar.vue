<template>
  <header class="h-16 shadow bg-white flex items-center sm:justify-between px-4 justify-end
    ">
    <button @click="toggleMenu" class="cursor-pointer mx-6">
      <Bars3Icon class="w-6"/>
    </button>
    <button class="flex items-center" @click="logout">
      <span class="font-semibold" v-if="user">{{ user }},&nbsp;</span>
      <span class="font-semibold">вийти</span>
      <ArrowRightOnRectangleIcon  class="w-6 ml-1"/>
    </button>
  </header>
</template>

<script setup>
import { ArrowRightCircleIcon, ArrowRightOnRectangleIcon, Bars3Icon } from "@heroicons/vue/20/solid";
import { useStore } from "vuex";
import { useRouter } from "vue-router";
import { computed } from "vue";

const store = useStore()
const router = useRouter()
const user = computed(() => store.state.user.data.name)
const emits = defineEmits([
  'toggle-menu'
])
function toggleMenu(){
  emits('toggle-menu')
}

function logout(){
  store.dispatch('logout')
    .then(() => {
      router.push({name: 'login'})
    })
}
</script>
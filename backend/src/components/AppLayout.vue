<template>
  <div v-if="user.id" class="min-h-full flex">
    <Sidebar  class="transition-all " :class="sidebarVissible ? 'w-[230px] p-4' : 'w-0'"/>
    <div class="flex-1">
      <Navbar @toggle-menu="toggleSidebar"/>
      <main class="p-6">
        <div class="p-4 rounded bg-white">
          <router-view></router-view>
        </div>
      </main>
    </div>
  </div>
  <div v-else class="flex w-full h-full items-center justify-center">
    <Spinner :height="8" :width="8"/>
  </div>
</template>

<script setup>
import Spinner from './Spinner.vue';
import { ref, onMounted, onUnmounted, computed } from 'vue';
import { useStore } from 'vuex';
import Navbar from './Navbar.vue';
import Sidebar from './Sidebar.vue';

const store = useStore()
const user = computed(() => store.state.user.data)
const sidebarVissible = ref(true)
function toggleSidebar(){
  sidebarVissible.value = !sidebarVissible.value
}
const checkWindowWidth = () => sidebarVissible.value = window.outerWidth > 768
onMounted(() => {
  store.dispatch('getUser')
  checkWindowWidth()
  window.addEventListener('resize', checkWindowWidth)
})

onUnmounted(() => {
  window.removeEventListener('resize', checkWindowWidth)
})
</script>
<template>
  <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium" :class="classes[status]">
    {{ labels[status] }}
  </span>
</template>

<script setup>
defineProps({ status: String })

const labels = { new: 'Нове', active: 'В роботі', completed: 'Виконано' }
const classes = {
  new: 'bg-brand-blush text-brand-rose-dark',
  active: 'bg-yellow-100 text-yellow-800',
  completed: 'bg-green-100 text-green-700',
}
</script>

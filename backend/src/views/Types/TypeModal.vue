<template>
  <div>
    <TransitionRoot appear :show="show" as="template">
      <Dialog as="div" @close="closeModal" class="relative z-10">
        <TransitionChild
          as="template"
          enter="duration-300 ease-out"
          enter-from="opacity-0"
          enter-to="opacity-100"
          leave="duration-200 ease-in"
          leave-from="opacity-100"
          leave-to="opacity-0"
        >
          <div class="fixed inset-0 bg-black bg-opacity-25" />
        </TransitionChild>

        <div class="fixed inset-0 overflow-y-auto">
          <div class="flex min-h-full items-center justify-center p-4 text-center">
            <TransitionChild
              as="template"
              enter="duration-300 ease-out"
              enter-from="opacity-0 scale-95"
              enter-to="opacity-100 scale-100"
              leave="duration-200 ease-in"
              leave-from="opacity-100 scale-100"
              leave-to="opacity-0 scale-95"
            >
              <DialogPanel
                class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all"
              >
                <Spinner v-if="loading" class="flex justify-center p-10" />
                <template v-else>
                  <header class="px-3 py-4 flex items-center justify-between">
                    <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900">
                      {{ typeData.id ? `Редагувати тип: ${props.type.name}` : 'Додати тип' }}
                    </DialogTitle>
                    <button
                      @click="closeModal"
                      class="w-8 h-8 flex items-center justify-center rounded-full transition-colors cursor-pointer hover:bg-[rgba(0,0,0,0.2)]"
                    >
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                      </svg>
                    </button>
                  </header>
                  <form @submit.prevent="onSubmit">
                    <div class="p-4 bg-white space-y-4">
                      <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Назва</label>
                        <input
                          type="text"
                          v-model="typeData.name"
                          class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-brand-rose focus:border-brand-rose sm:text-sm"
                          placeholder="Назва типу"
                        />
                        <span v-if="errMsg['name']" class="text-red-400 text-sm">{{ errMsg['name'] }}</span>
                      </div>
                      <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Розмірність</label>
                        <select
                          v-model="typeData.weight_quantity"
                          class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-brand-rose focus:border-brand-rose sm:text-sm"
                        >
                          <option value="weight">Кілограми (кг)</option>
                          <option value="quantity">Штуки (шт)</option>
                        </select>
                        <span v-if="errMsg['weight_quantity']" class="text-red-400 text-sm">{{ errMsg['weight_quantity'] }}</span>
                      </div>
                      <div class="flex items-center gap-3">
                        <input
                          type="checkbox"
                          id="is_candybar"
                          v-model="typeData.is_candybar"
                          class="h-4 w-4 text-brand-rose border-gray-300 rounded"
                        />
                        <label for="is_candybar" class="text-sm font-medium text-gray-700">
                          Кендібар (капкейки, кейпопси, кейкстугоу тощо)
                        </label>
                      </div>
                    </div>
                    <footer class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse">
                      <button
                        type="submit"
                        class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-brand-rose hover:bg-brand-rose-dark"
                      >
                        <span v-if="typeData.id">Зберегти</span>
                        <span v-else>Створити</span>
                      </button>
                      <button
                        type="button"
                        @click="closeModal"
                        class="mr-3 mt-2 w-full inline-flex justify-center rounded-md border border-gray-300 px-4 shadow-sm py-2 bg-white sm:w-auto sm:mt-0"
                      >
                        Закрити
                      </button>
                    </footer>
                  </form>
                </template>
              </DialogPanel>
            </TransitionChild>
          </div>
        </div>
      </Dialog>
    </TransitionRoot>
  </div>
</template>

<script setup>
import Spinner from '../../components/Spinner.vue'
import { useStore } from 'vuex';
import { ref, computed, onUpdated } from "vue";
import { TransitionRoot, TransitionChild, Dialog, DialogPanel, DialogTitle } from "@headlessui/vue";

const store = useStore()
const props = defineProps({
  modelValue: Boolean,
  type: Object,
})

const errMsg = ref({})
const loading = ref(false)
const emit = defineEmits(['update:modelValue', 'closeModal', 'get-types'])
const typeData = ref({ ...props.type })

const show = computed({
  get() { return props.modelValue },
  set(val) { emit('update:modelValue', val) }
})

function closeModal() {
  show.value = false
  emit('closeModal')
  errMsg.value = {}
  loading.value = false
}

function onSubmit() {
  loading.value = true
  if (typeData.value.id) {
    store.dispatch('updateType', { ...typeData.value })
      .then((res) => {
        loading.value = false
        if (res.status === 200) {
          emit('get-types')
          closeModal()
        }
      })
      .catch(({ response }) => {
        loading.value = false
        prepareErrorMsg(response)
      })
  } else {
    store.dispatch('createType', typeData.value)
      .then((res) => {
        loading.value = false
        if (res.status === 201) {
          emit('get-types')
          closeModal()
        }
      })
      .catch(({ response }) => {
        loading.value = false
        prepareErrorMsg(response)
      })
  }
}

function prepareErrorMsg(response) {
  errMsg.value = {}
  for (var err in response.data.errors) {
    errMsg.value[err] = response.data.errors[err][0]
  }
}

onUpdated(() => {
  typeData.value = { ...props.type }
})
</script>

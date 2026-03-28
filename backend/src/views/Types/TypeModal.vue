<template>
  <div>
    <TransitionRoot appear :show="show" as="template">
      <Dialog as="div" @close="closeModal" class="relative z-10">
        <TransitionChild
          as="template"
          enter="duration-300 ease-out" enter-from="opacity-0" enter-to="opacity-100"
          leave="duration-200 ease-in" leave-from="opacity-100" leave-to="opacity-0"
        >
          <div class="fixed inset-0 bg-black bg-opacity-25" />
        </TransitionChild>

        <div class="fixed inset-0 overflow-y-auto">
          <div class="flex min-h-full items-center justify-center p-4 text-center">
            <TransitionChild
              as="template"
              enter="duration-300 ease-out" enter-from="opacity-0 scale-95" enter-to="opacity-100 scale-100"
              leave="duration-200 ease-in" leave-from="opacity-100 scale-100" leave-to="opacity-0 scale-95"
            >
              <DialogPanel
                class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all"
              >
                <Spinner v-if="loading" class="flex justify-center p-10" />
                <template v-else>
                  <header class="px-3 py-4 flex items-center justify-between">
                    <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900">
                      {{ typeData.id ? `Редагувати: ${props.type.name}` : 'Додати тип' }}
                    </DialogTitle>
                    <button @click="closeModal"
                      class="w-8 h-8 flex items-center justify-center rounded-full transition-colors cursor-pointer hover:bg-[rgba(0,0,0,0.2)]"
                    >
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                      </svg>
                    </button>
                  </header>

                  <form @submit.prevent="onSubmit">
                    <div class="p-4 bg-white space-y-4">

                      <!-- Назва -->
                      <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Назва</label>
                        <input type="text" v-model="typeData.name"
                          class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-brand-rose focus:border-brand-rose sm:text-sm"
                          placeholder="Назва типу" />
                        <span v-if="errMsg['name']" class="text-red-400 text-sm">{{ errMsg['name'] }}</span>
                      </div>

                      <!-- Розмірність -->
                      <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Розмірність</label>
                        <select v-model="typeData.weight_quantity"
                          class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-brand-rose focus:border-brand-rose sm:text-sm"
                        >
                          <option value="weight">Кілограми (кг)</option>
                          <option value="quantity">Штуки (шт)</option>
                        </select>
                        <span v-if="errMsg['weight_quantity']" class="text-red-400 text-sm">{{ errMsg['weight_quantity'] }}</span>
                      </div>

                      <!-- Зображення -->
                      <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                          Зображення <span class="text-gray-400 font-normal">(необов'язково)</span>
                        </label>
                        <div class="flex items-center gap-3">
                          <img v-if="previewImage || typeData.image"
                            :src="previewImage || typeData.image"
                            class="w-16 h-16 object-cover rounded-lg border border-gray-200"
                            alt="">
                          <label class="cursor-pointer flex items-center gap-2 px-3 py-2 border border-gray-300 rounded-md text-sm text-gray-600 hover:bg-gray-50 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                            </svg>
                            Вибрати фото
                            <input type="file" accept="image/*" class="hidden" @change="changeImage" />
                          </label>
                          <button v-if="previewImage || typeData.image" type="button"
                            @click="clearImage"
                            class="text-gray-400 hover:text-red-400 transition-colors text-xs">
                            видалити
                          </button>
                        </div>
                        <span v-if="errMsg['image']" class="text-red-400 text-sm">{{ errMsg['image'] }}</span>
                      </div>

                      <!-- Чекбокси -->
                      <div class="space-y-3 pt-1">
                        <label class="flex items-center gap-3 cursor-pointer">
                          <input type="checkbox" id="is_candybar" v-model="typeData.is_candybar"
                            :disabled="typeData.is_candybar_group"
                            class="h-4 w-4 text-brand-rose border-gray-300 rounded" />
                          <span class="text-sm font-medium text-gray-700">
                            Підтип кендібару
                            <span class="text-gray-400 font-normal">(кейпопси, льодяники тощо)</span>
                          </span>
                        </label>

                        <label v-if="!candybarGroupExists || typeData.is_candybar_group"
                          class="flex items-center gap-3 cursor-pointer">
                          <input type="checkbox" id="is_candybar_group" v-model="typeData.is_candybar_group"
                            :disabled="typeData.is_candybar"
                            class="h-4 w-4 text-brand-rose border-gray-300 rounded" />
                          <span class="text-sm font-medium text-gray-700">
                            Агрегатор кендібару
                            <span class="text-gray-400 font-normal">(пункт меню "Кендібар")</span>
                          </span>
                        </label>
                      </div>

                      <!-- Підказка -->
                      <p v-if="typeData.is_candybar_group" class="text-xs text-amber-600 bg-amber-50 rounded-lg p-3">
                        Цей тип буде відображатись в меню як "Кендібар" і вести на сторінку з усіма підтипами. Таких записів має бути лише один.
                      </p>
                      <p v-if="typeData.is_candybar" class="text-xs text-brand-muted bg-brand-cream rounded-lg p-3">
                        Цей тип є підтипом кендібару. Він не буде показуватись в головному меню, лише на сторінці кендібару.
                      </p>

                    </div>

                    <footer class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse">
                      <button type="submit"
                        class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-brand-rose hover:bg-brand-rose-dark">
                        <span v-if="typeData.id">Зберегти</span>
                        <span v-else>Створити</span>
                      </button>
                      <button type="button" @click="closeModal"
                        class="mr-3 mt-2 w-full inline-flex justify-center rounded-md border border-gray-300 px-4 shadow-sm py-2 bg-white sm:w-auto sm:mt-0">
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
import { useStore } from 'vuex'
import { ref, computed, onUpdated } from 'vue'
import { TransitionRoot, TransitionChild, Dialog, DialogPanel, DialogTitle } from '@headlessui/vue'

const store = useStore()
const props = defineProps({ modelValue: Boolean, type: Object, candybarGroupExists: Boolean })

const errMsg = ref({})
const loading = ref(false)
const previewImage = ref(null)
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
  previewImage.value = null
}

function changeImage(e) {
  const file = e.target.files[0]
  if (!file) return
  typeData.value.image = file
  const reader = new FileReader()
  reader.onload = (ev) => { previewImage.value = ev.target.result }
  reader.readAsDataURL(file)
}

function clearImage() {
  typeData.value.image = null
  previewImage.value = null
}

function onSubmit() {
  loading.value = true
  const action = typeData.value.id ? 'updateType' : 'createType'
  const expectedStatus = typeData.value.id ? 200 : 201

  store.dispatch(action, { ...typeData.value })
    .then((res) => {
      loading.value = false
      if (res.status === expectedStatus) {
        emit('get-types')
        closeModal()
      }
    })
    .catch(({ response }) => {
      loading.value = false
      errMsg.value = {}
      for (const err in response.data.errors) {
        errMsg.value[err] = response.data.errors[err][0]
      }
    })
}

onUpdated(() => {
  typeData.value = { ...props.type }
  previewImage.value = null
})
</script>

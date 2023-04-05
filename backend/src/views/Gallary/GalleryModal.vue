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
          <div
            class="flex min-h-full items-center justify-center p-4 text-center"
          >
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
                class="w-full max-w-md transform overflow-hidden  min-h-[601px] rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all"
              >
                <Spinner v-if="loading" class="flex justify-center"/>
                <template v-else>
                    <header  class="px-3 py-4 flex items-center justify-between">
                      <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900">
                        Додати фото
                          <div class="mt-1" v-if="product.image && product.id">
                          {{ product.image }}
                        </div>
                      </DialogTitle>
                      <button @click="closeModal"
                        class="w-8 h-8 flex items-center justify-center rounded-full 
                          transition-colors cursor-pointer hover:bg-[rgba(0,0,0,0.2)]"
                      >
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                      </svg>
                      </button>
                  </header>
                  <div class="mb-2">
                    <select @change="chooseType" v-model="typeSelected.id"
                      class="rounded cursor-pointer hover:bg-gray-100"
                    >
                      <option value="null" disabled>Оберіть тип</option>
                      <option v-for="item of typeSelectOptions" :key="item.id" :value="item.id">{{ item.name }}</option>
                    </select>
                  </div>
                  <form @submit.prevent="onSubmit" v-if="typeSelected.id || product.id">
                    <div class="p-4 bg-white">
                      <div class="mb-2">
                        <CustomInput v-if="categorySelectOptions.length > 0" select-title="Оберіть категорію" type="select" 
                          v-model="product.category_id" :select-prop="categorySelectOptions" label="Категорія"/>
                        <span v-if="errMsg['category_id']" class="text-red-400">{{ errMsg['category_id'] }}</span> 
                      </div>
                    
                      
                      <div class="mb-2 flex justify-between items-center gap-4">
                        <div class="mt-1" v-if="product.image || preView">
                          <img :src="preView || product.image" class="w-16 rounded" alt="img">
                        </div>
                        <!-- <CustomInput type="file" label="Product Image" @change="file => product.image = file" class="border-none" /> -->
                        <CustomInput type="file" label="Product Image" @change="changeImage($event)" class="border-none" />
                        <span v-if="errMsg['image']" class="text-red-400">{{ errMsg['image'] }}</span>  
                      </div>
                    </div>
                    <footer class="bg-gray-50 px-4 py-3 xm:px-6 sm:flex sm:flex-row-reverse">
                      <button type="submit"
                        class="py-2 px-4 border border-transparent text-sm font-medium rounded-md 
                        text-white bg-indigo-600 hover:bg-indigo-500"
                      >
                        Створити
                      </button>
                      <button type="button" @click="closeModal" ref="cancelButtonRef"
                        class="mr-3 mt-2 w-full inline-flex justify-center rounded-md border border-gray-300 px-4
                        shadow-sm py-2 bg-white sm:w-auto sm:mt-0"
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
import CustomInput from '../../components/Core/Table/CustomInput.vue';
import { useStore } from 'vuex';
import { ref, computed, onUpdated, onMounted } from "vue";
import { TransitionRoot, TransitionChild, Dialog, DialogPanel, DialogTitle,} from "@headlessui/vue";
import axiosClient from '../../axios';

const store = useStore()
const props = defineProps({
  modelValue: Boolean,
  product: Object,
})
const preView = ref(null)
const errMsg = ref({})
const typeSelected = ref({id: null})
const typeSelectOptions = ref([])
const categorySelectOptions = ref([])
const loading = ref(false)
const emit = defineEmits(['update:modelValue', 'closeModal', 'get-products'])
const product = ref({...props.product})
const show = computed({
  get() {return props.modelValue},
  set(show) {emit('update:modelValue', show)}
})

function closeModal() {
  show.value = false
  emit('closeModal')
  errMsg.value = {}
  typeSelected.value = {id: null}
  loading.value = false
  preView.value = null
}
function onSubmit(){
  loading.value = true
  if(validationCheck()){
    store.dispatch('createProduct', product.value)
      .then((res) => {
        loading.value = false
        if(res.status === 201){
          // todo show notification
          emit('get-products')
          closeModal()
        }
      })
      .catch(({response}) => {
        loading.value = false
        prepareErrorMsg(response)
        console.log(errMsg.value)
      })
  } else {
    loading.value = false
  }
}


function prepareErrorMsg(response){
  for(var err in response.data.errors){
    errMsg.value[err] = response.data.errors[err][0]
  }
}

// Validation start

function validationCheck(){
  for (let key in product.value){
    if(!product.value[key]){
      errMsg.value[key] = `${key} is required`
    } else {
      delete errMsg.value[key]
    }
  }
  return isEmptyObject(errMsg.value)
}

function isEmptyObject(obj){
  return Object.keys(obj).length === 0;
}

// Validation end


// onUpdated(() => {
//   product.value = props.product
// })

onMounted(() => {
  axiosClient.get('/type')
    .then((res) => {
      typeSelectOptions.value = res.data
    })
    
})

function chooseType(){
  console.log('chooseType')
  axiosClient.get('/get-categories/'+typeSelected.value.id)
    .then(({data}) => {
      categorySelectOptions.value = data.map((item) => ({key: item.id, val: item.name}))
    })

    for (let item in product.value){
      product.value[item] = ''
    }
}

function changeImage($event){
  product.value.image = $event
  // preview image
  let fileReader = new FileReader()
  fileReader.onload = (e) => {
    preView.value = e.target.result
  }
  fileReader.readAsDataURL($event)
}
</script>

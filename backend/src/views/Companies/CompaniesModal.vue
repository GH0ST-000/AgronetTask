<template>

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
        <div class="fixed inset-0 bg-black bg-opacity-70" />
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
              class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white  text-left align-middle shadow-xl transition-all"
            >
              <Spinner v-if="loading" class="absolute left-0 top-0 bg-white right-0 bg-white bottom-0 flex items-center justify-center" />
              <header class="py-3 px-4 flex justify-between items-center">

                <DialogTitle as="h3" class="text-lg leading-6 font-medium bg-green-200 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md">
                  {{companies.id ? `Update Companies:"${props.companies.name}"` : 'Create New Companies'}}
                </DialogTitle>
                <button
                  @click="closeModal()"
                  class="w-8 h-8 flex items-center justify-center rounded-full transition-colors cursor-pointer hover:bg-[rgba(0,0,0,0.2)]"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M6 18L18 6M6 6l12 12"
                    />
                  </svg>
                </button>
              </header>
              <div v-if="errorMsg" class="flex w-full items-center justify-between py-2 px-5 bg-red-500 text-white rounded">
                {{ errorMsg }}
                <span
                  @click="errorMsg = ''"
                  class="w-8 h-8 flex items-center justify-center rounded-full transition-colors cursor-pointer hover:bg-[rgba(0,0,0,0.2)]"
                >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-6 w-6"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M6 18L18 6M6 6l12 12"
          />
        </svg>
      </span>
              </div>
              <form @submit.prevent="onSubmit">
                <div class="bg-white px-4 pt-5 pb-4">

                  <CustomInput class="mb-2" v-model="companies.name" label="Company Name"/>
                  <CustomInput type="text" class="mb-2" v-model="companies.email" label="Email"/>
                  <CustomInput type="file" class="mb-2" label="Company Image" @change="file => companies.image = file"/>
                  <CustomInput type="text" class="mb-2" v-model="companies.website" label="Website"/>

                </div>
                <footer class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                  <button type="submit"
                          class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm
                          text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500">
                    Submit
                  </button>
                  <button type="button"
                          class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                          @click="closeModal" ref="cancelButtonRef">
                    Cancel
                  </button>
                </footer>
              </form>

            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script setup>
import {computed, onUpdated, ref} from 'vue'
import {
  TransitionRoot,
  TransitionChild,
  Dialog,
  DialogPanel,
  DialogTitle,
} from '@headlessui/vue'
import Spinner from "../../components/core/Spinner.vue";
import CustomInput from "../../components/core/CustomInput.vue";
import store from "../../store";
const  loading = ref(false);
let errorMsg = ref("");
const companies = ref({

  id:props.companies.id,
  name:props.companies.name,
  email:props.companies.email,
  image:props.companies.image,
  website:props.companies.website,

})
const emit = defineEmits(['update:modelValue','close'])
const props = defineProps({
  modelValue:Boolean,
  companies:{
    required:true,
    type:Object
  }
})

const show = computed({
  get: () => props.modelValue,
  set: (value) =>emit("update:modelValue",value)
})

onUpdated(()=>{
  companies.value = {
    id:props.companies.id,
    name:props.companies.name,
    email:props.companies.email,
    image:props.companies.image,
    website:props.companies.website,
  }
})

function closeModal() {
  show.value = false;
  emit('close')
}

function onSubmit() {
  loading.value = true
  if (companies.value.id) {
    store.dispatch('updateCompanies', companies.value)
      .then(response => {
        loading.value = false;
        if (response.status === 200) {
          store.dispatch('getCompanies')
          closeModal()
        }
      })
      .catch(({response}) => {
        loading.value = false;
        errorMsg.value = response.data.message;
      })
  } else {
    store.dispatch('createCompanies', companies.value)
      .then(response => {
        loading.value = false;
        if (response.status === 201) {
          store.dispatch('getCompanies')
          closeModal()
        }
      })
      .catch(({response}) => {
        loading.value = false;
        errorMsg.value = response.data.message;
      })
  }
}

</script>

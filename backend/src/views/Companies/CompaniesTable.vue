<template>
  <div class="bg-white p-4 rounded-lg shadow">
    <div class="flex justify-between border-b-2 pb-3">
      <div class="flex items-center">
        <span class="whitespace-nowrap mr-3">Per Page</span>
        <select @change="getCompanies(null)" v-model="perPage" class="appearance-none relative block w-24 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
          <option value="5">5</option>
          <option value="10">10</option>
          <option value="20">20</option>
        </select>
      </div>
      <div class="flex items-center">
        <input v-model="search" @change="getCompanies(null)" class="appearance-none relative block w-48 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
               placeholder="type to search companies">
      </div>
    </div>
    <Spinner v-if="companies.loading" />
    <template v-else>
      <table class="table-auto w-full">
        <thead>
        <tr>
          <th class="border-b-2 p-2 text-left">ID</th>
          <th class="border-b-2 p-2 text-left">NAME</th>
          <th class="border-b-2 p-2 text-left">EMAIL</th>
          <th class="border-b-2 p-2 text-left">LOGO</th>
          <th class="border-b-2 p-2 text-left">WEBSITE</th>
          <th class="border-b-2 p-2 text-left">Actions</th>
        </tr>
        </thead>
        <tbody v-for="company in companies.data">
        <td class="border-b p-2">{{company.id}}</td>
        <td class="border-b p-2">{{company.name}}</td>
        <td class="border-b p-2">{{company.email}}</td>
        <td class="border-b p-2">
          <img class="w-16 rounded-md" :src="company.image" :alt="company.name">
        </td>
        <td class="border-b p-2">{{company.website}}</td>
        <td class="border-b p-2">
          <Menu as="div" class="relative inline-block text-left">
            <div>
              <MenuButton
                class="inline-flex items-center justify-center w-full justify-center rounded-full w-10 h-10 bg-black bg-opacity-0 text-sm font-medium text-white hover:bg-opacity-5 focus:bg-opacity-5 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75"
              >
                <DotsVerticalIcon
                  class="h-5 w-5 text-indigo-500"
                  aria-hidden="true"/>
              </MenuButton>
            </div>

            <transition
              enter-active-class="transition duration-100 ease-out"
              enter-from-class="transform scale-95 opacity-0"
              enter-to-class="transform scale-100 opacity-100"
              leave-active-class="transition duration-75 ease-in"
              leave-from-class="transform scale-100 opacity-100"
              leave-to-class="transform scale-95 opacity-0"
            >
              <MenuItems
                class="absolute z-10 right-0 mt-2 w-32 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
              >
                <div class="px-1 py-1">
                  <MenuItem v-slot="{ active }">
                    <button
                      :class="[
                        active ? 'bg-indigo-600 text-white' : 'text-gray-900',
                        'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                      ]"
                      @click="editCompanies(company)"
                    >
                      <PencilIcon
                        :active="active"
                        class="mr-2 h-5 w-5 text-indigo-400"
                        aria-hidden="true"
                      />
                      Edit
                    </button>
                  </MenuItem>
                  <MenuItem v-slot="{ active }">
                    <button
                      :class="[
                        active ? 'bg-indigo-600 text-white' : 'text-gray-900',
                        'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                      ]"
                      @click="deleteCompanies(company)"
                    >
                      <TrashIcon
                        :active="active"
                        class="mr-2 h-5 w-5 text-indigo-400"
                        aria-hidden="true"
                      />
                      Delete
                    </button>
                  </MenuItem>
                </div>
              </MenuItems>
            </transition>
          </Menu>
        </td>
        </tbody>
      </table>
      <div class="flex justify-between items-center mt-5">
        <span>
          Showing from {{companies.from}} to {{companies.to}}
        </span>
        <nav v-if="companies.total > companies.limit" class="relative z-0 inline-flex justify-center rounded-md  shadow-sm -space-x-px" aria-label="Pagination">
          <a v-for="(link,i) of companies.links" :key="i" :disabled="!link.url" href="#" @click.prevent="getForPage($event,link)" aria-current="page"
             class="relative inline-flex items-center px-4 py-2 border text-sm font-medium whitespace-nowrap" v-html="link.label"
             :class="[link.active ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600'
                  :'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                  i===0 ? 'rounded-l-md':'',
                  i === companies.links.length-1 ? 'rounded-r-md' : '',
                  !link.url ? 'bg-gray-100 text-gray-700' : '', ]">
          </a>
        </nav>
      </div>
    </template>
  </div>
</template>

<script setup>

import Spinner from "../../components/core/Spinner.vue";
import {computed, onMounted, ref} from "vue";
import store from "../../store";
import {COMPANIES_PER_PAGE} from "../../constants";
import {Menu, MenuButton, MenuItem, MenuItems} from "@headlessui/vue";
import {DotsVerticalIcon, PencilIcon, TrashIcon} from '@heroicons/vue/outline'

const emit = defineEmits(['clickEdit'])

const perPage = ref(COMPANIES_PER_PAGE);
const search = ref('');
const companies = computed(() => store.state.companies)

onMounted(()=>{
  getCompanies();
})

function getCompanies(url = null){
  store.dispatch('getCompanies',{
    url,
    search:search.value,
    perPage:perPage.value
  })
}
function getForPage(ev,link){
  if (!link.url || link.active){
    return;
  }else {
    getCompanies(link.url);
  }

}
function deleteCompanies(companies){
  if (!confirm(`Are you sure you want to delete the companies ?`)) {
    return
  }
  store.dispatch('deleteCompanies', companies.id)
    .then(res => {
      store.dispatch('getCompanies',companies)
    })
}

function editCompanies(companies){
emit('clickEdit',companies)
}
</script>


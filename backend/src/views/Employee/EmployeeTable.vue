<template>

  <div class="bg-white p-4 rounded-lg shadow">
    <div class="flex justify-between border-b-2 pb-3">
      <div class="flex items-center">
        <span class="whitespace-nowrap mr-3">Per Page</span>
        <select @change="getEmployees(null)" v-model="perPage" class="appearance-none relative block w-24 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
          <option value="5">5</option>
          <option value="10">10</option>
          <option value="20">20</option>
        </select>
      </div>
      <div class="flex items-center">
        <input v-model="search" @change="getEmployees(null)" class="appearance-none relative block w-48 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
               placeholder="type to search employee">
      </div>
    </div>
    <Spinner v-if="employee.loading" />
    <template v-else>
      <table class="table-auto w-full">
        <thead>
        <tr>
          <th class="border-b-2 p-2 text-left">ID</th>
          <th class="border-b-2 p-2 text-left">NAME</th>
          <th class="border-b-2 p-2 text-left">LASTNAME</th>
          <th class="border-b-2 p-2 text-left">COMPANIES</th>
          <th class="border-b-2 p-2 text-left">EMAIL</th>
          <th class="border-b-2 p-2 text-left">PHONE</th>
          <th class="border-b-2 p-2 text-left">Actions</th>
        </tr>
        </thead>
        <tbody v-for="employ in employee.data">
        <td class="border-b p-2">{{employ.id}}</td>
        <td class="border-b p-2">{{employ.first_name}}</td>
        <td class="border-b p-2">{{employ.last_name}}</td>
        <td class="border-b p-2">{{employ.companies[0].name}}</td>
        <td class="border-b p-2">{{employ.email}}</td>
        <td class="border-b p-2">{{employ.phone}}</td>
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
                      @click="editemployee(employ)"
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
                      @click="deleteEmployee(employ)"
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
          Showing from {{employee.from}} to {{employee.to}}
        </span>
        <nav v-if="employee.total > employee.limit" class="relative z-0 inline-flex justify-center rounded-md  shadow-sm -space-x-px" aria-label="Pagination">
          <a v-for="(link,i) of employee.links" :key="i" :disabled="!link.url" href="#" @click.prevent="getForPage($event,link)" aria-current="page"
             class="relative inline-flex items-center px-4 py-2 border text-sm font-medium whitespace-nowrap" v-html="link.label"
             :class="[link.active ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600'
                  :'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                  i===0 ? 'rounded-l-md':'',
                  i === employee.links.length-1 ? 'rounded-r-md' : '',
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
import {EMPLOYEE_PER_PAGE} from "../../constants";
import {Menu, MenuButton, MenuItem, MenuItems} from "@headlessui/vue";
import {DotsVerticalIcon, PencilIcon, TrashIcon} from '@heroicons/vue/outline'

const emit = defineEmits(['clickEdit'])

const perPage = ref(EMPLOYEE_PER_PAGE);
const search = ref('');

const employee = computed(() => store.state.employee)
const companies = ref([])
onMounted(()=>{
  getEmployees();
})

function getEmployees(url = null){
  store.dispatch('getEmployees',{
    url,
    search:search.value,
    perPage:perPage.value
  })
}
function getForPage(ev,link){
  if (!link.url || link.active){
    return;
  }else {
    getEmployees(link.url);
  }

}
function deleteEmployee(employee){
  if (!confirm(`Are you sure you want to delete the employee ?`)) {
    return
  }
  store.dispatch('deleteEmployee', employee.id)
    .then(res => {
      store.dispatch('getEmployees',employee)
    })
}


function editemployee(employee){
emit('clickEdit',employee)
}


</script>


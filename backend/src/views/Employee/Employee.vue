<template>

  <div class="flex items-center justify-between mb-3">
    <h1 class="text-3xl font-semibold">employee</h1>
    <button @click="showEmployeeModal" type="button"
            class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
    >
      Add new employee
    </button>
  </div>

  <EmployeeModal v-model="showModal" :emp="employeeModel" @close="onModalClose"/>
  <EmployeeTable @clickEdit="editEmployee"/>
</template>

<script setup>

import {ref} from "vue";
import store from "../../store";
import EmployeeModal from "./EmployeeModal.vue";
import EmployeeTable from "./EmployeeTable.vue";
const DEFAULT_EMPTY_OBJECT={
  id:'',
  first_name:'',
  last_name:'',
  companies:'',
  email:'',
  phone:'',
}
const showModal = ref(false);
const employeeModel = ref({...DEFAULT_EMPTY_OBJECT})
function showEmployeeModal(){
  showModal.value = true;
}

function editEmployee(employee){
store.dispatch('getEmploy',employee.id)
  .then(({data}) => {
    employeeModel.value = data.data;
    showEmployeeModal();
  })
}

function onModalClose(){
  employeeModel.value = {...DEFAULT_EMPTY_OBJECT};
}

</script>



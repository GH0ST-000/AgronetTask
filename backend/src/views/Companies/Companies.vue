<template>

  <div class="flex items-center justify-between mb-3">
    <h1 class="text-3xl font-semibold">Companies</h1>
    <button @click="showCompaniesModal" type="button"
            class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
    >
      Add new companies
    </button>
  </div>
  <CompaniesModal v-model="showModal" :companies="companiesModel" @close="onModalClose"/>
  <CompaniesTable @clickEdit="editCompanies"/>
</template>

<script setup>
import CompaniesTable from "./CompaniesTable.vue";
import CompaniesModal from "./CompaniesModal.vue";
import {ref} from "vue";
import store from "../../store";
const DEFAULT_EMPTY_OBJECT={
  id:'',
  name:'',
  email:'',
  image:'',
  website:'',
}

const showModal = ref(false);
const companiesModel = ref({...DEFAULT_EMPTY_OBJECT})
function showCompaniesModal(){
  showModal.value = true;
}

function editCompanies(companies){
store.dispatch('getCompany',companies.id)
  .then(({data}) => {
    companiesModel.value = data;
    showCompaniesModal();
  })
}

function onModalClose(){
  companiesModel.value = {...DEFAULT_EMPTY_OBJECT};
}

</script>



<template>
    <div>
      <h3 class="text-lg font-medium leading-6 mt-6  text-gray-900">Statistics For Companies And Employees</h3>

      <dl class="mt-5 w-full flex justify-between">
        <div class="relative sm:w-1/2 w-full overflow-hidden  rounded-lg bg-white px-4 pt-5 pb-12 shadow sm:px-6 sm:pt-6">
          <dt>
            <div class="absolute rounded-md bg-indigo-500 p-3">
              <UsersIcon class="h-6 w-6 text-white"></UsersIcon>
            </div>
            <p class="ml-16 truncate text-sm font-medium text-gray-500">Total Employee</p>
          </dt>
          <dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
            <p class="text-2xl font-semibold text-gray-900">71,897</p>
            <p class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
              <svg class="h-5 w-5 flex-shrink-0 self-center text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 17a.75.75 0 01-.75-.75V5.612L5.29 9.77a.75.75 0 01-1.08-1.04l5.25-5.5a.75.75 0 011.08 0l5.25 5.5a.75.75 0 11-1.08 1.04l-3.96-4.158V16.25A.75.75 0 0110 17z" clip-rule="evenodd" />
              </svg>
              <span class="sr-only"> Increased by </span>
              122
            </p>
            <div class="absolute inset-x-0 bottom-0 bg-gray-50 px-4 py-4 sm:px-6">
              <div class="text-sm">
                <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500"> View all<span class="sr-only"> Total Companies</span></a>
              </div>
            </div>
          </dd>
        </div>

        <div class="relative sm:w-1/2 w-full ml-4 overflow-hidden rounded-lg bg-white px-4 pt-5 pb-12 shadow sm:px-6 sm:pt-6">
          <dt>
            <div class="absolute rounded-md bg-indigo-500 p-3">
              <FolderOpenIcon class="h-6 w-6 text-white"></FolderOpenIcon>
            </div>
            <p class="ml-16 truncate text-sm font-medium text-gray-500">Total Companies</p>
          </dt>
          <dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
            <p class="text-2xl font-semibold text-gray-900">58.16%</p>
            <p class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
              <svg class="h-5 w-5 flex-shrink-0 self-center text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 17a.75.75 0 01-.75-.75V5.612L5.29 9.77a.75.75 0 01-1.08-1.04l5.25-5.5a.75.75 0 011.08 0l5.25 5.5a.75.75 0 11-1.08 1.04l-3.96-4.158V16.25A.75.75 0 0110 17z" clip-rule="evenodd" />
              </svg>
              <span class="sr-only"> Increased by </span>
              5.4%
            </p>
            <div class="absolute inset-x-0 bottom-0 bg-gray-50 px-4 py-4 sm:px-6">
              <div class="text-sm">
                <RouterLink to="/employee" class="font-medium text-indigo-600 hover:text-indigo-500">View all</RouterLink>
              </div>
            </div>
          </dd>
        </div>
      </dl>
    </div>

</template>

<script setup>
import { UsersIcon } from  '@heroicons/vue/solid'
import { FolderOpenIcon } from  '@heroicons/vue/solid'



</script>

<style scoped>

</style>

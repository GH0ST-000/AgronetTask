<template>


  <div class="w-[200px]  transition-all bg-gray-800 text-white py-4 px-2">
    <nav class="space-y-1 px-2 text-white w-32">
      <router-link :to="{name: 'app.dashboard'}"
                   class="flex items-center p-2 rounded transition-colors hover:bg-black/30">
      <span class="mr-2 text-gray-300">
        <HomeIcon class="w-5"/>
      </span>
        <span class="text-xs">
        Dashboard
      </span>
      </router-link>
      <router-link :to="{name: 'app.companies'}"
                   class="flex items-center p-2 rounded transition-colors hover:bg-black/30">
      <span class="mr-2 text-gray-300">
        <ChartBarIcon class="w-5"/>
      </span>
        <span class="text-xs">
        Companies
      </span>
      </router-link>
      <router-link :to="{name: 'app.employee'}"
                   class="flex items-center p-2 rounded transition-colors hover:bg-black/30">
      <span class="mr-2 text-gray-300">
        <UsersIcon class="w-5"/>
      </span>
        <span class="text-xs">
        Employee
      </span>
      </router-link>

    </nav>
  </div>
</template>

<script setup>
  import {HomeIcon, UsersIcon, ViewListIcon, ChartBarIcon} from '@heroicons/vue/outline'
</script>

<style scoped>

</style>

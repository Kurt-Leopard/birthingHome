<script setup>
import { RouterLink, RouterView } from 'vue-router'
</script>

<template>
  <header class="py-1 px-6 flex items-center justify-between" style="background:#f0f0f0;">
    <div class="flex  items-center">
      <img src="./assets/logo.png" alt="" class="w-12 h-12">
      <RouterLink to="/" class="text-black">LenLen Birth Attendance</RouterLink>
    </div>
    <div class="flex  items-center">
      <RouterLink to="/" class="text-black"><i class="fas fa-user mx-5"></i>Admin (user)</RouterLink>
  
      <RouterLink to="/" class="text-black"><i class="fas fa-user mx-5"></i>Account</RouterLink>
    </div>
  </header>
  
  <RouterView />
</template>

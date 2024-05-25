<template>
  <main class="w-full h-full lg:px-6 xl:px-6 p-6 lg:flex xl:flex items-center py-12" style="background:#d9d9d9;">
    <div class="w-full lg:flex xl:flex bg-white px-52 py-12 rounded-lg shadow-lg">
      <section class="w-1/2 border border-gray-300   rounded-l-xl shadow-lg" style="background:#f0f0f0;">
        <h1 class="text-center text-center mt-12 font-bold text-1xl">Lenlen Birth Attendance</h1>
        <div class="flex items-center justify-center">
          <img src="../assets/logo.png" alt="" class="w-72 h-72">
        </div>
      </section>
      <form class="w-1/2 border border border-gray-300  rounded-r-xl shadow-lg"   @submit="login" style="background:#f0f0f0;">
        <h1 class="text-center my-12 font-bold text-2xl">ADMINISTRATOR</h1>
        <div class="w-full flex items-center">
          <input type="text" placeholder="Username" class="w-full mx-14 py-2 px-4 rounded-lg my-4 shadow-lg"  v-model="email">
        </div>
        <div class="w-full  flex items-center">
          <input type="text" placeholder="Password" class="w-full mx-14 py-2 px-4 rounded-lg my-4 shadow-lg" v-model="password" >
        </div>
        <div class="w-full  flex items-center justify-center">
          <button type="submit" class="p-2 border bg-white rounded-lg w-1/4 my-4 text-black font-bold shadow-lg">{{buttonName }}</button>
        </div>
        <div class="w-full  flex items-center justify-center">
          <router-link to="/" class="text-center text-blue-500 mb-10">Forgot password?</router-link>
        </div>
      </form>
    </div>
  </main>
</template>

<script setup>
import { useUserStore } from '@/stores/user';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from '../../axios-config.js';

const myStore = useUserStore()

const email = ref('')
const password = ref('')
const buttonName = ref('Login')

const router = useRouter()

const login = (e) => {
  e.preventDefault();
  buttonName.value = "Logging In..."
  axios.post('/login', {
    email: email.value,
    password: password.value
  }).then((response) => {
    if (response.data.status === 200) {
      console.log(response)
      buttonName.value = "Login"
      localStorage.setItem('token', response.data.token)
      localStorage.setItem('isLoggedIn', true)
      myStore.isLoggedIn = true
      location.reload();
    }
  }).catch((err) => {
    console.log(err)
    buttonName.value = "Login"
  })
}

onMounted(() => {
  localStorage.removeItem('token')
  localStorage.removeItem('isLoggedIn')
  myStore.isLoggedIn = false
})

</script>
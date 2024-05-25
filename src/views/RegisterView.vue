<template>
    <main class="w-full h-full lg:px-6 xl:px-6 p-6 lg:flex xl:flex items-center py-6" style="background:#d9d9d9;">
      <main class="w-full">
        <div class="w-full flex items-center justify-end">
          <RouterLink to="/" class="p-2 bg-white mb-6  rounded shadow-lg border">
            Back
          </RouterLink>
        </div>
        <div class="w-full bg-white  px-6 py-12 rounded-lg shadow-lg">
          <div style="background-color: #d9d9d9;" class="px-5 rounded-lg py-5">
            <h1 class="text-center text-2xl font-bold py-3">Employee Registration</h1>
            <div class=" lg:flex xl:flex">
              <section class="xl:w-1/2 lg:w-1/2 w-full ">
                <div class="px-4 xl:flex lg:flex items-center my-5">
                  <p class="w-1/3 font-bold">Full name:</p>
                  <input type="text" class="w-full p-2 rounded-lg" v-model="formData.fullName">
                </div>
                <div class="px-4 xl:flex lg:flex items-center my-5">
                  <p class="w-1/3 font-bold">Email:</p>
                  <input type="email" class="w-full p-2 rounded-lg" v-model="formData.email">
                </div>
                <div class="px-4 xl:flex lg:flex items-center my-5">
                  <p class="w-1/3 font-bold">Gender:</p>
                  <input type="text" class="w-full p-2 rounded-lg" v-model="formData.gender">
                </div>
                <div class="px-4 xl:flex lg:flex items-center my-5">
                  <p class="w-1/3 font-bold">Birth Date:</p>
                  <input type="date" class="w-full p-2 rounded-lg" v-model="formData.birthDate">
                </div>
                <div class="px-4 xl:flex lg:flex items-center my-5">
                  <p class="w-1/3 font-bold">Age:</p>
                  <input type="number" class="w-full p-2 rounded-lg" v-model="formData.age">
                </div>
              </section>
              <section class="xl:w-1/2 lg:w-1/2 w-full">
                <div class="px-4 xl:flex lg:flex items-center my-5">
                  <p class="w-1/3 font-bold">Status:</p>
                  <input type="text" class="w-full p-2 rounded-lg" v-model="formData.status">
                </div>
                <div class="px-4 xl:flex lg:flex items-center my-5">
                  <p class="w-1/3 font-bold">Address:</p>
                  <input type="address" class="w-full p-2 rounded-lg" v-model="formData.address">
                </div>
                <div class="px-4 xl:flex lg:flex items-center my-5">
                  <p class="w-1/3 font-bold">Citizen Ship:</p>
                  <input type="text" class="w-full p-2 rounded-lg" v-model="formData.citizenship">
                </div>
                <div class="px-4 xl:flex lg:flex items-center my-5">
                  <p class="w-1/3 font-bold">Religion:</p>
                  <input type="text" class="w-full p-2 rounded-lg" v-model="formData.religion">
                </div>
                <div class="px-4 xl:flex lg:flex items-center my-5">
                  <p class="w-1/3 font-bold">Upload profile:</p>
                  <input type="file" class="w-full p-2 rounded-lg" @change="handleFileUpload">
                </div>
              </section>
            </div>
            <div class="px-4 xl:flex lg:flex justify-end my-5">
              <button type="button" class="p-3 bg-white border shadow-lg rounded-lg w-32 font-bold" @click="submitForm">Save</button>
            </div>
          </div>
        </div>
      </main>
    </main>
  </template>
  <script setup>
  import { ref } from 'vue';
  import { RouterLink } from 'vue-router';
  import axios from '../../axios-config.js';

  const formData = ref({
    fullName: '',
    email: '',
    gender: '',
    birthDate: '',
    age: '',
    status: '',
    address: '',
    citizenship: '',
    religion: '',
  });
  const profile=ref();
  const password=ref('123456');
  const handleFileUpload = (event) => {
   profile.value = event.target.files[0];
  };

  const submitForm = async () => {
    try {
      const formDataToSend = new FormData();
      formDataToSend.append('name', formData.value.fullName);
      formDataToSend.append('email', formData.value.email);
      formDataToSend.append('password', password.value);
      formDataToSend.append('gender', formData.value.gender);
      formDataToSend.append('birthDate', formData.value.birthDate);
      formDataToSend.append('age', formData.value.age);
      formDataToSend.append('status', formData.value.status);
      formDataToSend.append('address', formData.value.address);
      formDataToSend.append('citizenship', formData.value.citizenship);
      formDataToSend.append('religion', formData.value.religion);
      formDataToSend.append('profile', profile.value);
      const token = localStorage.getItem('token');

      const response = await axios.post('/user', formDataToSend,{
    headers: {
      Authorization: `Bearer ${token}`,
    }
  });
      console.log(response.data);
      // Handle success, show message, redirect, etc.
      alert('Inserted Successful!')
    } catch (error) {
      console.error('Error:', error);
      // Handle error, show error message, etc.
    }
  };
</script>

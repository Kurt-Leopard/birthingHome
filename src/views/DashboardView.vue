<template>
  <main class="w-full h-full lg:px-6 xl:px-6 p-6 lg:flex xl:flex items-center py-6" style="background:#d9d9d9;">
    <main class="w-full">
      <div class="w-full flex items-center justify-end">
        <RouterLink to="/Register" class="p-2 bg-white mb-6 rounded shadow-lg border">
          Add Employee
        </RouterLink>
      </div>
      <div class="w-full lg:flex xl:flex bg-white px-6 py-12 rounded-lg shadow-lg">
        <section class="w-full rounded-lg px-4 lg:flex xl:flex flex-wrap justify-between">
          <ul v-for="users in user" :key="users.id" class="xl:w-1/4 lg:w-1/4 w-full rounded my-3 xl:mx-3 lg:mx-3 bg-gray-200">
            <li class="p-2">
              <img :src="`../src/assets/${users.profile}`" class="w-full h-72 border rounded-lg" alt="">
            </li>
            <li class="p-2">Name: {{ users.name }}</li>
            <li class="p-2">Email: {{ users.email }}</li>
            <li class="p-2 flex justify-between">
              <button @click="viewMore(users)" class="bg-blue-500 text-white px-4 py-2 rounded">View</button>
              <button @click="openUpdateModal(users)" class="bg-green-500 text-white px-4 py-2 rounded">Update</button>
              <button @click="confirmDelete(users)" class="bg-red-500 text-white px-4 py-2 rounded">Delete</button>
            </li>
          </ul>
        </section>
      </div>
    </main>

    <div v-if="showUpdateModal" class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-75">
      <!-- Update modal content -->
      <div class="w-full bg-white  px-6 py-12 rounded-lg shadow-lg">
          <div style="background-color: #d9d9d9; max-height: 500px; overflow-y: auto;" class="px-5 py-2 rounded-lg">
            <h1 class="text-center text-2xl font-bold py-3">Employee Update</h1>
            <div class=" lg:flex xl:flex">
              <section class="xl:w-1/2 lg:w-1/2 w-full ">
                <div class="px-4 lg:flex xl:flex  items-center my-5">
                  <p class="w-1/3 font-bold">Full name:</p>
                  <input type="text" class="w-full p-2 rounded-lg" v-model="formData.fullName">
                </div>
                <div class="px-4 lg:flex xl:flex  items-center my-5">
                  <p class="w-1/3 font-bold">Email:</p>
                  <input type="email" class="w-full p-2 rounded-lg" v-model="formData.email">
                </div>
                <div class="px-4 lg:flex xl:flex  items-center my-5">
                  <p class="w-1/3 font-bold">Gender:</p>
                  <input type="text" class="w-full p-2 rounded-lg" v-model="formData.gender">
                </div>
                <div class="px-4 lg:flex xl:flex  items-center my-5">
                  <p class="w-1/3 font-bold">Birth Date:</p>
                  <input type="date" class="w-full p-2 rounded-lg" v-model="formData.birthDate">
                </div>
                <div class="px-4 lg:flex xl:flex  items-center my-5">
                  <p class="w-1/3 font-bold">Age:</p>
                  <input type="number" class="w-full p-2 rounded-lg" v-model="formData.age">
                </div>
              </section>
              <section class="xl:w-1/2 lg:w-1/2 w-full ">
                <div class="px-4 lg:flex xl:flex  items-center my-5">
                  <p class="w-1/3 font-bold">Status:</p>
                  <input type="text" class="w-full p-2 rounded-lg" v-model="formData.status">
                </div>
                <div class="px-4 lg:flex xl:flex  items-center my-5">
                  <p class="w-1/3 font-bold">Address:</p>
                  <input type="address" class="w-full p-2 rounded-lg" v-model="formData.address">
                </div>
                <div class="px-4 lg:flex xl:flex  items-center my-5">
                  <p class="w-1/3 font-bold">Citizen Ship:</p>
                  <input type="text" class="w-full p-2 rounded-lg" v-model="formData.citizenship">
                </div>
                <div class="px-4 lg:flex xl:flex  items-center my-5">
                  <p class="w-1/3 font-bold">Religion:</p>
                  <input type="text" class="w-full p-2 rounded-lg" v-model="formData.religion">
                </div>
                <div class="px-4 lg:flex xl:flex  items-center my-5">
                  <p class="w-1/3 font-bold">Upload profile:</p>
                  <input type="file" class="w-full p-2 rounded-lg" @change="handleFileUpload">
                </div>
              </section>
            </div>
            <div class="px-4 lg:flex xl:flex  justify-end my-5">
              <button type="button" class="p-3 bg-white border shadow-lg rounded-lg w-32 font-bold" @click="submitForm">Save</button>
            </div>
          </div>
        </div>
    </div>
    <!-- Modal for displaying user details -->
    <div v-if="showModal" class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-75">
      <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full relative">
        <button class="absolute top-0 right-0 m-4 text-xl font-bold" @click="closeModal">&times;</button>
        <h2 class="text-2xl mb-4">User Details</h2>
        <p><strong>Profile:</strong> <img :src="`../src/assets/${selectedUser.profile}`" alt="Profile Image" class="w-full h-48 mb-4"></p>
        <p><strong>Name:</strong> {{ selectedUser.name }}</p>
        <p><strong>Email:</strong> {{ selectedUser.email }}</p>
        <p><strong>Age:</strong> {{ selectedUser.age }}</p>
        <p><strong>Status:</strong> {{ selectedUser.status }}</p>
        <p><strong>Address:</strong> {{ selectedUser.address }}</p>
        <p><strong>Citizenship:</strong> {{ selectedUser.citizenship }}</p>
        <p><strong>Religion:</strong> {{ selectedUser.religion }}</p>
        <button @click="closeModal" class="bg-gray-500 text-white px-4 py-2 rounded mt-4">Close</button>
      </div>
    </div>

    <!-- Modal for confirming delete -->
    <div v-if="showDeleteModal" class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-75">
      <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full relative">
        <button class="absolute top-0 right-0 m-4 text-xl font-bold" @click="closeDeleteModal">&times;</button>
        <h2 class="text-2xl mb-4">Confirm Delete</h2>
        <p>Are you sure you want to delete {{ selectedUser.name }}?</p>
        <div class="flex justify-end mt-4">
          <button @click="deleteUser" class="bg-red-500 text-white px-4 py-2 rounded mr-2">Delete</button>
          <button @click="closeDeleteModal" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
        </div>
      </div>
    </div>
  </main>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { RouterLink } from 'vue-router';
import axios from '../../axios-config.js';

const user = ref([]);
const selectedUser = ref(null);
const showModal = ref(false);
const showDeleteModal = ref(false);

const refreshData = () => {
  const token = localStorage.getItem('token');
  axios.get("/user", {
    headers: {
      Authorization: `Bearer ${token}`,
    }
  }).then((res) => {
    user.value = res.data.data;
  }).catch((err) => {
    console.error('Error fetching users:', err);
  });
};

const viewMore = (user) => {
  selectedUser.value = user;
  showModal.value = true;
};

const closeModal = () => {
  showModal.value = false;
  selectedUser.value = null;
};

const confirmDelete = (user) => {
  selectedUser.value = user;
  showDeleteModal.value = true;
};

const closeDeleteModal = () => {
  showDeleteModal.value = false;
  selectedUser.value = null;
};

const deleteUser = () => {
  const token = localStorage.getItem('token');
  axios.delete(`/user/${selectedUser.value.id}`, {
    headers: {
      Authorization: `Bearer ${token}`,
    }
  }).then(() => {
    user.value = user.value.filter(u => u.id !== selectedUser.value.id);
    closeDeleteModal();
  }).catch((err) => {
    console.error('Error deleting user:', err);
  });
};

onMounted(refreshData);




const showUpdateModal = ref(false);

const formData = ref({
    id:'',
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
const openUpdateModal=(user)=>{
  showUpdateModal.value=true;
  formData.value.id = user.id;
  formData.value.fullName = user.name;
  formData.value.email = user.email;
  formData.value.gender = user.gender;
  formData.value.birthDate = user.birthDate;
  formData.value.age = user.age;
  formData.value.status = user.status;
  formData.value.address = user.address;
  formData.value.citizenship = user.citizenship;
  formData.value.religion = user.religion;
}


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

      const response = await axios.post(`/user/${formData.value.id}`, formDataToSend,{
    headers: {
      Authorization: `Bearer ${token}`,
    }
  });
      console.log(response.data);
      // Handle success, show message, redirect, etc.
      alert('Updated Successful!')
      showUpdateModal.value=false;
    } catch (error) {
      console.error('Error:', error);
      // Handle error, show error message, etc.
    }
  };

</script>


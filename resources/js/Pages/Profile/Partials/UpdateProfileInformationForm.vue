<template>
    <form @submit.prevent="submitForm">
      <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
        <input id="name" v-model="form.name" type="text" required class="mt-1 block w-full px-3 py-2 border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
      </div>
  
      <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
        <input id="email" v-model="form.email" type="email" required class="mt-1 block w-full px-3 py-2 border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
      </div>
  
      <div class="mb-4">
        <label for="birthday" class="block text-sm font-medium  text-gray-700">Birthday</label>
        <input id="birthday" v-model="form.birthday" type="date" class="mt-1 bg-gray-100 block w-full px-3 py-2 border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
      </div>
  
      <div class="mb-4">
        <button type="submit" class="bg-yellow-950 text-white px-4 py-2 rounded-md hover:bg-yellow-950/70">Save</button>
      </div>
    </form>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import { Inertia } from '@inertiajs/inertia';
  
  const props = defineProps(['auth']);
  
  const form = ref({
    name: props.auth.user.name,
    email: props.auth.user.email,
    birthday: props.auth.user.birthday,
  });
  
  const submitForm = () => {
    Inertia.patch(route('profile.update'), form.value, {
      onSuccess: () => {
        // Success message
        alert('Profile updated successfully!');
      },
      onError: (errors) => {
        // Handle errors, e.g., show validation errors
        console.log(errors);
      },
    });
  };
  </script>
  
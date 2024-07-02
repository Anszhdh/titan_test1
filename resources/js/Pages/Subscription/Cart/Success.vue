<template>
    <FooterLayout>
    <AuthenticatedLayout>
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold text-center mt-10">Payment Successful!</h1>
        <p class="text-center mt-4">Thank you for your purchase. Your susbcription is being processed.</p>
        <!-- <div class="text-center mt-6">
            <router-link to="/" class="bg-yellow-950 text-white py-2 px-4 rounded"></router-link>
        </div> -->
    </div>
   </AuthenticatedLayout>
</FooterLayout>
  </template>
  
  <script setup>
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import FooterLayout from '@/Layouts/FooterLayout.vue';
  
  </script>
  
  <style scoped>
  /* Add any specific styles here */
  </style>
  
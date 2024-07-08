<template>
    <FooterLayout>
<AuthenticatedLayout>

    <div class="container items-center mx-auto py-6">
    <h1 class="text-2xl font-bold mb-4">Your Subscriptions</h1>

    <!-- Check if subscriptions array is empty -->
    <div v-if="subscriptions.length === 0" class="text-gray-600">
      <p>No subscriptions found.</p>
    </div>

    <!-- Iterate over subscriptions array -->
    <div v-else class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
      <div v-for="subscription in subscriptions" :key="subscription.id" class="bg-white rounded-lg shadow-md p-4">
        <h3 class="text-lg font-semibold mb-2">{{ subscription.type }}</h3>
        <p class="text-gray-700">Subscription ID: {{ subscription.id }}</p>
        <p class="text-gray-700">Price: ${{ subscription.price }}</p>
        
        <!-- Display payment details -->
        <div class="mt-2">
          <h4 class="text-sm font-semibold mb-1">Payment Details</h4>
          <div class="flex items-center">
            <span class="mr-2">Status:</span>
            <span class="text-blue-500">{{ subscription.payments[0].status }}</span>
          </div>
          <div class="flex items-center">
            <span class="mr-2">Payment Type:</span>
            <span>{{ formatPaymentType(subscription.payments[0].type) }}</span>
          </div>
          <!-- <div class="flex items-center">
            <span class="mr-2">Payment Proof:</span>
            <a :href="subscription.payments[0].payment_proof_url" target="_blank" class="text-blue-500 underline">View Proof</a>
          </div> -->
        </div>
      </div>
    </div>
  </div>
</AuthenticatedLayout>
</FooterLayout>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import FooterLayout from '@/Layouts/FooterLayout.vue';

  const props = defineProps({
    subscriptions: Array,
  })
  
  // Use ref() for reactive properties
  const subscriptions = ref(props.subscriptions)

  const formatPaymentType = (type) => {
  // Replace underscores with spaces and capitalize each word
  return type.split('_').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
};
  </script>
  
  <style scoped>
  /* Add your custom CSS styles here */
  </style>
  
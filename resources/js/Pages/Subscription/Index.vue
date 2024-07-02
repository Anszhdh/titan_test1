<template>
    <div>
      <h1>Subscriptions</h1>
      <ul>
        <li v-for="subscription in subscriptions" :key="subscription.id">
          <h2>Subscription ID: {{ subscription.id }}</h2>
          <p>Type: {{ subscription.type }}</p>
          <p>Price: ${{ subscription.price.toFixed(2) }}</p>
          <p>Status: {{ subscription.status }}</p>
          
          <!-- Display subscription payments -->
          <div v-if="subscription.payments.length > 0">
            <h3>Payments</h3>
            <ul>
              <li v-for="payment in subscription.payments" :key="payment.id">
                <p>Amount: ${{ payment.amount.toFixed(2) }}</p>
                <p>Status: {{ payment.status }}</p>
                <p>Type: {{ payment.type }}</p>
                <!-- Link to payment proof if available -->
                <a v-if="payment.payment_proof_url" :href="payment.payment_proof_url" target="_blank">View Payment Proof</a>
              </li>
            </ul>
          </div>
          
          <!-- Display shipping status if available -->
          <p v-if="subscription.shipping">Shipping: Shipped</p>
          <p v-else>Shipping: Pending</p>
          
          <hr>
        </li>
      </ul>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import { usePage } from '@inertiajs/inertia-vue3';
  
  const { data: { subscriptions } } = usePage().props;
  
  // If you have subscriptions passed from Laravel directly, you might not need an API call here
  
  </script>
  
  <style scoped>
  /* Add your scoped styles here */
  </style>
  
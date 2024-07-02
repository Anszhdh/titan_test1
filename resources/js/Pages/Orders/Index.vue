<template>
    <FooterLayout>
      <AuthenticatedLayout>
        <div class="container mx-auto px-4 py-8">
          <h1 class="text-2xl font-bold mb-6">Your Orders</h1>
          <div v-if="orders.length === 0" class="text-center text-gray-500">No orders found.</div>
          <div v-else>
            <div v-for="order in orders" :key="order.id" class="border rounded-lg p-4 mb-4">
              <div class="flex justify-between items-center">
                <div>
                  <h2 class="text-lg font-semibold">Order #{{ order.id }}</h2>
                  <p class="text-gray-500">Placed on: {{ new Date(order.created_at).toLocaleDateString() }}</p>
                  <p class="text-gray-500">Status: {{ order.status }}</p>
                </div>
                <div class="text-right">
                  <p class="text-lg font-bold">Total: RM {{ parseFloat(order.total_price).toFixed(2) }}</p>
                  <p><a href="#" class="text-blue-500">Order Details</a></p>
                </div>
              </div>
              <div class="mt-4">
                <h3 class="text-md font-semibold mb-2">Items in this order:</h3>
               <!-- Display order items -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div v-for="item in order.orderItems" :key="item.id" class="border p-2 rounded-lg">
                        <img :src="item.product.image_url" alt="Product Image" class="w-full h-32 object-cover mb-2">
                        <p class="text-sm font-semibold">{{ item.product.name }}</p>
                        <p class="text-sm">Quantity: {{ item.quantity }}</p>
                        <p class="text-sm">Price: ${{ parseFloat(item.unit_price).toFixed(2) }}</p>
                    </div>
                    </div>
                  <!-- Display shipping status -->
                    <p v-if="order.shipping">Shipping: Shipped</p>
                    <p v-else>Shipping: Pending</p>
                        </div>
            </div>
          </div>
        </div>
      </AuthenticatedLayout>
    </FooterLayout>
  </template>
  
  <script setup>
import { ref, onMounted, watch } from 'vue';
  import { usePage } from '@inertiajs/inertia-vue3';
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import FooterLayout from '@/Layouts/FooterLayout.vue';
  
  const props = defineProps({
    orders: {
        type: Array,
        required: true
    }
});

// Reactive variable to hold orders
const orders = ref(props.orders || []);

// Log orders on component mount
onMounted(() => {
    console.log('Orders on mounted:', orders.value);
});

const orderStatus = (order) => {
  if (order.shipping) {
    return 'Shipped';
  } else {
    return 'Pending';
  }
};
  
  </script>
  
  <style scoped>
  .container {
      max-width: 800px;
  }
  </style>
  
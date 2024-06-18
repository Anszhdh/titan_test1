<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
  order: Object,
});
</script>

<template>
  <Head title="Order Success" />
  <AuthenticatedLayout :authenticated="true">
    <div class="container mx-auto px-4">
      <h1 class="text-2xl font-bold mb-4">Order Success</h1>
      <div class="bg-white shadow-md rounded-lg p-6">
        <p>Your order has been placed successfully. Your order ID is {{ order.id }}.</p>
        <p>Status: {{ order.status }}</p>
        <div class="mt-4">
          <h2 class="text-xl font-bold mb-2">Order Details</h2>
          <table class="w-full">
            <thead>
              <tr>
                <th class="text-left">Product</th>
                <th class="text-left">Quantity</th>
                <th class="text-left">Price</th>
                <th class="text-left">Total</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in order.order_items" :key="item.id" class="border-b">
                <td class="py-4">{{ item.product.name }}</td>
                <td class="py-4">{{ item.quantity }}</td>
                <td class="py-4">{{ item.unit_price }}</td>
                <td class="py-4">{{ item.unit_price * item.quantity }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

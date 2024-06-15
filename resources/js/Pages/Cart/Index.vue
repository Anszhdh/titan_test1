<script setup>
import { ref, computed } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { defineProps } from 'vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
  cart: Array
});

const totalPrice = computed(() => {
  return props.cart.reduce((acc, item) => acc + item.price * item.quantity, 0);
});

function updateQuantity(id, quantity) {
  if (quantity > 0) {
    Inertia.post('/cart/update', { id, quantity });
  }
}

function removeFromCart(id) {
  Inertia.post('/cart/remove', { id });
}

function checkout() {
  Inertia.post('/checkout');
}
</script>

<template>
    <Head title="Cart" />
    <AuthenticatedLayout :authenticated="true">
    <div class="container mx-auto px-4">
      <h1 class="text-2xl font-bold mb-4">My Cart</h1>
      <div v-if="cart.length > 0" class="bg-white shadow-md rounded-lg p-6">
        <table class="w-full">
          <thead>
            <tr>
              <th class="text-left">Product</th>
              <th class="text-left">Quantity</th>
              <th class="text-left">Price</th>
              <th class="text-left">Total</th>
              <th class="text-left"></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in cart" :key="item.id" class="border-b">
              <td class="py-4">
                <div class="flex items-center">
                  <img :src="item.product.image_url" class="w-20 h-20 object-cover mr-4" :alt="item.product.name">
                  <div>{{ item.product.name }}</div>
                </div>
              </td>
              <td class="py-4">
                <form @submit.prevent="updateQuantity(item.id, item.quantity)">
                  <input type="number" v-model.number="item.quantity" class="w-16 text-center border rounded">
                  <button type="submit" class="ml-2 bg-blue-500 text-white py-1 px-2 rounded">Update</button>
                </form>
              </td>
              <td class="py-4">RM {{ item.price }}</td>
              <td class="py-4">RM {{ (item.price * item.quantity).toFixed(2) }}</td>
              <td class="py-4">
                <button @click="removeFromCart(item.id)" class="bg-red-500 text-white py-1 px-2 rounded">Remove</button>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="mt-6 flex justify-between items-center">
          <h2 class="text-xl font-bold">
            Total: RM {{ totalPrice.toFixed(2) }}</h2>
        <button @click="checkout" class="bg-green-500 text-white py-2 px-4 rounded">Checkout</button>
      </div>
    </div>
    <div v-else class="text-center text-gray-500">
      <p>Your cart is empty.</p>
    </div>
  </div>
</AuthenticatedLayout>
</template>
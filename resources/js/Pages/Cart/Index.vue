<script setup>
import { ref, computed } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

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

function proceedToCheckout() {
  Inertia.visit('/checkout/summary');
}
</script>
<template>
  <Head title="Cart" />
  <AuthenticatedLayout>
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
                <div class="font-bold">{{ item.product.name }}</div>
              </div>
            </td>
            <td class="py-4">
              <form @submit.prevent="updateQuantity(item.id, item.quantity)">
                <input type="number" v-model.number="item.quantity" class="w-16 text-center border rounded">
                <button type="submit" class="ml-2 bg-yellow-950/80 text-white py-1 px-2 rounded-lg">Update</button>
              </form>
            </td>
            <td class="py-4">{{ item.price }}</td>
            <td class="py-4">{{ item.price * item.quantity }}</td>
            <td class="py-4">
              <button @click="removeFromCart(item.id)" class="px-2 py-1 bg-red-500 text-white rounded">Remove</button>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="mt-4">
        <p class="text-lg font-bold">Total: {{ totalPrice.toFixed(2) }}</p>
        <button @click="proceedToCheckout" class="bg-yellow-950 hover:text-white hover:bg-yellow-950/80 text-white py-2 px-4 rounded-xl mt-4">Checkout</button>
      </div>
    </div>
    <div v-else>
      <p>Your cart is empty.</p>
    </div>
  </div>
  </AuthenticatedLayout>
</template>

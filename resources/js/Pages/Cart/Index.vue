<script setup>
import { ref, computed } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import FooterLayout from '@/Layouts/FooterLayout.vue';

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
<FooterLayout>
  <AuthenticatedLayout>
    <div class="bg-black min-h-screen">
    <div class="container bg-black mx-auto px-4">
    <h1 class="text-2xl text-white font-bold mb-4">My Cart</h1>
    <div v-if="cart.length > 0" class="bg-orange-600/80 shadow-md rounded-lg p-6">
      <table class="w-full">
        <thead>
          <tr>
            <th class="text-left text-white">Product</th>
            <th class="text-left text-white">Quantity</th>
            <th class="text-left text-white">Price</th>
            <th class="text-left text-white">Total</th>
            <th class="text-left"></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in cart" :key="item.id" class="border-b">
            <td class="py-4">
              <div class="flex items-center">
                <img :src="item.product.image_url" class="w-20 h-20 object-cover mr-4" :alt="item.product.name">
                <div class="font-bold text-white">{{ item.product.name }}</div>
              </div>
            </td>
            <td class="py-4">
              <form @submit.prevent="updateQuantity(item.id, item.quantity)">
                <input type="number" v-model.number="item.quantity" class="w-16 text-center border rounded">
                <button type="submit" class="ml-2 bg-black text-white py-1 px-2 rounded-lg">Update</button>
              </form>
            </td>
            <td class="py-4">RM {{ item.price }}</td>
            <td class="py-4">RM {{ (item.price * item.quantity).toFixed(2) }}</td>
            <td class="py-4">
              <button @click="removeFromCart(item.id)" class="px-2 py-1 bg-black text-white rounded">Remove</button>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="mt-4">
        <p class="text-lg font-bold">Total: {{ totalPrice.toFixed(2) }}</p>
        <button @click="proceedToCheckout" class="bg-black hover:text-white hover:bg-black/60 text-white py-2 px-4 rounded-xl mt-4">Checkout</button>
      </div>
    </div>
    <div v-else>
      <p>Your cart is empty.</p>
    </div>
  </div>
</div>
  </AuthenticatedLayout>
</FooterLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import FooterLayout from '@/Layouts/FooterLayout.vue';

const props = defineProps({
  cart: Array,
  address: Object,
  totalPrice: Number,
  shippingPrice: Number,
  finalTotal: Number,
});

const addressForm = ref({
  address_line_1: props.address.address_line_1 || '',
  address_line_2: props.address.address_line_2 || '',
  city: props.address.city || '',
  state: props.address.state || '',
  postal_code: props.address.postal_code || '',
  phone_number: props.address.phone_number || '',
});

function submitAddress() {
  Inertia.post('/checkout/address', addressForm.value);
}

function editAddress() {
  // Function to toggle edit address mode
}

function proceedToPayment() {
  Inertia.visit('/checkout/payment');
}
</script>

<template>
  <FooterLayout>
  <AuthenticatedLayout>
    <div class="container mx-auto px-4">
      <h1 class="text-2xl font-bold mb-4 text-center">Checkout Summary</h1>
      <div v-if="cart.length > 0" class="bg-white shadow-md rounded-lg p-6">
        <table class="w-full mb-4">
          <thead>
            <tr>
              <th class="text-left">Product</th>
              <th class="text-left">Quantity</th>
              <th class="text-left">Price</th>
              <th class="text-left">Total</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in cart" :key="item.id">
              <td class="py-4">
                <div class="flex items-center">
                  <img :src="item.product.image_url" class="w-20 h-20 object-cover mr-4" :alt="item.product.name">
                  <div>
                    <p class="font-bold">{{ item.product.name }}</p>
                    <p>{{ item.product.description }}</p>
                  </div>
                </div>
              </td>
              <td class="py-4">{{ item.quantity }}</td>
              <td class="py-4">RM {{ item.price }}</td>
              <td class="py-4">RM {{ (item.price * item.quantity) }}</td>
            </tr>
          </tbody>
        </table>
        <div class="mt-4 text-right mr-10">
            <p class="text-lg font-bold">Subtotal: RM {{ totalPrice.toFixed(2) }}</p>
            <p class="text-md text-yellow-950">+ RM {{ shippingPrice.toFixed(2) }} (Shipping)</p>
            <p class="text-lg font-bold mt-5">Total: RM {{ finalTotal.toFixed(2) }}</p>
        </div>
        <hr class="my-4 border-gray-300">
        <!-- Address Section -->
        <div class="pt-4">
          <h2 class="text-xl font-bold mb-6 text-center">Shipping Address</h2>
          <div v-if="!address.id">
            <!-- Display Address Form if no address -->
            <form @submit.prevent="submitAddress">
              <div class="mb-4">
                <label class="block mb-2 font-bold">Address Line 1</label>
                <input v-model="addressForm.address_line_1" type="text" class="w-full p-2 border rounded" required />
              </div>
              <div class="mb-4">
                <label class="block mb-2 font-bold">Address Line 2</label>
                <input v-model="addressForm.address_line_2" type="text" class="w-full p-2 border rounded" />
              </div>
              <div class="mb-4">
                <label class="block mb-2 font-bold">City</label>
                <input v-model="addressForm.city" type="text" class="w-full p-2 border rounded" required />
              </div>
              <div class="mb-4">
                <label class="block mb-2 font-bold">State</label>
                <input v-model="addressForm.state" type="text" class="w-full p-2 border rounded" required />
              </div>
              <div class="mb-4">
                <label class="block mb-2 font-bold">Postal Code</label>
                <input v-model="addressForm.postal_code" type="text" class="w-full p-2 border rounded" required />
              </div>
              <div class="mb-4">
                <label class="block mb-2 font-bold">Phone Number</label>
                <input v-model="addressForm.phone_number" type="text" class="w-full p-2 border rounded" />
              </div>
              <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Update Address</button>
            </form>
          </div>
          <div v-else>
            <!-- Display Existing Address with Edit Option -->
            <p class="text-lg">{{ address.address_line_1 }}</p>
            <p class="text-lg">{{ address.address_line_2 }}</p>
            <p class="text-lg">{{ address.city }}, </p>
            <p class="text-lg"> {{ address.postal_code }}</p>
            <p class="text-lg">{{ address.state }}</p>
            <p class="text-lg">Phone: {{ address.phone_number }}</p>
            <button @click="editAddress" class="text-blue-500 mt-2">Edit Address</button>
          </div>
        </div>
        <div class="mt-8 ">
          <button @click="proceedToPayment" class="bg-yellow-950  hover:text-white hover:bg-yellow-950/80 text-white py-2 px-4 rounded-xl mt-8">Proceed to Payment</button>
        </div>
      </div>
      <div v-else>
        <p>Your cart is empty.</p>
      </div>
    </div>
  </AuthenticatedLayout>
</FooterLayout>
</template>

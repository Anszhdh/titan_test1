<script>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

export default {
  components: {
    AuthenticatedLayout,
  },
  props: {
    cart: Array,
    address: Object,
    totalPrice: Number,
  },
  data() {
    return {
      addressForm: {
        address_line_1: this.address ? this.address.address_line_1 : '',
        address_line_2: this.address ? this.address.address_line_2 : '',
        city: this.address ? this.address.city : '',
        state: this.address ? this.address.state : '',
        postal_code: this.address ? this.address.postal_code : '',
        phone_number: this.address ? this.address.phone_number : '',
      },
      paymentType: null,
    };
  },
  methods: {
    submitAddress() {
      Inertia.post('/checkout/address', this.addressForm, {
        onSuccess: () => {
          alert('Address updated successfully');
        },
        onError: (errors) => {
          console.error('Address update failed:', errors);
          alert('Error: Unable to update address.');
        }
      });
    },
    editAddress() {
      // Redirect or show address form for editing
      // Example: Inertia visit or redirect to edit address route
    },
    proceedToPayment() {
      if (!this.paymentType) {
        alert('Please select a payment type.');
        return;
      }

      const paymentData = {
        addressData: {
          address_line_1: this.addressForm.address_line_1,
          address_line_2: this.addressForm.address_line_2,
          city: this.addressForm.city,
          state: this.addressForm.state,
          postal_code: this.addressForm.postal_code,
          phone_number: this.addressForm.phone_number,
        },
        paymentType: this.paymentType,
        totalPrice: this.totalPrice,
        cart: this.cart.map(item => ({
          product_id: item.product.id,
          quantity: item.quantity,
          price: item.price,
        })),
      };

      Inertia.visit(route('checkout.payment'), {
        data: paymentData,
      });
    },
  },
};
</script>

<template>
  <AuthenticatedLayout>
    <div class="container mx-auto px-4">
      <h1 class="text-2xl font-bold mb-4">Checkout Summary</h1>
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
                    <p>{{ item.product.description }}</p> <!-- Optionally show description below -->
                  </div>
                </div>
              </td>
              <td class="py-4">{{ item.quantity }}</td>
              <td class="py-4">RM {{ item.price }}</td>
              <td class="py-4">RM {{ (item.price * item.quantity).toFixed(2) }}</td>
            </tr>
          </tbody>
        </table>
        <div class="mt-4">
          <p class="text-lg font-bold">Total: RM {{ totalPrice.toFixed(2) }}</p>
        </div>
        <hr class="my-4 border-gray-300">
        <!-- Address Section -->
        <div class="pt-4">
          <h2 class="text-xl font-bold mb-6">Shipping Address</h2>
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
            <p class="font-bold">{{ address.address_line_1 }}</p>
            <p>{{ address.address_line_2 }}</p>
            <p>{{ address.city }}, </p>
            <p> {{ address.postal_code }}</p>
            <p>{{ address.state }}</p>
            <p>Phone: {{ address.phone_number }}</p>
            <button @click="editAddress" class="text-blue-500 mt-2">Edit Address</button>
          </div>
        </div>
        <hr class="my-4 border-gray-300">
        <!-- Payment Method Section -->
        <div class="mt-8">
          <h2 class="text-xl font-bold mb-2">Payment Type</h2>
          <div class="mt-8">
            <label>
              <input type="radio" v-model="paymentType" value="bank_transfer"> Bank Transfer
            </label>
            <label>
              <input type="radio" v-model="paymentType" value="qr_transfer"> QR Transfer
            </label>
          </div>
          <div class="mt-8" v-if="paymentType === 'bank_transfer'">
            <!-- Bank Transfer Image -->
            <img src="/payment/banktrans.jpg" alt="Bank Transfer Details" class="w-80 h-auto">
            <p class="mt-4">**proceed to payment to upload payment proof</p>
          </div>
          <div class="mt-4" v-else-if="paymentType === 'qr_transfer'">
            <!-- QR Code Image -->
            <img src="/payment/qrcode.jpg" alt="QR Code" class="w-80 h-auto">
            <p class="mt-4">**proceed to payment to upload payment proof</p>
          </div>
          <button @click="proceedToPayment" class="bg-yellow-950 hover:text-white hover:bg-yellow-950/80 text-white py-2 px-4 rounded-xl mt-8">Proceed to Payment</button>
        </div>
      </div>
      <div v-else>
        <p>Your cart is empty.</p>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

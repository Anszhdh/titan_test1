<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { defineComponent } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const file = ref(null);
let addressData = null;

// Event handler for file upload
const handleFileUpload = (event) => {
  file.value = event.target.files[0];
};

// Function to submit payment
const submitPaymentProof = () => {
  const formData = new FormData();
  formData.append('receipt', file.value);
  formData.append('addressData', JSON.stringify(addressData));

  Inertia.post(route('checkout.submitPayment'), formData, {
    onSuccess: (page) => {
      console.log('Payment proof submitted successfully:', page);
    },
    onError: (errors) => {
      console.error('Payment proof submission error:', errors);
    },
  });
};

defineComponent({
  components: {
    AuthenticatedLayout,
  },
  setup() {
    addressData = JSON.parse(document.querySelector('meta[name="addressData"]').getAttribute('content'));

    return {
      file,
      handleFileUpload,
      submitPaymentProof,
    };
  },
});
</script>

<template>
  <AuthenticatedLayout :authenticated="true">
    <div class="container mx-auto px-4">
      <h1 class="text-2xl font-bold mb-4">Payment</h1>
      <div class="bg-white shadow-md rounded-lg p-6">
        <form @submit.prevent="submitPaymentProof">
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-6">Upload Payment Receipt</label>
            <input type="file" @change="handleFileUpload" class="mt-1 block w-full" />
          </div>
          <button type="submit" class="bg-yellow-950 hover:text-white hover:bg-yellow-950/80 text-white py-2 px-4 rounded-xl mt-4">Submit Payment</button>
        </form>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

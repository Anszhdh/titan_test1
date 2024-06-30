<template>
    <AuthenticatedLayout>
        <div class="container mx-auto px-4 py-8 bg-orange-100/5">
            <h2 class="text-center text-xl font-bold mb-2">Checkout</h2>
            <form @submit.prevent="processCheckout" enctype="multipart/form-data">
                <div class="mb-4">
                    <label for="payment_method" class="block text-gray-700">Payment Method:</label>
                    <select v-model="paymentMethod" id="payment_method" name="payment_method" class="form-select mt-1 block w-full">
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="qr_code">QR_code</option>
                        <!-- Add other payment methods if needed -->
                    </select>
                </div>
                <div class="mb-4">
                    <label for="payment_file" class="block text-gray-700">Upload Payment Proof:</label>
                    <input type="file" id="payment_file" name="payment_file" @change="handleFileUpload" class="form-input mt-1 block w-full" />
                </div>
                <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded-xl hover:bg-orange-600">
                    Complete Payment
                </button>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const paymentMethod = ref('');
const paymentFile = ref(null);

const handleFileUpload = (event) => {
    paymentFile.value = event.target.files[0];
};

const processCheckout = () => {
    const formData = new FormData();
    formData.append('payment_method', paymentMethod.value);
    formData.append('payment_file', paymentFile.value);

    Inertia.post('/subscription-checkout', formData, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    });
};
</script>

<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import FooterLayout from '@/Layouts/FooterLayout.vue';


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

<template>
    <FooterLayout>
    <AuthenticatedLayout>
        <div class="flex  justify-center min-h-screen">
            <div class="w-full max-w-5xl px-6 py-8 bg-orange-100/5 rounded-lg shadow-lg">
                <h2 class="text-center text-xl font-bold mb-4">Make Payment</h2>
                <form @submit.prevent="processCheckout" enctype="multipart/form-data">
                    <div class="mb-6 mt-6 text-center justify-center ">
                        <label for="payment_method" class="block  text-gray-700 mb-6">Payment Method:</label>
                        <div class="flex items-center justify-center mb-4">
                            <label class="mr-4">
                                <input type="radio" v-model="paymentMethod" value="bank_transfer" class="mr-1"> Bank Transfer
                            </label>
                            <label>
                                <input type="radio" v-model="paymentMethod" value="qr_code" class="mr-1"> QR Transfer
                            </label>
                        </div>
                    </div>
                    <div v-if="paymentMethod === 'bank_transfer' || paymentMethod === 'qr_code'" class="text-center mb-4">
                        <img v-if="paymentMethod === 'bank_transfer'" src="/payment/banktrans.jpg" alt="Bank Transfer Details" class="w-80 h-auto mx-auto">
                        <img v-if="paymentMethod === 'qr_code'" src="/payment/qrcode.jpg" alt="QR Code" class="w-80 h-auto mx-auto">
                    </div>
                    <div class="mb-4 text-center">
                        <label for="payment_file" class="block text-gray-700 mb-2">Upload Payment Proof:</label>
                        <input type="file" id="payment_file" name="payment_file" @change="handleFileUpload" class="form-input mt-1 w-40px mx-auto" />
                    </div>
                    <button type="submit" class="bg-yellow-950 text-white py-2 px-4 rounded-xl mt-6 hover:bg-yellow-950/50 block mx-auto">
                        Complete Payment
                    </button>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</FooterLayout>
</template>





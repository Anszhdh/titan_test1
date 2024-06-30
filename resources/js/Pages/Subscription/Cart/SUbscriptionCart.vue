<template>
    <AuthenticatedLayout>
        <div class="container mx-auto px-4 py-8">
            <div class="flex flex-col md:flex-row">
                <div class="w-full md:w-1/3 bg-white p-6 shadow-md rounded-lg">
                    <h2 class="text-2xl font-bold mb-4 text-center">Order Summary</h2>
                    <img :src="productDetails.image_url" alt="Product" class="w-full mb-4 mx-auto" />
                    <div class="flex justify-around items-center my-4">
                        <div class="flex flex-col  items-center">
                            <svg class="w-8 h-8 text-gray-600 mb-1" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zM11 17.414l-4.707-4.707 1.414-1.414L11 14.586l7.293-7.293 1.414 1.414L11 17.414z"></path></svg>
                            <span class="text-sm ml-10">PERSONALIZED SELECTIONS</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <svg class="w-8 h-8 text-gray-600 mb-1" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M20 12H4c-1.103 0-2-.897-2-2V4c0-1.103.897-2 2-2h16c1.103 0 2 .897 2 2v6c0 1.103-.897 2-2 2zM4 4v6h16.002L20 4H4zM20 14h-4v2h2v4H6v-4h2v-2H4v6h16v-6z"></path></svg>
                            <span class="text-sm">SHIPPED FOR YOU</span>
                        </div>
                    </div>
                    <div class="flex justify-between items-center my-2">
                        <span class="font-bold">Coffee Plan</span>
                        <span>{{ productDetails.frequency }}</span>
                    </div>
                    <div class="flex justify-between items-center my-2">
                        <span class="font-bold">Coffee Price</span>
                        <span>RM {{ productDetails.original_price }}</span>
                    </div>
                    <div class="flex justify-between items-center my-2">
                        <span class="font-bold">Shipping</span>
                        <span>RM {{ productDetails.shipping_cost }}</span>
                    </div>
                    <div class="flex justify-between items-center my-2">
                        <span class="font-bold">Total Price</span>
                        <span>RM {{ productDetails.total_cost }}</span>
                    </div>
                   
                </div>

                <div class="w-full md:w-2/3 bg-white p-4 shadow-md rounded-lg">
                    <div class="flex items-center justify mb-12">
                        <p class="font-bold">Frequency</p>
                        <div class="flex items-center text-white rounded-xl ml-10 bg-yellow-950/70 p-2">
                            <span>{{ productDetails.frequency }}</span>
                        </div>
                    </div>
                    <div class="mb-6 text-center">
                        <h3 class="font-bold text-lg mb-8">Shipping Information</h3>
                        <div v-if="customerAddress" class="text-left text-lg">
                            <p>{{ customerAddress.address_line_1 }}</p>
                            <p>{{ customerAddress.address_line_2 }}</p>
                            <p>{{ customerAddress.city}}, {{ customerAddress.postal_code}}</p>
                            <p>{{ customerAddress.state}}</p>
                            <p>{{ customerAddress.phone_number }}</p>
                        </div>
                        <div v-else>
                            <p>No address found. Please add your shipping information.</p>
                        </div>
                    </div>
                    <div v-if="productDetails" class="mb-10">
                        <h3 class="font-bold mb-1">{{ productDetails.name }}</h3>
                        <p>Price: RM {{ productDetails.price.toFixed(2) }} (exc shipping)</p>
                    </div>
                    <div class="text-right">
                        <button @click="goToCheckout" class="bg-yellow-950 text-white py-2 px-4 rounded-xl mr-6 mt-20 hover:bg-yellow-950/50">
                            Checkout Now
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { usePage} from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';


const { props } = usePage();
const productDetails = ref(props.value.productDetails);
const customerAddress = ref(props.value.customerAddress);

const goToCheckout = () => {
    Inertia.visit('/subscription-checkout', {
        data: {
            productId: productDetails.value.id,
            recommendationId: productDetails.value.recommendation_id
        }
    });
};

</script>

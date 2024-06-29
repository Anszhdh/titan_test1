<template>
    <AuthenticatedLayout>
        <div class="container mx-auto px-4 py-8 bg-orange-100/5">
            <h2 class="text-center text-xl font-bold mb-2">Your Coffee Recommendation</h2>
            <div v-for="(recommendation, index) in recommendations" :key="recommendation.product_id" class="text-center mb-8">
                <h3 class="text-xl font-bold mb-2">{{ recommendation.name }}</h3>
                <p>{{ recommendation.description }}</p>
                <div v-if="products[index]" class="bg-white shadow-md rounded-lg p-4">
                    <!-- <p class="text-lg font-semibold mb-2">{{ products[index].name }}</p> -->
                    <p class="text-lg mb-4">Price: RM {{ products[index].price }}</p>
                    <div class="flex justify-center mb-4">
                        <img :src="products[index].image_url" alt="Product Image" class="h-54 w-54 object-cover rounded-md border-2 border-gray-200" />
                    </div>
                    <button @click="subscribe(recommendation.product_id)" class="bg-red-500 text-white py-2 px-4 rounded hover:bg-orange-600">
                            Subscribe Now
                    </button>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const { props } = usePage();
const recommendations = ref(props.value.recommendations);
const products = ref(props.value.products);

const subscribe = (productId) => {
    Inertia.post('/subscription-cart/add', { product_id: productId }, {
        onSuccess: () => {
            Inertia.visit('/subscription-cart');
        }
    });
};
</script>

<style scoped>
/* Add your styles here */
</style>

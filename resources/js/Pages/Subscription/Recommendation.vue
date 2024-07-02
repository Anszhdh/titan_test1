<script setup>
import { ref } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import FooterLayout from '@/Layouts/FooterLayout.vue';


const { props } = usePage();
const recommendations = ref(props.value.recommendations);
const products = ref(props.value.products);
const selectedFrequency = ref(null);

const subscribe = (product, recommendation) => {
    if (selectedFrequency.value) {
        Inertia.post('/subscription-cart/add', {
            product_id: product.id,
            name: product.name,
            price: product.price,
            frequency: selectedFrequency.value,
            image_url: product.image_url,
            recommendation_id: recommendation.recommendation_id
        }, {
            onSuccess: () => {
                Inertia.visit('/subscription-cart');
            }
        });
    }
};
</script>

<template>
    <FooterLayout>
    <AuthenticatedLayout>
        <div class="container mx-auto px-4 py-8 bg-orange-100/5">
            <h2 class="text-center text-xl font-bold mb-2">Your Coffee Recommendation</h2>
            <div v-for="(recommendation, index) in recommendations" :key="recommendation.product_id" class="text-center mb-8">
                <h3 class="text-xl font-bold mb-2">{{ recommendation.name }}</h3>
                <p>{{ recommendation.description }}</p>
                <div v-if="products[index]" class="bg-white shadow-md rounded-lg p-4">
                    <p class="text-lg mb-4">Price: RM {{ products[index].price }}</p>
                    <div class="flex justify-center mb-4">
                        <img :src="products[index].image_url" alt="Product Image" class="h-80 w-80 object-cover rounded-md border-2 border-gray-200" />
                    </div>
                    <div class="flex justify-center mb-4">
                        <button
                            v-for="frequency in ['Weekly', 'Bi-Weekly', 'Monthly']"
                            :key="frequency"
                            :class="{'bg-brown-500 text-white': selectedFrequency === frequency, 'bg-yellow-950 text-white hover:bg-yellow-950/40': selectedFrequency !== frequency}"
                            class="px-4 py-2 mx-2 mt-4 bg-gray-200 mb-4 rounded-xl"
                            @click="selectedFrequency = frequency"
                        >
                            {{ frequency }}
                        </button>
                    </div>
                    <button @click="subscribe(products[index], recommendation)" class="bg-red-500 text-white py-2 px-4 rounded-xl hover:bg-orange-600">
                        Subscribe Now
                    </button>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
    </FooterLayout>
</template>

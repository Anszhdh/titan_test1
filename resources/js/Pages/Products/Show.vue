<!-- resources/js/Pages/Products/ProductDetails.vue -->

<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import FooterLayout from '@/Layouts/FooterLayout.vue';

const props = defineProps({
    product: Object,
});

function addToCart(productId) {
    Inertia.post('/cart/add', { id: productId })
        .then(() => {
            alert('Added to cart successfully');
        })
        .catch(error => {
            console.error('Error adding item to cart:', error);
            alert('Error: Unable to add to cart. Please try again later.');
        });
}
</script>

<template>
    <FooterLayout>
        <AuthenticatedLayout>
            <Head title="Product Details" />
            <div class="container mx-auto mt-20 px-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="border-2 border-gray-200 rounded-md w-full h-96 bg-orange p-4">
                        <img :src="product.image" :alt="product.name" class="w-full h-full object-contain">
                    </div>
                    <div class="ml-12">
                        <h1 class="text-3xl font-bold">{{ product.name }}</h1>
                        <p class="mt-4">{{ product.description }}</p>
                        <p class="text-2xl font-semibold mt-2">RM {{ product.price }}</p>
                        <button class="mt-4 bg-yellow-950 text-white ring-1 ring-transparent transition hover:text-white hover:bg-yellow-900 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white dark:hover:bg-yellow-950/20 py-2 px-4 rounded-xl" @click="addToCart(product.id)">Add to Cart</button>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </FooterLayout>
</template>

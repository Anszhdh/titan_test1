<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import FooterLayout from '@/Layouts/FooterLayout.vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    products: Array,
    authenticated: Boolean,
    userRole: Number // Ensure userRole is included here
});

async function addToCart(productId) {
    if (!props.authenticated) {
        alert('You need to login first!');
        Inertia.visit('/login');
        return;
    }
    
    try {
        await Inertia.post('/cart/add', { id: productId });
        alert('Added to cart successfully');
    } catch (error) {
        console.error('Error adding item to cart:', error);
        alert('Error: Unable to add to cart. Please try again later.');
    }
}
</script>

<template>
    <Head title="Products" />
    <FooterLayout>
        <AuthenticatedLayout :authenticated="authenticated">
            <div class="bg-black min-h-screen">
                <div class="container mx-auto px-4">
                    <div class="grid grid-cols-4 gap-4">
                        <div v-for="product in products" :key="product.id" class="border rounded shadow p-4 mb-20 mt-20 bg-orange-600">
                            <div class="w-full h-48">
                                <a :href="`/products/${product.id}`" target="_blank">
                                    <img :src="product.image" :alt="product.name" class="w-full h-full object-contain">
                                </a>
                            </div>
                            <h2 class="text-xl font-bold mt-2 text-white">
                                <a :href="`/products/${product.id}`" target="_blank">{{ product.name }}</a>
                            </h2>
                            <p>{{ product.description }}</p>
                            <p class="text-lg font-semibold">
                                RM {{ props.userRole === 2 ? product.dealer_price : product.price }}
                            </p>
                            <button class="mt-2 bg-black text-white ring-1 ring-transparent transition hover:text-white hover:bg-orange-600/50 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white dark:hover:bg-yellow-950/20 py-2 px-4 rounded-xl" @click="addToCart(product.id)">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                    <div v-if="!authenticated" class="mt-4">
                        <a href="/login" class="text-blue-500">Login</a>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </FooterLayout>
</template>

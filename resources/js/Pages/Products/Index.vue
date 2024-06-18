<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Inertia } from '@inertiajs/inertia';


const props = defineProps({
    products: Array,
    authenticated: Boolean
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
    <AuthenticatedLayout :authenticated="authenticated">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-4 gap-4">
                <div v-for="product in products" :key="product.id" class="border rounded shadow p-4">
                    <div class="w-full h-48 bg-white">
                        <img :src="product.image" :alt="product.name" class="w-full h-full object-contain">
                    </div>
                    <h2 class="text-xl font-bold mt-2">{{ product.name }}</h2>
                    <p>{{ product.description }}</p>
                    <p class="text-lg font-semibold">RM {{ product.price }}</p>
                    <button class="mt-2 bg-yellow-950 text-white ring-1 ring-transparent transition hover:text-yellow-900/70 hover:bg-yellow-900 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-yellow-950/80 dark:hover:bg-yellow-950/20 py-2 px-4 rounded-xl" @click="addToCart(product.id)">Add to Cart</button>
                </div>
            </div>
            <div v-if="!authenticated" class="mt-4">
                <Link href="/login" class="text-blue-500">Login</Link>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import FooterLayout from '@/Layouts/FooterLayout.vue';
import { Inertia } from '@inertiajs/inertia';
import { ref, defineProps } from 'vue';

const props = defineProps({
    product: Object,
    userRole: Number // Add userRole here
});

// Add to Cart function remains unchanged
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

// Date formatting function remains unchanged
function formatDate(dateString) {
    const options = { day: '2-digit', month: '2-digit', year: 'numeric' };
    return new Date(dateString).toLocaleDateString('en-GB', options).replace(/\//g, '-');
}

const showDetails = ref(false);

function toggleDetails() {
    showDetails.value = !showDetails.value;
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
                        <p class="text-2xl font-semibold mt-2">
                            RM {{ props.userRole === 2 ? product.dealer_price : product.price }} <!-- Display price based on role -->
                        </p>
                        <button class="mt-4 bg-black text-white ring-1 ring-transparent transition hover:text-white hover:bg-orange-600/50 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white dark:hover:bg-yellow-950/20 py-2 px-4 rounded-xl" @click="addToCart(product.id)">Add to Cart</button>
                        <p class="mt-6 flex items-center">
                            <img src="/delivery.png" alt="Delivery Icon" class="w-6 h-6 mr-4" />
                            Delivery within 3 - 5 working days (WM)
                        </p>
                        <p class="mt-2 flex items-center">
                            <img src="/return.png" alt="Delivery Icon" class="w-6 h-6 mr-4" />
                            21-Day Warranty Policy
                        </p>
                        <div class="mt-5">
                            <hr class="mb-5">
                            <button @click="toggleDetails" class="text-gray-800 rounded-md flex items-center">
                                <span class="mr-4 text-xl font-bold">Product Details</span>
                                <svg :class="{'transform rotate-180': showDetails}" class="ml-80  h-5 w-5 transition-transform duration-200 bg-yellow-950/10 rounded-xl hover:bg-yellow-950/50" fill="none" viewBox="0 0 24 24" stroke="currentColor ">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div v-if="showDetails" class="mt-4 ">
                                <ul class="mt-2">
                                    <li class="text-lg"><span class="font-bold">Adjustable:</span> {{ product.decaf === 1 ? 'Yes' : 'No' }}</li>
                                    <li class="text-lg"><span class="font-bold">Warranty:</span> {{ product.pre_ground === 1 ? 'Yes' : 'No' }}</li>
                                </ul>
                            </div>
                            <hr class="mt-5">
                        </div>
                    </div>
                </div>
                <div class="mt-12">
                    <h2 class="text-2xl font-bold mb-4">Reviews</h2>
                    <div v-if="product.reviews.length">
                        <div v-for="review in product.reviews" :key="review.id" class="mt-4 border-b border-gray-200 pb-4">
                            <div class="flex items-center">
                                <div>
                                    <h3 class="text-lg font-semibold">{{ review.user.name }}</h3>
                                    <p class="text-sm text-gray-500">{{ formatDate(review.created_at) }}</p>
                                </div>
                            </div>
                            <div class="mt-2 mb-10">
                                <p class="text-lg">{{ review.review }}</p>
                                <div class="flex items-center mt-2">
                                    <span class="text-yellow-500" v-for="i in review.rating" :key="i">★</span>
                                    <span class="text-gray-400" v-for="i in 5 - review.rating" :key="i">★</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-20" v-else>
                        <p>No reviews yet. Be the first to review this product!</p>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </FooterLayout>
</template>

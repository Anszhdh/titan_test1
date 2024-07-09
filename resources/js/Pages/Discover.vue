<template>
     <template v-if="isLoggedIn">
    <FooterLayout>
    <AuthenticatedLayout>
    <div class="container mx-auto p-8">
        <h1 class="text-4xl font-bold mb-6">Discover Brewbox</h1>
        <p class="text-lg mb-4">
            Dive into the world of personalized subscriptions with Brewbox. Discover new and exciting products curated just for you.
        </p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-semibold mb-4">Curated Coffees</h2>
                <p class="text-gray-700">Explore our selection of freshly roasted coffees from around the world, tailored to your taste preferences.</p>
                <!-- <img src="/images/coffee.jpg" alt="Curated Coffees" class="mt-4 rounded"> -->
            </div>
            
            <div class="bg-white rounded-lg shadow-md ml-10 p-6">
                <h2 class="text-2xl font-semibold mb-4">Exclusive Coffee</h2>
                <p class="text-gray-700">Discover our range of exclusive coffee, handpicked for their unique flavors and aromas.</p>
                <!-- <img src="/images/tea.jpg" alt="Exclusive Teas" class="mt-4 rounded"> -->
            </div>
            
            <!-- <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-semibold mb-4">Gourmet Snacks</h2>
                <p class="text-gray-700">Treat yourself to our gourmet snacks, carefully selected to complement your favorite beverages.</p>
                <img src="/images/snacks.jpg" alt="Gourmet Snacks" class="mt-4 rounded">
            </div> -->
        </div>
    </div>
</AuthenticatedLayout>
</FooterLayout>
</template>
<template v-else>
<FooterLayout>
    <GuestLayout>
        <div class="container mx-auto p-8 mt">
        <h1 class="text-4xl font-bold mb-6">Discover Brewbox</h1>
        <p class="text-lg mb-4">
            Dive into the world of personalized subscriptions with Brewbox. Discover new and exciting products curated just for you.
        </p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-semibold mb-4">Curated Coffees</h2>
                <p class="text-gray-700">Explore our selection of freshly roasted coffees from around the world, tailored to your taste preferences.</p>
                <!-- <img src="/images/coffee.jpg" alt="Curated Coffees" class="mt-4 rounded"> -->
            </div>
            
            <div class="bg-white rounded-lg shadow-md ml-10 p-6">
                <h2 class="text-2xl font-semibold mb-4">Exclusive Coffee</h2>
                <p class="text-gray-700">Discover our range of exclusive coffee, handpicked for their unique flavors and aromas.</p>
                <!-- <img src="/images/tea.jpg" alt="Exclusive Teas" class="mt-4 rounded"> -->
            </div>
            
            <!-- <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-semibold mb-4">Gourmet Snacks</h2>
                <p class="text-gray-700">Treat yourself to our gourmet snacks, carefully selected to complement your favorite beverages.</p>
                <img src="/images/snacks.jpg" alt="Gourmet Snacks" class="mt-4 rounded">
            </div> -->
        </div>
      </div>
    </GuestLayout>
    </FooterLayout>
  </template>
</template>

<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import FooterLayout from '@/Layouts/FooterLayout.vue';


</script>

<style scoped>
.container {
    max-width: 1200px;
}
</style>

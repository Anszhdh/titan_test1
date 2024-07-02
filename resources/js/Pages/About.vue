<template>
    <FooterLayout>
    <AuthenticatedLayout>
    <div class="container mx-auto p-8">
        <h1 class="text-4xl font-bold mb-6">About Brewbox</h1>
        <p class="text-lg mb-4">
            Welcome to Brewbox, your personalized subscription service for all things brewing. At Brewbox, we believe that every brew should be unique and tailored to your tastes. Our mission is to bring you the finest and most personalized brewing experience right to your doorstep.
        </p>
        <h2 class="text-2xl font-semibold mb-4">Our Story</h2>
        <p class="text-lg mb-4">
            Brewbox was founded with a passion for brewing and a desire to share that passion with others. We started our journey in 2023 with a simple goal: to make high-quality, personalized brewing accessible to everyone. Since then, we have grown into a community of brew enthusiasts who are committed to exploring and celebrating the art of brewing.
        </p>
        <h2 class="text-2xl font-semibold mb-4">What We Offer</h2>
        <ul class="list-disc pl-5 mb-4">
            <li class="text-lg mb-2">Customized Subscription Plans: Choose your preferences and let us curate the perfect brew selection for you.</li>
            <li class="text-lg mb-2">High-Quality Ingredients: We source only the best ingredients to ensure your brews are top-notch.</li>
            <li class="text-lg mb-2">Expert Guidance: Our team of brew experts is here to help you every step of the way.</li>
        </ul>
        <h2 class="text-2xl font-semibold mb-4">Join Our Community</h2>
        <p class="text-lg mb-4">
            Become a part of the Brewbox community and discover the joys of personalized brewing. Whether you're a seasoned brewer or just starting out, we have something for everyone. Join us and start your brewing adventure today!
        </p>
    </div>
</AuthenticatedLayout>
</FooterLayout>
</template>

<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import FooterLayout from '@/Layouts/FooterLayout.vue';

</script>

<style scoped>
.container {
    max-width: 800px;
}
</style>

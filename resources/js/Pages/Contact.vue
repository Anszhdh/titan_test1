<template>
    <FooterLayout>
    <AuthenticatedLayout>
    <div class="container mx-auto p-8">
        <h1 class="text-4xl font-bold mb-6 text-yellow-950">Contact Us</h1>
        <p class="text-lg mb-4">
            We would love to hear from you! Whether you have a question, feedback, or need assistance, feel free to reach out to us. 
        </p>
        <form @submit.prevent="submitForm" class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                <input type="text" id="name" v-model="form.name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" id="email" v-model="form.email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label for="message" class="block text-gray-700 text-sm font-bold mb-2">Message</label>
                <textarea id="message" v-model="form.message" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" rows="5" required></textarea>
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-yellow-950 hover:bg-yellow-950/80 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Send</button>
            </div>
        </form>
    </div>
</AuthenticatedLayout>
</FooterLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import FooterLayout from '@/Layouts/FooterLayout.vue';

const form = ref({
    name: '',
    email: '',
    message: ''
});

const submitForm = async () => {
    try {
        // Here you would typically send the form data to your server
        console.log('Form submitted:', form.value);
        alert('Thank you for contacting us! We will get back to you soon.');
        form.value = {
            name: '',
            email: '',
            message: ''
        };
    } catch (error) {
        console.error('Error submitting form:', error);
    }
};
</script>

<style scoped>
.container {
    max-width: 800px;
}
</style>

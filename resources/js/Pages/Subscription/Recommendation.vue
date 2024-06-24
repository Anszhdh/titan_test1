<script setup>
import { defineProps } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';


const props = defineProps({
    recommendations: Array
});
</script>

<template>
    <AuthenticatedLayout>
    <div class="container mx-auto px-4 py-8">
        <h2 class="text-center text-2xl font-bold mb-4">Your Coffee Recommendations</h2>
        <div class="grid grid-cols-2 gap-4">
            <div v-for="recommendation in recommendations" :key="recommendation.name" class="border rounded shadow p-4">
                <h3 class="text-xl font-bold">{{ recommendation.name }}</h3>
                <p>{{ recommendation.description }}</p>
            </div>
        </div>
    </div>
</AuthenticatedLayout>
</template>

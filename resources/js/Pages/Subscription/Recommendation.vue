<template>
    <AuthenticatedLayout>
        <div class="container mx-auto px-4 py-8 bg-orange-100/5">
            <h2 class="text-center text-2xl font-bold mb-4">Your Coffee Recommendation</h2>
            <div v-for="recommendation in recommendations" :key="recommendation.product_id" class="text-center">
                <h3 class="text-xl font-bold mb-2">{{ recommendation.name }}</h3>
                <p>{{ recommendation.description }}</p>
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
</script>

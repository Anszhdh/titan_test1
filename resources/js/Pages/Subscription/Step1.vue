<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const selectedOptions = ref([]);
const options = [
    { id: 1, label: 'Nutty Flavor', image: '/substep/step1/nutty.jpg' },
    { id: 2, label: 'Fruity Flavor', image: '/substep/step1/fruity.jpg' },
    { id: 3, label: 'Chocolatey Flavor', image: '/substep/step1/choc.jpg' },
    { id: 4, label: 'Spicy Flavor', image: '/substep/step1/spicy.jpeg' },
    { id: 5, label: 'Others', image: '/substep/step1/others.png' }
];

function toggleOption(optionId) {
    if (selectedOptions.value.includes(optionId)) {
        selectedOptions.value = selectedOptions.value.filter(id => id !== optionId);
    } else {
        selectedOptions.value.push(optionId);
    }
}

function nextStep() {
    Inertia.post('/subscription/step2', { step1: selectedOptions.value });
}
</script>

<template>
    <AuthenticatedLayout>
        <div class="container mx-auto px-4 py-8 bg-orange-100/5">
            <h2 class="text-center text-2xl font-bold mb-4">Do you prefer your coffee to have a:</h2>
            <div class="grid grid-cols-4 gap-4">
                <div v-for="option in options" :key="option.id" class="text-center">
                    <div 
                        @click="toggleOption(option.id)" 
                        :class="{'border-2 border-brown-500': selectedOptions.includes(option.id)}" 
                        class="cursor-pointer p-4 border rounded-lg"
                    >
                        <img :src="option.image" :alt="option.label" class="mx-auto w-34 h-24 object-cover rounded-xl mb-2 center">
                        <p>{{ option.label }}</p>
                    </div>
                </div>
            </div>
            <div class="text-center mt-8">
                <button @click="nextStep" class="bg-brown-500 text-white py-2 px-4 rounded">Next</button>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.border-brown-500 {
    border-color: #8B4513; /* Replace with your brown color code */
}
.bg-brown-500 {
    background-color: #5a2d0d; /* Replace with your brown color code */
}
</style>

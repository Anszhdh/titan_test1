<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';


const selectedOptions = ref([]);
const options = [
    { id: 13, label: 'Drip Coffee Maker', image: '/substep/step4/drip.png' },
    { id: 14, label: 'French Press', image: '/substep/step4/french.png' },
    { id: 15, label: 'Espresso Machine', image: '/substep/step4/espresso.png' },
    { id: 16, label: 'Pour Over', image: '/substep/step4/pour.png' }
];

function toggleOption(optionId) {
    if (selectedOptions.value.includes(optionId)) {
        selectedOptions.value = selectedOptions.value.filter(id => id !== optionId);
    } else {
        selectedOptions.value.push(optionId);
    }
}

function nextStep() {
    Inertia.post('/subscription/step5', { step4: selectedOptions.value });
}
</script>

<template>
    <AuthenticatedLayout>
    <div class="container mx-auto px-4 py-8 bg-orange-100/5">
        <h2 class="text-center text-2xl font-bold mb-4">What is your preferred brewing method?</h2>
        <p class="text-center text-gray-500 mb-8">You can select more than one option</p>
        <div class="grid grid-cols-4 gap-4">
            <div v-for="option in options" :key="option.id" class="text-center">
                <div 
                    @click="toggleOption(option.id)" 
                    :class="{'border-2 border-brown-500': selectedOptions.includes(option.id)}" 
                    class="cursor-pointer p-4 border rounded-lg"
                >
                    <img :src="option.image" :alt="option.label" class="mx-auto w-34 h-24 object-cover rounded-full mb-2 center">
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

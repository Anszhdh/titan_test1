<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import FooterLayout from '@/Layouts/FooterLayout.vue';


const selectedOptions = ref([]);
const options = [
    { id: 10, label: 'Drip Coffee Maker', image: '/substep/step3/drip.png' },
    { id: 11, label: 'French Press', image: '/substep/step3/french.png' },
    { id: 12, label: 'Espresso Machine', image: '/substep/step3/espresso.jpeg' },
    { id: 13, label: 'Pour Over', image: '/substep/step3/pour.png' },
    { id: 14, label: 'Aeropress', image: '/substep/step3/aeropress.jpeg' },
    { id: 15, label: 'Cold Brew Maker', image: '/substep/step3/coldbrew.jpg' }
];

function toggleOption(optionId) {
    if (selectedOptions.value.includes(optionId)) {
        selectedOptions.value = selectedOptions.value.filter(id => id !== optionId);
    } else {
        selectedOptions.value.push(optionId);
    }
}

function nextStep() {
    Inertia.post('/subscription/step4', { step3: selectedOptions.value });
}
</script>

<template>
    <FooterLayout>
    <AuthenticatedLayout>
        <div class="container mx-auto px-4 py-8 bg-orange-100/5">
            <h2 class="text-center text-2xl font-bold mb-4">What brewing method do you prefer?</h2>
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
</FooterLayout>
</template>

<style scoped>
.border-brown-500 {
    border-color: #8B4513; /* Replace with your brown color code */
}
.bg-brown-500 {
    background-color: #5a2d0d; /* Replace with your brown color code */
}
</style>

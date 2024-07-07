<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import FooterLayout from '@/Layouts/FooterLayout.vue';

const selectedOption = ref(null);
const options = [
    { id: 16, label: 'Yes', value: true, image: '/substep/step4/yes.jpg' },
    { id: 17, label: 'No', value: false, image: '/substep/step4/no.jpeg' }
];

function toggleOption(option) {
    selectedOption.value = option.value;
}

function nextStep() {
    Inertia.post('/subscription/step5', { step4: selectedOption.value });
}
</script>

<template>
    <FooterLayout>
    <AuthenticatedLayout>
        <div class="container mx-auto px-4 py-8 bg-orange-100/5">
            <h2 class="text-center text-2xl font-bold mb-4">Do you want your coffee pre-ground?</h2>
            <div class="grid grid-cols-2 gap-4">
                <div v-for="option in options" :key="option.id" class="text-center">
                    <div 
                        @click="toggleOption(option)" 
                        :class="{'border-2 border-brown-500': selectedOption === option.value}" 
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

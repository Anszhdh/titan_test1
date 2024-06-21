<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';


const selectedOptions = ref([]);
const options = [
    { id: 17, label: 'Whole beans', image: '/substep/step6/whole.png' },
    { id: 18, label: 'Coarse grind (for French press)', image: '/substep/step6/coarse.png' },
    { id: 19, label: 'Medium grind (for drip coffee makers)', image: '/substep/step6/medium.png' },
    { id: 20, label: 'Fine grind (for espresso)', image: '/substep/step6/fine.png' }
];

function toggleOption(optionId) {
    if (selectedOptions.value.includes(optionId)) {
        selectedOptions.value = selectedOptions.value.filter(id => id !== optionId);
    } else {
        selectedOptions.value.push(optionId);
    }
}

function nextStep() {
    Inertia.post('/subscription/recommendation', { step6: selectedOptions.value });
}
</script>

<template>
    <AuthenticatedLayout>
    <div class="container mx-auto px-4 py-8 bg-orange-100/5">
        <h2 class="text-center text-2xl font-bold mb-4">How do you prefer your coffee to be ground?</h2>
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

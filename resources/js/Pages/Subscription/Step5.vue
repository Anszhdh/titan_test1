<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import LoadingScreen from '@/Components/Loading.vue'; // Import the loading screen component

const selectedOptions = ref([]);
const options = [
    { id: 18, label: 'Whole Beans', image: '/substep/step5/whole.jpg' },
    { id: 19, label: 'Coarse Grind', image: '/substep/step5/coarse.jpg' },
    { id: 20, label: 'Medium Grind', image: '/substep/step5/medium.jpg' },
    { id: 21, label: 'Fine Grind', image: '/substep/step5/fine.jpg' }
];

const loading = ref(false);

function toggleOption(optionId) {
    if (selectedOptions.value.includes(optionId)) {
        selectedOptions.value = selectedOptions.value.filter(id => id !== optionId);
    } else {
        selectedOptions.value.push(optionId);
    }
}

function nextStep() {
    loading.value = true;
    setTimeout(() => {
        Inertia.post('/subscription/recommendation', { step5: selectedOptions.value }, {
            onFinish: () => {
                loading.value = false;
            }
        });
    }, 3000);  // 3 seconds delay
}
</script>

<template>
    <AuthenticatedLayout>
        <div v-if="loading">
            <LoadingScreen />
        </div>
        <div v-else class="container mx-auto px-4 py-8 bg-orange-100/5">
            <h2 class="text-center text-2xl font-bold mb-4">How do you prefer your coffee to be ground?</h2>
            <div class="grid grid-cols-4 gap-4">
                <div v-for="option in options" :key="option.id" class="text-center">
                    <div 
                        @click="toggleOption(option.id)" 
                        :class="{'border-2 border-brown-500': selectedOptions.includes(option.id)}" 
                        class="cursor-pointer p-4 border rounded-lg"
                    >
                        <img :src="option.image" :alt="option.label" class="mx-auto w-34 h-24  object-cover rounded-xl mb-2 center">
                        <p>{{ option.label }}</p>
                    </div>
                </div>
            </div>
            <div class="text-center mt-8">
                <button @click="nextStep" class="bg-brown-500 text-white py-2 px-4 rounded">
                    Next
                </button>
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

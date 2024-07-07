<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import LoadingScreen from '@/Components/Loading.vue';
import FooterLayout from '@/Layouts/FooterLayout.vue';

const selectedOption = ref(null); 
const options = [
    { id: 18, label: 'Yes', value: true, image: '/substep/step5/yes.jpg' },
    { id: 19, label: 'No', value: false, image: '/substep/step5/no.jpg' }
];

const loading = ref(false);

function toggleOption(option) {
    selectedOption.value = option.value;
}

function nextStep() {
    loading.value = true;
    setTimeout(() => {
        Inertia.post('/subscription/recommendation', { step5: selectedOption.value }, {
            onFinish: () => {
                loading.value = false;
            }
        });
    }, 3000);  // 3 seconds delay
}
</script>

<template>
    <FooterLayout>
    <AuthenticatedLayout>
        <div v-if="loading">
            <LoadingScreen />
        </div>
        <div class="container mx-auto px-4 py-8 bg-orange-100/5">
            <h2 class="text-center text-2xl font-bold mb-4">Do you want to try a decaf option?</h2>
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
                <button @click="nextStep" class="bg-brown-500 text-white py-2 px-4 rounded">Get Recommendations</button>
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

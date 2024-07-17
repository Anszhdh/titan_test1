<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/inertia-vue3';
import FooterLayout from '@/Layouts/FooterLayout.vue';


const { props } = usePage();
const errorMessage = props.error || ''; // Initialize errorMessage with props.error or empty string

const isDisabled = errorMessage !== '';
</script>

<template>
    <Head title="Start Subscription" />
    <FooterLayout>
    <AuthenticatedLayout>
        <div class="min-h-screen bg-[#fffffe] flex flex-col items-center py-12">
            <div class="max-w-4xl w-full bg-white shadow-lg rounded-lg p-8">
                <h2 class="text-3xl font-bold mb-6 text-center text-yellow-950">Coffee Subscription</h2>
                <p class="text-center mb-6 text-gray-500">Experienced freshly roasted coffee delivered to your door</p>
                <h3 class="text-2xl font-semibold mb-6 text-center text-yellow-950">How does it work?</h3>
                <div class="space-y-12">
                    <div class="flex items-center space-x-4">
                        <img src="/subsmain/subs1.jpg" alt="Choose Your Coffee Preferences" class="w-48 h-48 object-cover rounded-lg">
                        <img src="/subsmain/option.png" alt="optionimage" class="w-12 h-12 ">
                        <div class="flex-1">
                            <h4 class="text-xl font-semibold text-yellow-950">Choose Your Coffee Preferences</h4>
                            <p class="text-gray-500">Choose your coffee preferences and we generate personalized recommendations which are right for you!</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-6">
                        <img src="/subsmain/calendar.png" alt="optionimage" class="w-10 h-10 ">
                        <div class="flex-1">
                            <h4 class="text-xl font-semibold text-yellow-950">Select Subscription Frequency</h4>
                            <p class="text-gray-500">Select your preferred subscription frequency: weekly, monthly, or yearly. Pause and end anytime.</p>
                        </div>
                        <img src="/subsmain/subs2.jpg" alt="Select Subscription Frequency" class="w-48 h-48 object-cover rounded-lg">
                    </div>
                    <div class="flex items-center space-x-4">
                        <img src="/subsmain/subs3.jpg" alt="We Deliver" class="w-48 h-48 object-cover rounded-lg">
                        <img src="/subsmain/package.png" alt="optionimage" class="w-10 h-10 ">
                        <div class="flex-1">
                            <h4 class="text-xl font-semibold text-yellow-950">We Deliver</h4>
                            <p class="text-gray-500">We deliver your subscription box right to your doorstep.</p>
                        </div>
                    </div>
                </div>
                <div class="mt-12 text-center">
                    <Link
                        :href="isDisabled ? null : route('subscription.step1')" 
                        class="inline-block font-light rounded-xl ml-5 px-6 py-3 font-sans border-hidden bg-[#6b4f33] text-white ring-1 ring-transparent transition hover:text-white/70 hover:bg-[#5a402b] focus:outline-none focus-visible:ring-[#FF2D20] dark:text-black dark:hover:text-white/80 dark:hover:bg-yellow-950 dark:focus-visible:ring-white"
                        :class="{ 'opacity-50 cursor-not-allowed': isDisabled }" 
                    >
                        Get Started
                    </Link>
                </div>
                <!-- Error message box -->
                <div v-if="errorMessage" class="mt-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Error:</strong>
                    <span class="block sm:inline">{{ errorMessage }}</span>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</FooterLayout>
</template>

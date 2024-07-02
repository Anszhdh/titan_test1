<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />
        
        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div class="flex min-h-screen items-center justify-center bg-orange-100/10">
                <div class="flex w-full max-w-4xl bg-white shadow-lg rounded-lg overflow-hidden">
                    <div class="w-full md:w-2/3 p-8">
                        <h2 class="text-2xl font-semibold text-center text-brown-800">Login</h2>
                        <div class="mt-4">
                            <InputLabel for="email" value="Email" />
                            <TextInput
                                id="email"
                                type="email"
                                v-model="form.email"
                                required
                                class="block w-full px-4 py-2 mt-2 text-brown-700 bg-white border rounded-md focus:border-brown-500 focus:ring-brown-500 focus:outline-none focus:ring focus:ring-opacity-40"
                            />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>
                        <div class="mt-4">
                            <InputLabel for="password" value="Password" />
                            <TextInput
                                id="password"
                                type="password"
                                v-model="form.password"
                                required
                                class="block w-full px-4 py-2 mt-2 text-brown-700 bg-white border rounded-md focus:border-brown-500 focus:ring-brown-500 focus:outline-none focus:ring focus:ring-opacity-40"
                            />
                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>
                        <div class="mt-10 flex items-center justify-between">
                            <div class="flex items-center">
                                <Checkbox id="remember" v-model:checked="form.remember" />
                                <label for="remember" class="ml-2 text-sm text-gray-700">Remember me</label>
                            </div>
                            <PrimaryButton type="submit" class="bg-orange-950 hover:bg-yellow-900/70" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Login
                            </PrimaryButton>
                        </div>
                        <div class="mt-4 flex justify-between items-center">
                            <Link :href="route('register')" class="text-xs text-brown-600 hover:underline">New customer? Create Account</Link>
                            <!-- <Link v-if="canResetPassword" :href="route('password.request')" class="text-xs text-brown-600 hover:underline">Forgot your password?</Link> -->
                        </div>
                    </div>
                    <div class="hidden md:block md:w-1/3 bg-cover" style="background-image: url('home/registerl.jpg');"></div>
                </div>
            </div>
        </form>
    </GuestLayout>
</template>

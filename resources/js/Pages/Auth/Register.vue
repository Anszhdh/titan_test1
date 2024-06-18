<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';


const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    birthday: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};


</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <form @submit.prevent="submit">
            <div class="flex min-h-screen items-center justify-center bg-orange-100/10 ">
            <div class="flex w-full max-w-4xl bg-white shadow-lg rounded-lg overflow-hidden">
            <!-- Left side (form) -->
            <div class="w-full md:w-2/3 p-8">
                <h2 class="text-2xl font-semibold text-center text-brown-800">Create Account</h2>
                <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            
                    <div>
                    <InputLabel for="name" value="Username" />
                    <TextInput
                    id="name"
                    type="text"
                    v-model="form.name"
                    required
                    autocomplete="name"
                    class="mt-1 block w-full"
                    />
                    <InputError class="mt-2" :message="form.errors.username" />
                </div>

                <div>
                    <InputLabel for="email" value="Email" />
                    <TextInput
                    id="email"
                    type="email"
                    v-model="form.email"
                    required
                    autocomplete="email"
                    class="mt-1 block w-full"
                    />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div>
                    <InputLabel for="password" value="Password" />
                    <TextInput
                    id="password"
                    type="password"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                    class="mt-1 block w-full"
                    />
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div>
                    <InputLabel for="password_confirmation" value="Confirm Password" />
                    <TextInput
                    id="password_confirmation"
                    type="password"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                    class="mt-1 block w-full"
                    />
                    <InputError class="mt-2" :message="form.errors.password_confirmation" />
                </div>

                <div class="col-span-2">
                    <InputLabel for="birthday" value="Birthday" />
                    <input
                    id="birthday"
                    type="date"
                    v-model="form.birthday"
                    required
                    autofocus
                    autocomplete="bday"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm"
                    />
                    <InputError class="mt-2" :message="form.errors.birthday" />
                </div>

                <div class="col-span-2 mt-4 flex items-center justify-center ">
                    <PrimaryButton class="bg-orange-950 hover:bg-yellow-900/70" 
                    :class="{ 'opacity-25': form.processing }" :disabled="form.processing " >
                    Register
                    </PrimaryButton>
                </div>

                <div class="col-span-2 mt-4 flex justify-center items-center">
                    <Link
                    :href="route('login')"
                    class="text-xs text-brown-600 hover:underline"
                    >
                    Already have an account? Sign in
                    </Link>
                </div>
            </div>
        </div>
        <!-- Right side (image) -->
        <div class="hidden md:block md:w-1/3 bg-cover" style="background-image: url('home/registerl.jpg');"></div>
        </div>
    </div>
        </form>
    </GuestLayout>
</template>

<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm, usePage } from '@inertiajs/inertia-vue3';
const { props } = usePage(); // Assuming you are using usePage to access props

const form = useForm({
    name: props.auth && props.auth.user ? props.auth.user.name : '',
    email: props.auth && props.auth.user ? props.auth.user.email : '',
    birthday: props.auth && props.auth.user ? props.auth.user.birthday : '',
});

const submitForm = () => {
    form.put(route('profile.update')); // Ensure you are using put for updating
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Update Profile Information</h2>
        </header>

        <form @submit.prevent="submitForm" class="mt-6 space-y-6">
            <div>
                <InputLabel for="name" value="Name" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div>
                <InputLabel for="birthday" value="Birthday" />
                
                <TextInput
                    id="birthday"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.birthday"
                    autocomplete="birthday"
                />

                <InputError class="mt-2" :message="form.errors.birthday" />
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <transition enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0" leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                </transition>
            </div>
        </form>
    </section>
</template>

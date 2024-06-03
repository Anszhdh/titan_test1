<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { states } from '@/Data/states';


const { props } = usePage();
const address = props.address || {};

const form = useForm({
    address_line_1: address.address_line_1 || '',
    address_line_2: address.address_line_2 || '',
    city: address.city || '',
    state: address.state || '',
    postal_code: address.postal_code || '',
    phone_number: address.phone_number || '',
});

const submit = () => {
    form.patch(route('profile.updateBilling'));
};



</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Billing/Shipping Details</h2>
        </header>

        <form @submit.prevent="submit" class="mt-6 space-y-6">
            <div>
                <InputLabel for="phone_number" value="Phone Number" />

                <TextInput
                    id="phone_number"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.phone_number"
                    autocomplete="phone-number"
                />

                <InputError class="mt-2" :message="form.errors.phone_number" />
            </div>

            <div>
                <InputLabel for="address_line_1" value="Address Line 1" />

                <TextInput
                    id="address_line_1"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.address_line_1"
                    autocomplete="address-line1"
                />

                <InputError class="mt-2" :message="form.errors.address_line_1" />
            </div>

            <div>
                <InputLabel for="address_line_2" value="Address Line 2" />

                <TextInput
                    id="address_line_2"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.address_line_2"
                    autocomplete="address-line2"
                />

                <InputError class="mt-2" :message="form.errors.address_line_2" />
            </div>

            <div>
                <InputLabel for="city" value="City" />

                <TextInput
                    id="city"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.city"
                    autocomplete="address-level2"
                />

                <InputError class="mt-2" :message="form.errors.city" />
            </div>

            <div>
                <InputLabel for="state" value="State" />

                <select
                    id="state"
                    class="mt-1 block w-full"
                    v-model="form.state"
                    autocomplete="address-level1"
                >
                    <option value="">Select a state</option>
                    <option v-for="state in states" :key="state.value" :value="state.value">
                        {{ state.name }}
                    </option>
                </select>

                <InputError class="mt-2" :message="form.errors.state" />
            </div>

            <div>
                <InputLabel for="postal_code" value="Postal Code" />

                <TextInput
                    id="postal_code"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.postal_code"
                    autocomplete="postal-code"
                />

                <InputError class="mt-2" :message="form.errors.postal_code" />
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing" class="bg-yellow-950 hover:bg-yellow-950/50">Save</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>

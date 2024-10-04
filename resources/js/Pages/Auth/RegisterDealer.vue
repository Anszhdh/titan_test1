<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Inertia } from '@inertiajs/inertia';
import FooterLayout from '@/Layouts/FooterLayout.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

// Initialize form fields with both user and dealer-specific fields
const form = useForm({
    // Original user fields
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    birthday: '',
    
    // Dealer-specific fields
    business_name: '',
    business_registration_no: '',
    name_of_owner: '',
    address: '',
    delivery_address: '',
    tel_no: '',
    social_media: '',
    website: '',
    business_email: '', // Email specific to business info
    year_started: '',
    business_structure: '',
    number_of_employees: '',

    // Contact person information
    contact_name: '',
    contact_position: '',
    contact_email: '',
    contact_tel_no: '',
    contact_mobile_phone: '',
});

// Submit form to the dealer registration route
const submit = () => {
    form.post(route('register.dealer'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
        <FooterLayout>
    <GuestLayout>
        <Head title="Dealer Registration" />

        <form @submit.prevent="submit">
            <div class="flex min-h-screen items-center justify-center bg-orange-100/10">
                <div class="flex w-full mb-10  mt-10 max-w-4xl bg-white shadow-lg rounded-lg overflow-hidden">
                    <div class="w-full p-8">
                        <h2 class="text-2xl font-semibold text-center">Dealer Registration</h2>
                        
                        <!-- Original user fields -->
                        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <InputLabel for="name" value="Username" />
                                <TextInput id="name" v-model="form.name" required />
                                <InputError :message="form.errors.name" class="mt-2" />
                            </div>

                            <div>
                                <InputLabel for="email" value="Email" />
                                <TextInput id="email" type="email" v-model="form.email" required />
                                <InputError :message="form.errors.email" class="mt-2" />
                            </div>

                            <div>
                                <InputLabel for="password" value="Password" />
                                <TextInput id="password" type="password" v-model="form.password" required />
                                <InputError :message="form.errors.password" class="mt-2" />
                            </div>

                            <div>
                                <InputLabel for="password_confirmation" value="Confirm Password" />
                                <TextInput id="password_confirmation" type="password" v-model="form.password_confirmation" required />
                                <InputError :message="form.errors.password_confirmation" class="mt-2" />
                            </div>

                            <div>
                                <InputLabel for="birthday" value="Birthday" />
                                <input id="birthday" type="date" v-model="form.birthday" required class="mt-1 block w-full" />
                                <InputError :message="form.errors.birthday" class="mt-2" />
                            </div>
                        </div>

                        <!-- Dealer-specific fields -->
                        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <h3 class="col-span-2 text-xl font-semibold">Business Information</h3>

                            <div>
                                <InputLabel for="business_name" value="Business Name" />
                                <TextInput id="business_name" v-model="form.business_name" required />
                                <InputError :message="form.errors.business_name" class="mt-2" />
                            </div>

                            <div>
                                <InputLabel for="business_registration_no" value="Business Registration No." />
                                <TextInput id="business_registration_no" v-model="form.business_registration_no" required />
                                <InputError :message="form.errors.business_registration_no" class="mt-2" />
                            </div>

                            <div>
                                <InputLabel for="name_of_owner" value="Owner's Name" />
                                <TextInput id="name_of_owner" v-model="form.name_of_owner" required />
                                <InputError :message="form.errors.name_of_owner" class="mt-2" />
                            </div>

                            <div>
                                <InputLabel for="address" value="Business Address" />
                                <TextInput id="address" v-model="form.address" required />
                                <InputError :message="form.errors.address" class="mt-2" />
                            </div>

                            <div>
                                <InputLabel for="delivery_address" value="Delivery Address" />
                                <TextInput id="delivery_address" v-model="form.delivery_address" />
                                <InputError :message="form.errors.delivery_address" class="mt-2" />
                            </div>

                            <div>
                                <InputLabel for="tel_no" value="Telephone Number" />
                                <TextInput id="tel_no" v-model="form.tel_no" required />
                                <InputError :message="form.errors.tel_no" class="mt-2" />
                            </div>

                            <div>
                                <InputLabel for="social_media" value="Social Media" />
                                <TextInput id="social_media" v-model="form.social_media" />
                                <InputError :message="form.errors.social_media" class="mt-2" />
                            </div>

                            <div>
                                <InputLabel for="website" value="Website" />
                                <TextInput id="website" v-model="form.website" />
                                <InputError :message="form.errors.website" class="mt-2" />
                            </div>

                            <div>
                                <InputLabel for="business_email" value="Business Email" />
                                <TextInput id="business_email" type="email" v-model="form.business_email" required />
                                <InputError :message="form.errors.business_email" class="mt-2" />
                            </div>

                            <div>
                                <InputLabel for="year_started" value="Year Started" />
                                <input id="year_started" type="number" v-model="form.year_started" required class="mt-1 block w-full" />
                                <InputError :message="form.errors.year_started" class="mt-2" />
                            </div>

                            <div>
                                <InputLabel for="business_structure" value="Business Structure" />
                                <select id="business_structure" v-model="form.business_structure" required class="mt-1 block w-full">
                                    <option value="Wholesaler">Wholesaler</option>
                                    <option value="Retailer">Retailer</option>
                                    <option value="Installation Workplace">Installation Workplace</option>
                                    <option value="Mail Order">Mail Order</option>
                                    <option value="Internet Sales">Internet Sales</option>
                                    <option value="Other">Other</option>
                                </select>
                                <InputError :message="form.errors.business_structure" class="mt-2" />
                            </div>

                            <div>
                                <InputLabel for="number_of_employees" value="Number of Employees" />
                                <TextInput id="number_of_employees" v-model="form.number_of_employees" required />
                                <InputError :message="form.errors.number_of_employees" class="mt-2" />
                            </div>
                        </div>

                        <!-- Contact Person Information -->
                        <div class="mt-8">
                            <h3 class="text-xl font-semibold">Contact Person Information</h3>

                            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <InputLabel for="contact_name" value="Contact Name" />
                                    <TextInput id="contact_name" v-model="form.contact_name" required />
                                    <InputError :message="form.errors.contact_name" class="mt-2" />
                                </div>

                                <div>
                                    <InputLabel for="contact_position" value="Position" />
                                    <TextInput id="contact_position" v-model="form.contact_position" required />
                                    <InputError :message="form.errors.contact_position" class="mt-2" />
                                </div>

                                <div>
                                    <InputLabel for="contact_email" value="Contact Email" />
                                    <TextInput id="contact_email" type="email" v-model="form.contact_email" required />
                                    <InputError :message="form.errors.contact_email" class="mt-2" />
                                </div>

                                <div>
                                    <InputLabel for="contact_tel_no" value="Contact Telephone No." />
                                    <TextInput id="contact_tel_no" v-model="form.contact_tel_no" required />
                                    <InputError :message="form.errors.contact_tel_no" class="mt-2" />
                                </div>

                                <div>
                                    <InputLabel for="contact_mobile_phone" value="Mobile Phone" />
                                    <TextInput id="contact_mobile_phone" v-model="form.contact_mobile_phone" />
                                    <InputError :message="form.errors.contact_mobile_phone" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div class="mt-8">
                            <PrimaryButton class="w-full bg-orange-600 hover:bg-orange-600/80  justify-center">
                                Register Dealer
                            </PrimaryButton>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </GuestLayout>
</FooterLayout>
</template>

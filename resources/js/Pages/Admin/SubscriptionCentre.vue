<script setup>
import { ref, computed } from 'vue';
import { Head, usePage } from '@inertiajs/inertia-vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const { props } = usePage();

const subscriptions = ref(props.value.subscriptions);

const pastSubscription = computed(() => {
    return subscriptions.value.filter(sub => sub.status === 'past').length;
});

const todaySubscription = computed(() => {
    return subscriptions.value.filter(sub => new Date(sub.start_date).toDateString() === new Date().toDateString()).length;
});

const formatDate = (dateString) => {
    const date = new Date(dateString);
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear();
    return `${day}-${month}-${year}`;
};

</script>

<template>
    <AdminLayout>
        <Head title="Subscription Centre" />
    <div class="p-6 ">
        <h1 class="text-2xl font-semibold text-yellow-950">Subscription Centre</h1>
        <div class="mt-10">
            <div class="flex justify-between mb-10 ">
                <div class="bg-[#a08671]/10 p-6 rounded-xl shadow-md ">
                    <div class="text-xl font-bold">{{ subscriptions.length }}</div>
                    <div> Total Subscription</div>
                </div>
                <div class="bg-[#a08671]/10 p-6 rounded-xl  shadow-md">
                    <div class="text-xl font-bold">{{ pastSubscription }}</div>
                    <div>Past Subscription</div>
                </div>
                <div class="bg-[#a08671]/10 p-6 rounded-xl  shadow-md">
                    <div class="text-xl font-bold">{{ todaySubscription }}</div>
                    <div>Today Subscription</div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead class="bg-[#dad8d7] text-black">
                        <tr>
                            <!-- <th class="py-2 px-4 border-b text-center">#</th> -->
                            <th class="py-2 px-4 border-b text-center">Name</th>
                            <th class="py-2 px-4 border-b text-center">Subscription Type</th>
                            <th class="py-2 px-4 border-b text-center">Subscription Start</th>
                            <th class="py-2 px-4 border-b text-center">Subscription End</th>
                            <th class="py-2 px-4 border-b text-center">Value</th>
                            <th class="py-2 px-4 border-b text-center">Status</th>
                            <th class="py-2 px-4 border-b text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="subscription in subscriptions" :key="subscription.id" class="text-center align-middle">
                             <!-- <td class="py-2 px-4 border-b text-sm text-gray-900">{{ index + 1 }}</td> -->
                            <td class="py-2 px-4 border-b">{{ subscription.user.name }}</td>
                            <td class="py-2 px-4 border-b">{{ subscription.type }}</td>
                            <td class="py-2 px-4 border-b">{{ formatDate(subscription.start_date)}}</td>
                            <td class="py-2 px-4 border-b">{{ formatDate(subscription.end_date) }}</td>
                            <td class="py-2 px-4 border-b">RM {{ subscription.price }}</td>
                            <td class="py-2 px-4 border-b">{{ subscription.status }}</td>
                            <td class="py-2 px-4 border-b">
                                <button class="bg-green-500 text-white px-3 py-1 rounded mr-4">Edit</button>
                                <button class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</AdminLayout>
</template>


<style scoped>
/* Add any necessary styling here */
</style>

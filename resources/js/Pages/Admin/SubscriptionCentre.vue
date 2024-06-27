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
</script>

<template>
    <AdminLayout>
        <Head title="Subscription Centre" />
    <div class="p-6 bg-white border-b border-gray-200">
        <h1 class="text-2xl font-semibold">Subscription Centre</h1>
        <div class="mt-4">
            <div class="flex justify-between mb-6">
                <div class="bg-gray-100 p-4 rounded shadow">
                    <div class="text-xl font-bold">{{ subscriptions.length }}</div>
                    <div>Subscription</div>
                </div>
                <div class="bg-gray-100 p-4 rounded shadow">
                    <div class="text-xl font-bold">{{ pastSubscription }}</div>
                    <div>Past Subscription</div>
                </div>
                <div class="bg-gray-100 p-4 rounded shadow">
                    <div class="text-xl font-bold">{{ todaySubscription }}</div>
                    <div>Today Subscription</div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">Name</th>
                            <th class="py-2 px-4 border-b">Subscription Type</th>
                            <th class="py-2 px-4 border-b">Subscription Start</th>
                            <th class="py-2 px-4 border-b">Subscription End</th>
                            <th class="py-2 px-4 border-b">Value</th>
                            <th class="py-2 px-4 border-b">Status</th>
                            <th class="py-2 px-4 border-b">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="subscription in subscriptions" :key="subscription.id">
                            <td class="py-2 px-4 border-b">{{ subscription.user.name }}</td>
                            <td class="py-2 px-4 border-b">{{ subscription.type }}</td>
                            <td class="py-2 px-4 border-b">{{ subscription.start_date }}</td>
                            <td class="py-2 px-4 border-b">{{ subscription.end_date }}</td>
                            <td class="py-2 px-4 border-b">{{ subscription.price }}</td>
                            <td class="py-2 px-4 border-b">{{ subscription.status }}</td>
                            <td class="py-2 px-4 border-b">
                                <button class="bg-green-500 text-white px-2 py-1 rounded">Edit</button>
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

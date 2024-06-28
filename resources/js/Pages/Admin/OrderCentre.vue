<script setup>
import { ref, computed } from 'vue';
import { Head, usePage } from '@inertiajs/inertia-vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const { props } = usePage();

const order = ref(props.value.order);

const pastOrder = computed(() => {
    return order.value.filter(sub => sub.status === 'past').length;
});

const todayOrder= computed(() => {
    return order.value.filter(sub => new Date(sub.start_date).toDateString() === new Date().toDateString()).length;
});
</script>

<template>
    <AdminLayout>
        <Head title="Order Centre" />
    <div class="p-6 bg-white border-b border-gray-200">
        <h1 class="text-2xl font-semibold text-yellow-950">Order Centre</h1>
        <div class="mt-10">
            <div class="flex justify-between mb-10">
                <div class="bg-[#a08671]/10 p-6 rounded-xl shadow-md">
                    <div class="text-xl font-bold">{{ order.length }}</div>
                    <div>Total Order</div>
                </div>
                <div class="bg-[#a08671]/10 p-6 rounded-xl shadow-md">
                    <div class="text-xl font-bold">{{ todayOrder }}</div>
                    <div>New Order</div>
                </div>
                <div class="bg-[#a08671]/10 p-6 rounded-xl shadow-md">
                    <div class="text-xl font-bold">{{ todayOrder }}</div>
                    <div>Pending Order</div>
                </div> 
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead class="bg-[#dad8d7]">
                        <tr>
                          <th class="py-2 px-4 border-b text-center">Name</th>
                           <th class="py-2 px-4 border-b text-center">Payment Type </th>
                           <th class="py-2 px-4 border-b text-center">Amount</th>
                            <th class="py-2 px-4 border-b text-center">Status</th>
                            <th class="py-2 px-4 border-b text-center">Date</th> 
                            <th class="py-2 px-4 border-b text-center">References</th> 
                            <th class="py-2 px-4 border-b text-center">Action</th> 
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="order in order" :key="order.id">
                            <td class="py-2 px-4 border-b">{{ order.user.name }}</td>
                            <td class="py-2 px-4 border-b">{{ order.payment.type }}</td>
                            <td class="py-2 px-4 border-b">{{ order.total_price }}</td>
                            <td class="py-2 px-4 border-b">{{ order.status }}</td>
                            <td class="py-2 px-4 border-b">{{ order.created_at }}</td>
                            <td class="py-2 px-4 border-b">{{ order.receipt_path }}</td>
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

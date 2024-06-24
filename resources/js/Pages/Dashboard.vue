<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import SalesChart from '@/Graph/Chart.vue';  // Adjust the import path as necessary
</script>

<template>
    <AdminLayout>
        <Head title="Dashboard" />
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">Dashboard</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-gray-600">Available to payout</h3>
                <p class="text-2xl font-semibold">RM10.1K</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-gray-600">Today revenue</h3>
                <p class="text-2xl font-semibold">RM1.6K <span class="text-red-600">(-6.2%)</span></p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-gray-600">Today sessions</h3>
                <p class="text-2xl font-semibold">240 <span class="text-green-600">(50%)</span></p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-gray-600 mb-4">Sales Analytic</h3>
            <SalesChart />
        </div>
    </AdminLayout>
</template>

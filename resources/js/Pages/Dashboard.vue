<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import SubscriptionChart from '@/Graph/Chart.vue';
import OrdersChart from '@/Graph/Chart1.vue';

// Mock data for demonstration
const availableToPayout = 'RM1.1K';
const todayRevenue = 'RM800';
const todaySessions = 'RM300';

const subscriptionData = {
  labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
  datasets: [
    {
      label: 'Subscriptions',
      data: [12, 19, 3, 5, 2, 3], // Replace with actual subscription data
      backgroundColor: '#3182CE',
    },
  ],
};

const ordersData = {
  labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
  datasets: [
    {
      label: 'Orders',
      data: [5, 10, 15, 20, 25, 30], // Replace with actual orders data
      backgroundColor: '#F56565',
    },
  ],
};
</script>

<template>
  <AdminLayout>
    <Head title="Dashboard" />

    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">Dashboard</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
      <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-gray-600"> Sales</h3>
        <p class="text-2xl font-semibold">{{ availableToPayout }}</p>
      </div>
      <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-gray-600">Subscription Sales</h3>
        <p class="text-2xl font-semibold">{{ todayRevenue }} <span class="text-red-600">(-6.2%)</span></p>
      </div>
      <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-gray-600">Order Sales</h3>
        <p class="text-2xl font-semibold">{{ todaySessions }} <span class="text-green-600">(50%)</span></p>
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-gray-600 mb-4">Subscription Sales</h3>
        <SubscriptionChart :chartData="subscriptionData" />
      </div>
      <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-gray-600 mb-4">Orders Sales</h3>
        <OrdersChart :chartData="ordersData" />
      </div>
    </div>
  </AdminLayout>
</template>

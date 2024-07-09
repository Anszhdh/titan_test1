<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import SubscriptionChart from '@/Graph/Chart.vue';
import { ref, onMounted } from 'vue';
import axios from 'axios';

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

const formatDate = (dateString) => {
    const date = new Date(dateString);
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear();
    return `${day}-${month}-${year}`;
};

const recentSubscribers = ref([]);

const fetchRecentSubscribers = async () => {
    try {
        const response = await axios.get('/api/recent-subscribers');
        recentSubscribers.value = response.data;
        console.log(recentSubscribers.value); // Log fetched data for inspection
    } catch (error) {
        console.error('Error fetching recent subscribers:', error);
    }
};

onMounted(fetchRecentSubscribers);
</script>

<template>
  <AdminLayout>
    <Head title="Dashboard" />

    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">Dashboard</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
      <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-gray-600">Sales</h3>
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
        <h3 class="text-black mb-4">Recent Subscribers (Past 7 Days)</h3>
        <div class="max-h-80 overflow-y-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Subscription Type</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Start Date</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">End Date</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="subscriber in recentSubscribers" :key="subscriber.id">
                <td class="px-6 py-4 whitespace-nowrap">{{ subscriber.user?.name }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ subscriber.type }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ formatDate(subscriber.start_date) }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ formatDate(subscriber.end_date) }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

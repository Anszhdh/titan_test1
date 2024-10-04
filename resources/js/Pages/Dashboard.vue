<template>
  <AdminLayout>
    <Head title="Dashboard" />

    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">Dashboard</h2>

    <!-- Sales Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
      <div class="p-6 rounded-lg shadow-md" style="background: linear-gradient(to bottom, rgba(253, 224, 71, 0.6), rgba(251, 191, 36, 0.7));">
        <h3 class="text-gray-800">Total Sales</h3>
        <p class="text-2xl font-semibold">
          RM {{ totalSales.toFixed(2) }}
        </p>
      </div>
      <div class="p-6 rounded-lg shadow-md" style="background: linear-gradient(to bottom, rgba(249, 168, 212, 0.6), rgba(244, 114, 182, 0.7));">
        <h3 class="text-gray-800">Dealer Sales</h3>
        <p class="text-2xl font-semibold">
          RM {{ totalSubscriptionSales }}
        </p>
      </div>
      <div class="p-6 rounded-lg shadow-md" style="background: linear-gradient(to bottom, rgba(147, 197, 253, 0.6), rgba(96, 165, 250, 0.7));">
        <h3 class="text-gray-800">Order Sales</h3>
        <p class="text-2xl font-semibold">
          RM {{ totalOrderSales }}
        </p>
      </div>
    </div>

    <!-- Sales and Recommended Products Charts -->
    <div class="grid grid-cols-1 mt-10 md:grid-cols-2 gap-4">
      <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="bg-gradient-to-r from-blue-400 to-indigo-500 rounded-t-lg p-1">
          <h3 class="text-white font-bold mb-2 mt-2">Regal Valet Sales Analytic</h3>
        </div>
        <SubscriptionChart :salesData="salesData" />
      </div>
      <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="text-center bg-gradient-to-r from-orange-400 to-pink-500 rounded-t-lg p-1">
          <h1 class="text-white font-bold mb-2 mt-2 ">Top Recommended Regal Valet Products</h1>
        </div>
        <PieChart :chartData="props.recommendationData" />
      </div>
    </div>

    <!-- Recent Users and Dealers Tables -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-8">
      <!-- Recent Users Table -->
      <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-gray-800 mb-4">Recent Customer (Past 7 Days)</h3>
        <div class="max-h-80 overflow-y-auto shadow-md rounded-lg">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gradient-to-r from-purple-500 to-indigo-500">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Role</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Joined Date</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="user in filteredRecentUsers" :key="user.id" class="hover:bg-indigo-100 transition duration-300 ease-in-out">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ user.name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Customer</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ formatDate(user.created_at) }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Recent Dealers Table -->
      <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-gray-800 mb-4">Recent Dealers (Past 7 Days)</h3>
        <div class="max-h-80 overflow-y-auto shadow-md rounded-lg">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gradient-to-r from-purple-500 to-indigo-500">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Role</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Joined Date</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="dealer in filteredRecentDealers" :key="dealer.id" class="hover:bg-indigo-100 transition duration-300 ease-in-out">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ dealer.name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Dealer</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ formatDate(dealer.created_at) }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import SubscriptionChart from '@/Graph/Chart.vue';
import PieChart from '@/Graph/PieChart.vue';
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';

const props = defineProps({
  recentSubscriptions: Array,
  totalSubscriptionSales: Number,
  totalOrderSales: Number,
  totalSales: Number,
  previousSubscriptionSales: Number,
  previousOrderSales: Number,
  previousSales: Number,
  salesData: Object, 
  recommendationData: Array,
});

const formatDate = (dateString) => {
  const date = new Date(dateString);
  const day = String(date.getDate()).padStart(2, '0');
  const month = String(date.getMonth() + 1).padStart(2, '0');
  const year = date.getFullYear();
  return `${day}-${month}-${year}`;
};

const recentUsers = ref([]);
const recentDealers = ref([]);

const fetchRecentUsers = async () => {
  try {
    const response = await axios.get('/api/recent-users'); // Adjust the API endpoint accordingly
    recentUsers.value = response.data;
    console.log(recentUsers.value); // Log fetched data for inspection
  } catch (error) {
    console.error('Error fetching recent users:', error);
  }
};

const fetchRecentDealers = async () => {
  try {
    const response = await axios.get('/api/recent-dealers'); // Adjust the API endpoint accordingly
    recentDealers.value = response.data;
    console.log(recentDealers.value); // Log fetched data for inspection
  } catch (error) {
    console.error('Error fetching recent dealers:', error);
  }
};

const filteredRecentUsers = computed(() => {
  const today = new Date();
  const sevenDaysAgo = new Date();
  sevenDaysAgo.setDate(today.getDate() - 7);

  return recentUsers.value.filter(user => {
    const createdAt = new Date(user.created_at);
    return createdAt >= sevenDaysAgo && createdAt <= today && user.role === 0; // Filter for customers
  });
});

const filteredRecentDealers = computed(() => {
  const today = new Date();
  const sevenDaysAgo = new Date();
  sevenDaysAgo.setDate(today.getDate() - 7);

  return recentDealers.value.filter(dealer => {
    const createdAt = new Date(dealer.created_at);
    return createdAt >= sevenDaysAgo && createdAt <= today && dealer.role === 2; // Filter for dealers
  });
});



onMounted(() => {
  fetchRecentUsers();
  fetchRecentDealers();
});
</script>

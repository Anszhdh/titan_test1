<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import SubscriptionChart from '@/Graph/Chart.vue';
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';

// Mock data for demonstration
const props = defineProps({
  recentSubscriptions: Array,
  totalSubscriptionSales: Number,
  totalOrderSales: Number,
  totalSales: Number,
  previousSubscriptionSales: Number,
  previousOrderSales: Number,
  previousSales: Number,
  salesData: Object, // Ensure salesData is defined as an Object prop
});


const salesChange = computed(() => {
  return ((props.totalSales - props.previousSales) / props.previousSales) * 100;
});

const subscriptionChange = computed(() => {
  return ((props.totalSubscriptionSales - props.previousSubscriptionSales) / props.previousSubscriptionSales) * 100;
});

const orderChange = computed(() => {
  return ((props.totalOrderSales - props.previousOrderSales) / props.previousOrderSales) * 100;
});


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
onMounted(() => {
  console.log('Props:', props);
});
</script>

<template>
  <AdminLayout>
    <Head title="Dashboard" />

    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">Dashboard</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
      <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-gray-600">Sales</h3>
        <p class="text-2xl font-semibold">RM {{ totalSales.toFixed(2) }} <span :class="{ 'text-green-600': salesChange > 0, 'text-red-600': salesChange < 0 }">({{ salesChange.toFixed(1) }}%)</span></p>
      </div>
      <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-gray-600">Subscription Sales</h3>
        <p class="text-2xl font-semibold">RM {{totalSubscriptionSales}} <span :class="{ 'text-green-600': subscriptionChange > 0, 'text-red-600': subscriptionChange < 0 }">({{ subscriptionChange.toFixed(1) }}%)</span></p>
      </div>
      <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-gray-600">Order Sales</h3>
        <p class="text-2xl font-semibold">RM {{totalOrderSales  }} <span :class="{ 'text-green-600': orderChange > 0, 'text-red-600': orderChange < 0 }">({{ orderChange.toFixed(1) }}%)</span></p>
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-gray-600 mb-4">Brewbox Sales</h3>
        <SubscriptionChart :salesData="salesData" />
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

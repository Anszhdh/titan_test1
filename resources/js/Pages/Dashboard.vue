<template>
    <AdminLayout>
      <Head title="Dashboard" />
  
      <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">Dashboard</h2>
      
      <!-- Metrics Cards -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
        <!-- Available to Payout -->
        <div class="bg-white p-6 rounded-lg shadow-md">
          <h3 class="text-gray-600">Available to payout</h3>
          <p class="text-2xl font-semibold">{{ availableToPayout }}</p>
        </div>
        <!-- Today Revenue -->
        <div class="bg-white p-6 rounded-lg shadow-md">
          <h3 class="text-gray-600">Today revenue</h3>
          <p class="text-2xl font-semibold">{{ todayRevenue }} <span :class="{ 'text-red-600': revenueDecrease, 'text-green-600': revenueIncrease }">{{ revenueChange }}</span></p>
        </div>
        <!-- Today Sessions -->
        <div class="bg-white p-6 rounded-lg shadow-md">
          <h3 class="text-gray-600">Today sessions</h3>
          <p class="text-2xl font-semibold">{{ todaySessions }} <span :class="{ 'text-red-600': sessionsDecrease, 'text-green-600': sessionsIncrease }">{{ sessionsChange }}</span></p>
        </div>
      </div>
  
      <!-- Sales Analytics -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Subscription Sales Chart -->
        <div class="bg-white p-6 rounded-lg shadow-md">
          <h3 class="text-gray-600 mb-4">Subscription Sales</h3>
          <SalesChart :chartData="subscriptionSalesData" />
        </div>
        <!-- Orders Sales Chart -->
        <div class="bg-white p-6 rounded-lg shadow-md">
          <h3 class="text-gray-600 mb-4">Orders Sales</h3>
          <SalesChart :chartData="orderSalesData" />
        </div>
      </div>
    </AdminLayout>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import AdminLayout from '@/Layouts/AdminLayout.vue';
  import { Head } from '@inertiajs/inertia-vue3';
  import SalesChart from '@/Graph/SalesChart.vue'; // Assuming you have a generic SalesChart component
  
  // Mock data for demonstration
  const availableToPayout = 'RM10.1K';
  const todayRevenue = 'RM1.6K';
  const todaySessions = 240;
  const revenueChange = '-6.2%'; // Mock data for change indicators
  const sessionsChange = '50%'; // Mock data for change indicators
  const revenueDecrease = true; // Mock data for change indicators
  const sessionsIncrease = true; // Mock data for change indicators
  
  // Placeholder for actual data fetched from backend
  const subscriptionSalesData = ref(null);
  const orderSalesData = ref(null);
  
  // Function to fetch sales data
  const fetchSalesData = () => {
    // Replace with actual API endpoints in your Laravel application
    fetch('/api/subscriptions/sales')
      .then(response => response.json())
      .then(data => subscriptionSalesData.value = data)
      .catch(error => console.error('Error fetching subscription sales:', error));
  
    fetch('/api/orders/sales')
      .then(response => response.json())
      .then(data => orderSalesData.value = data)
      .catch(error => console.error('Error fetching order sales:', error));
  };
  
  // Fetch data on component mount
  onMounted(() => {
    fetchSalesData();
  });
  </script>
  
  <style scoped>
  /* Add your custom styles here */
  </style>
  
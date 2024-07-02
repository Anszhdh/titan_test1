<script setup>
import { ref, onMounted } from 'vue';
import { Line } from 'vue-chartjs';
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  LineElement,
  CategoryScale,
  LinearScale,
  PointElement,
} from 'chart.js';

ChartJS.register(Title, Tooltip, Legend, LineElement, CategoryScale, LinearScale, PointElement);

const chartData = ref({
  labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
  datasets: [
    {
      label: 'Order 2024',
      data: [10, 20, 30, 45, 54, 59, 70, 90, 100, 120, 110, 120],
      borderColor: 'rgb(75, 192, 192)',
      tension: 0.1,
    },
    {
      label: 'Order 2023',
      data: [0, 11, 20, 25, 3, 10, 30, 10, 50, 56, 69, 70],
      borderColor: 'rgb(54, 162, 235)',
      tension: 0.1,
    },
  ],
});

const chartOptions = ref({
  responsive: true,
  plugins: {
    legend: {
      position: 'top',
    },
    title: {
      display: true,
      text: 'Sales Analytic',
    },
  },
});

onMounted(() => {
  // Any additional setup can be done here
});
</script>

<template>
  <Line :data="chartData" :options="chartOptions" />
</template>

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
      label: 'Non-shipping 2019',
      data: [10, 20, 30, 40, 50, 60, 70, 80, 90, 100, 110, 120],
      borderColor: 'rgb(75, 192, 192)',
      tension: 0.1,
    },
    {
      label: 'Non-shipping 2018',
      data: [20, 30, 40, 50, 60, 70, 80, 90, 100, 110, 120, 130],
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

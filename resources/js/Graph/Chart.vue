<script setup>
import { ref, computed, onMounted } from 'vue';
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

const props = defineProps({
  salesData: {
    type: Object,
    default: () => ({}),
  },
});

const formatDate = (dateString) => {
  const date = new Date(dateString);
  const options = { weekday: 'short', month: 'short', day: 'numeric' };
  return date.toLocaleDateString('en-US', options);
};

const chartData = computed(() => ({
  labels: Object.keys(props.salesData).map(date => formatDate(date)),
  datasets: [
    {
      label: 'Total Sales',
      data: Object.values(props.salesData),
      borderColor: 'rgb(75, 192, 192)',
      tension: 0.1,
    },
  ],
}));

const chartOptions = ref({
  responsive: true,
  plugins: {
    legend: {
      position: 'top',
    },
    title: {
      display: true,
      text: 'Sales Analytic (Last 7 Days)',
    },
  },
});

onMounted(() => {
  console.log('Sales Data:', props.salesData);
});
</script>

<template>
  <Line :data="chartData" :options="chartOptions" />
</template>

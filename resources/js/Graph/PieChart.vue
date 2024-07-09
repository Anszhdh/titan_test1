<script setup>
import { ref, computed } from 'vue';
import { Pie } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, ArcElement } from 'chart.js';
import ChartDataLabels from 'chartjs-plugin-datalabels';

ChartJS.register(Title, Tooltip, Legend, ArcElement, ChartDataLabels);

const props = defineProps({
  chartData: {
    type: Array,
    required: true,
  },
});

const chartData = computed(() => ({
  labels: props.chartData.map(item => item.label),
  datasets: [{
    data: props.chartData.map(item => item.value),
    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'], // Vibrant colors
  }],
}));

const chartOptions = ref({
  responsive: true,
  plugins: {
    legend: {
      position: 'top',
    },
    title: {
      display: true,
      text: 'Top Recommended Products',
    },
    datalabels: {
      formatter: (value, context) => {
        const dataset = context.chart.data.datasets[0];
        const total = dataset.data.reduce((acc, val) => acc + val, 0);
        const percentage = (value / total * 100).toFixed(2);
        return `${percentage}%`;
      },
      color: '#fff',
      labels: {
        title: {
          font: {
            weight: 'bold'
          }
        }
      }
    }
  },
});
</script>

<template>
  <div class="w-full md:w-900 lg:w-1/2 mx-auto">
    <div class="h-84">
      <Pie :data="chartData" :options="chartOptions" />
    </div>
  </div>
</template>

<template>
  <div>
    <bar-chart :data="chartData" :options="chartOptions" />
  </div>
</template>

<script setup>
import { defineProps } from 'vue';
import { Bar } from 'vue-chartjs';

const props = defineProps(['chartData']);

const chartData = props.chartData;
const chartOptions = {
  responsive: true,
  maintainAspectRatio: false,
  scales: {
    x: {
      stacked: true,
    },
    y: {
      stacked: true,
    },
  },
};
</script>

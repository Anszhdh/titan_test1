<template>
  <div>
    <line-chart :data="chartData" :options="chartOptions" />
  </div>
</template>

<script setup>
import { defineProps } from 'vue';
import { Line } from 'vue-chartjs';

const props = defineProps(['chartData']);

const chartData = props.chartData;
const chartOptions = {
  responsive: true,
  maintainAspectRatio: false,
};
</script>

<template>
    <div>
      <line-chart :chart-data="data" :options="options" />
    </div>
  </template>
  
  <script>
  import { Line, mixins } from 'vue-chartjs';
  
  export default {
    extends: Line,
    mixins: [mixins.reactiveProp],
    props: ['chartData'],
    data() {
      return {
        options: {
          responsive: true,
          maintainAspectRatio: false,
        },
      };
    },
    mounted() {
      this.renderChart(this.chartData, this.options);
    },
  };
  </script>
  
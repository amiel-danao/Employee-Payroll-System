<template>
    <div>
      <canvas ref="lineChart"></canvas>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      chartData: {
        type: Object,
        required: true
      }
    },
    mounted() {
      this.renderChart();
    },
    methods: {
      renderChart() {
        const ctx = this.$refs.lineChart.getContext('2d');
        new Chart(ctx, {
          type: 'line',
          data: this.chartData
        });
      }
    }
  };
  </script>
  
  <style scoped>
  /* Add any styles specific to your LineChart component */
  </style>
  
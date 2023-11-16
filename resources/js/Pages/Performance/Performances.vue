<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Card from '@/Components/Card.vue';
import { __ } from '@/Composables/useTranslations.js';

// Import Bar component
import { Bar } from 'vue-chartjs';

// Import ChartJS components
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale,
} from 'chart.js';

ChartJS.register(
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale
);

const props = defineProps({
  tasks: Object,
});

// Extract employee names and task counts
const employeeNames = Object.keys(props.tasks).map((id) => props.tasks[id].employee_name);
const taskCounts = Object.keys(props.tasks).map((id) => props.tasks[id].task_count);
const colors = ["#FF0000", "#00FF00", "#0000FF"];
const monthNames = [
  "January", "February", "March", "April", "May", "June",
  "July", "August", "September", "October", "November", "December"
];

// Generate chart data
// const chartData = {
//   labels: employeeNames,
//   datasets: [{ label: employeeNames, data: taskCounts, backgroundColor: colors }],
// };
const chartData = {
    labels: monthNames,
    datasets: props.tasks
}
//[ {label: employeeNames[0], data: [40], backgroundColor: ["#FF0000"] }, {label: employeeNames[1], data: [50], backgroundColor: ["#00FF00"] } ]
const chartOptions = {
  responsive: true,
};

console.log(props.tasks);
</script>

<template>
  <Head :title="__('Employee Performance')" />
  <AuthenticatedLayout>
    <div class="py-8">
      <div class="flex flex-col md:flex-row justify-between md:gap-4" v-if="tasks">
        <Card class="!p-2 w-full">
          <h1 class="text-2xl">{{ __('Emplyee Performance') }}<small> (Task Done)</small></h1>
          <div class="flex flex-wrap justify-center gap-4">
            <Bar id="my-chart-id" :options="chartOptions" :data="chartData" />
          </div>
        </Card>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

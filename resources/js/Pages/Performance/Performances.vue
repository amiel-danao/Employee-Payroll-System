<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Card from '@/Components/Card.vue';
import { __ } from '@/Composables/useTranslations.js';
import { Bar } from 'vue-chartjs';
import { defineProps, reactive, watch, watchEffect } from 'vue';
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

// const props = defineProps({
//   tasks: Object,
//   departments: Object,
// });
const props = defineProps(['tasks', 'departments']);
const data = reactive({
  selectedDepartment: null,
});


const departments = reactive([...new Set(props.departments)]);

const employeeNames = Object.keys(props.tasks).map((id) => props.tasks[id].employee_name);
const taskCounts = Object.keys(props.tasks).map((id) => props.tasks[id].task_count);
const colors = ["#FF0000", "#00FF00", "#0000FF"];
const monthNames = [
  "January", "February", "March", "April", "May", "June",
  "July", "August", "September", "October", "November", "December"
];

const chartData = reactive({
  labels: monthNames,
  datasets: props.tasks,
});

const chartOptions = {
  responsive: true,
  scales: {
    y: {
      ticks: {
        beginAtZero: true,
        precision: 0,
      },
    },
  },
};


</script>

<template>
  <Head :title="__('Employee Performance')" />
  <AuthenticatedLayout>
    <div class="py-8">
      <div class="flex flex-col md:flex-row justify-between md:gap-4" v-if="tasks">
        <Card class="!p-2 w-full">
          <h1 class="text-2xl">{{ __('Employee Performance') }}<small> (Task Done)</small></h1>
          <div class="flex items-center mt-4" v-if="$page.props.auth.user.roles.includes('admin')">
            <label for="department" class="mr-2">Select Department:</label>
            <select v-model="data.selectedDepartment" class="dropdown">
              <option :value="null">All Departments</option>
              <option v-for="department in departments" :value="department">
                {{ department }}
              </option>
            </select>
          </div>
          <!-- add a conditional statement to check if the current user is employee role -->

          <div class="flex flex-wrap justify-center gap-4">
            <Bar id="my-chart-id" :options="chartOptions" :data="chartData" />
          </div>
        </Card>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style scoped>
.dropdown {
  background-color: white;
  color: black;
}

@media (prefers-color-scheme: dark) {
  .dropdown {
    background-color: #333;
    color: white;
  }
}
</style>

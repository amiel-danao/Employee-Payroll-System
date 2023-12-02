<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import FlexButton from "@/Components/FlexButton.vue";
import TaskTabs from "@/Components/Tabs/TaskTabs.vue";
import Card from "@/Components/Card.vue";
import PlusIcon from "@/Components/Icons/PlusIcon.vue";
import TableBody from "@/Components/Table/TableBody.vue";
import TableRow from "@/Components/Table/TableRow.vue";
import TableBodyHeader from "@/Components/Table/TableBodyHeader.vue";
import Table from "@/Components/Table/Table.vue";
import TableHead from "@/Components/Table/TableHead.vue";
import {__} from "@/Composables/useTranslations.js";
import {task_types} from "@/Composables/useTaskTypes.js";
import {task_status_types} from "@/Composables/useTaskStatusTypes.js";

defineProps({
    tasks: Object,
})

</script>
<template>
    <Head :title="__('Tasks')"/>
    <AuthenticatedLayout>
        <template #tabs>
            <TaskTabs />
        </template>
        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Card class="!mt-0">
                    <div class="flex justify-between items-center pb-4">
                        <h1 class="card-header !mb-4">{{__('Current Tasks')}}</h1>
                        <FlexButton v-if="$page.props.auth.user.roles.includes('admin')" :href="route('zzz.create')"
                                    :text="__('Initiate A Task')">
                            <PlusIcon/>
                        </FlexButton>
                    </div>
                    <Table :links="tasks.links" :showingNumber="tasks.data.length" :totalNumber="tasks.total">
                        <template #Head>
                            <TableHead>{{__('ID')}}</TableHead>
                            <TableHead>{{__('Employee assigned')}}</TableHead>
                            <TableHead>{{__('Description')}}</TableHead>
                            <TableHead>{{__('Start Date')}}</TableHead>
                            <TableHead>{{__('End Date')}}</TableHead>
                            <TableHead>{{__('Date Taken')}}</TableHead>
                            <TableHead>{{__('Date Completed')}}</TableHead>
                            <TableHead>{{__('Status')}}</TableHead>
                        </template>

                        <!--Iterate Here-->
                        <template #Body>
                            <TableRow v-for="task in tasks.data" :key="task.id">
                                <TableBodyHeader :href="route('zzz.show', {id: task.id})">{{task.id}}</TableBodyHeader>
                                <TableBodyHeader :href="route('zzz.show', {id: task.id})" >{{task.employee_name}}</TableBodyHeader>
                                <TableBodyHeader :href="route('zzz.show', {id: task.id})" >{{task.description}}</TableBodyHeader>
                                <TableBody :href="route('zzz.show', {id: task.id})">{{task.start_date}}</TableBody>
                                <TableBody :href="route('zzz.show', {id: task.id})">{{task.end_date == null? __('N/A') : task.end_date}}</TableBody>
                                <TableBody :href="route('zzz.show', {id: task.id})">{{task.date_taken == null ? __('N/A'): task.date_taken}}</TableBody>
                                <TableBody :href="route('zzz.show', {id: task.id})">{{task.date_completed == null ? __('N/A'): task.date_completed}}</TableBody>
                                <TableBody :href="route('zzz.show', {id: task.id})">
                                    {{  task.status === "Available" ? task_status_types['available'] + ' ❇️' :
                                        task.status === "Ongoing" ? task_status_types['ongoing'] + ' ⏳' :
                                        task.status === "Done" ? task_status_types['done'] + ' ✅' :
                                        task.status === "Approved" ? task_status_types['approved'] + ' 👌' :
                                            task_status_types['rejected'] + ' 🚫'
                                    }}
                                    <span class="text-red-500 text-xs font-bold"
                                        v-if="!$page.props.auth.user.roles.includes('admin') && task.status !== 'Pending' && !task.is_seen">
                                        
                                    </span>
                                </TableBody>
                            </TableRow>
                        </template>
                    </Table>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

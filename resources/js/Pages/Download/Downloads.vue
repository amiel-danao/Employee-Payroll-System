<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import FlexButton from "@/Components/FlexButton.vue";
import TableIcon from "@/Components/Icons/TableIcon.vue";
import Card from "@/Components/Card.vue";
import MoneyIcon from "@/Components/Icons/MoneyIcon.vue";
import MessageIcon from "@/Components/Icons/MessageIcon.vue";
import TableBody from "@/Components/Table/TableBody.vue";
import TableRow from "@/Components/Table/TableRow.vue";
import TableBodyHeader from "@/Components/Table/TableBodyHeader.vue";
import Table from "@/Components/Table/Table.vue";
import TableHead from "@/Components/Table/TableHead.vue";
import {__} from "@/Composables/useTranslations.js";
import {task_types} from "@/Composables/useTaskTypes.js";
import {task_status_types} from "@/Composables/useTaskStatusTypes.js";
import { AkPersonCross } from "@kalimahapps/vue-icons";

defineProps({
    tasks: Object,
})

</script>
<template>
    <Head :title="__('Downloads')"/>
    <AuthenticatedLayout>
        <div class="py-8">
            <div class="flex flex-col md:flex-row justify-between md:gap-4">
                    <Card class="!p-2 w-full">
                        <h1 class="text-2xl">{{ __('Downloads') }}</h1>
                        <div class="flex flex-wrap justify-center gap-4">
                            <Card class="w-full lg:w-1/4 !shadow-none !overflow-visible flex-1 " :fancy-p="false">
                                <a :heading="__('Download Attendance')" :cta-text="__('Download Attendance')"
                                            :href="route('export.attendance')">
                                    <TableIcon class="!mb-4 !h-12 !w-12 text-purple-500"/>
                                    
                                <h3>Download Attendance</h3>
                                </a>
                            </Card>
                            <Card class="w-full lg:w-1/4 !shadow-none !overflow-visible flex-1 " :fancy-p="false">
                                <a :heading="__('Download Absences')" :cta-text="__('Download Absences')"
                                            :href="route('export.absences')">
                                    <AkPersonCross class="!mb-4 !h-12 !w-12 text-purple-500"/>
                                    
                                <h3>Download Absences</h3>
                                </a>
                            </Card>
                            <Card class="w-full lg:w-1/4 !shadow-none !overflow-visible flex-1 " :fancy-p="false">
                                <a :heading="__('Download Payroll')" :cta-text="__('Download Payroll')"
                                            :href="route('export.payroll')">
                                    <MoneyIcon class="!mb-4 !h-12 !w-12 text-purple-500"/>
                                    
                                <h3>Download Payroll</h3>
                                </a>
                            </Card>
                            </div>
                    </Card>
            </div>


        </div>
    </AuthenticatedLayout>
</template>

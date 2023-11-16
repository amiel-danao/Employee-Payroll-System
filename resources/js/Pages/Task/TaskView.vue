<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm, router} from '@inertiajs/vue3';
import {ref} from "vue";
import TaskTabs from "@/Components/Tabs/TaskTabs.vue";
import {useToast} from "vue-toastification";
import GenericButton from "@/Components/GenericButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import FileInput from "@/Components/FileInput.vue";
import InputError from "@/Components/InputError.vue";
import Swal from "sweetalert2";
import Card from "@/Components/Card.vue";
import CheckIcon from "@/Components/Icons/CheckIcon.vue";
import XIcon from "@/Components/Icons/XIcon.vue";
import DescriptionList from "@/Components/DescriptionList/DescriptionList.vue";
import DT from "@/Components/DescriptionList/DT.vue";
import DD from "@/Components/DescriptionList/DD.vue";
import DescriptionListItem from "@/Components/DescriptionList/DescriptionListItem.vue";
import {__} from "@/Composables/useTranslations.js";
import {task_status_types} from "@/Composables/useTaskStatusTypes.js";
import axios from 'axios';
// import { router } from '@inertiajs/vue3'

const props = defineProps({
    task: Object,
    ongoingTasksCount: Number,
})
const message = ref("");
const form = useForm({
    status: '',
    file_path: null
    // admin_response: '',
});

const submit = () => {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            cancelButton: 'mx-4 text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900',
            confirmButton: 'text-white bg-purple-700 hover:bg-purple-800 focus:outline-none focus:ring-4 focus:ring-purple-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900'
        },
        buttonsStyling: false
    })
    let title = __('Are you sure You want to :sth this task?', {sth: message.value});

    if(message.value == 'done'){
        title = __('Are you sure You want to mark this task as Done?')
    }

    swalWithBootstrapButtons.fire({
        title: title,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: __('Confirm'),
        cancelButtonText: __('Cancel'),
        inputLabel: message.value === __('reject') ? __('(Optional) Provide a reason for rejecting this task:') : '',
        input: message.value === __('reject') ? 'textarea' : '',
        inputPlaceholder: message.value === __('reject') ?
            __('We can\'t accept this leave this week as Mark and Jose will be off and we will be understaffed.') : '',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            form.post(route('zzz.update', {id: props.task.id}), {
                preserveScroll: true,
                onError: () => {
                    useToast().error(__('Error Updating Task Status'));
                },
                onSuccess: () => {
                    useToast().success(__('Task Status Updated Successfully'));
                }
            });
        }
    })
};


  const handleFileChange = (event) => {
        const file = event.target.files[0]; // Get the selected file
        form.file_path = file; // Set the form's file_path to the File object
      };
    
const destroy = () => {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'mx-4 text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900',
            cancelButton: 'text-white bg-purple-700 hover:bg-purple-800 focus:outline-none focus:ring-4 focus:ring-purple-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        title: __('Are you sure?'),
        text: __('You won\'t be able to revert this!'),
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: __('Yes, Delete!'),
        cancelButtonText: __('No, Cancel!'),
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            form.delete(route('zzz.destroy', {id: props.task.id}), {
                preserveScroll: true,
                onError: () => {
                    useToast().error(__('Error Deleting Task'));
                },
                onSuccess: () => {
                    Swal.fire(__('Task Removed!'), '', 'success')
                }
            });
        }
    })
};

</script>

<template>
    <Head :title="__('Task Data')"/>
    <AuthenticatedLayout>
        <template #tabs>
            <TaskTabs />
        </template>
        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Card class="!mt-0">
                    <div>
                        <h1 class="card-header mb-2">{{__('Task #:id Data', {id: task.id})}}</h1>

                        <h2 class="mb-2 ml-1 font-semibold">{{__('Task Info')}}</h2>

                        <DescriptionList>
                            <DescriptionListItem colored>
                                <DT>{{__('ID')}}</DT>
                                <DD>{{ task.id }}</DD>
                            </DescriptionListItem>

                            <DescriptionListItem colored>
                                <DT>{{__('Employee Assigned')}}</DT>
                                <DD>{{ task.employee == null? 'None' : task.employee.name }}</DD>
                            </DescriptionListItem>


                            <DescriptionListItem colored>
                                <DT>{{__('Task Description')}}</DT>
                                <DD>{{ task.description }}</DD>
                            </DescriptionListItem>

                            <DescriptionListItem >
                                <DT>{{__('From Date')}}</DT>
                                <DD>{{ task.start_date }}</DD>
                            </DescriptionListItem>

                            <DescriptionListItem >
                                <DT>{{__('To Date')}}</DT>
                                <DD>{{ task.end_date ?? __('N/A') }}</DD>
                            </DescriptionListItem>

                            <DescriptionListItem colored>
                                <DT>{{__('Date Taken')}}</DT>
                                <DD>{{  task.date_taken == null? 'N/A': task.date_taken }}</DD>
                            </DescriptionListItem>

                            <DescriptionListItem colored>
                                <DT>{{__('Date Completed')}}</DT>
                                <DD>{{  task.date_completed == null? 'N/A': task.date_completed }}</DD>
                            </DescriptionListItem>

                            <DescriptionListItem colored>
                                <DT>{{__('Status')}}</DT>
                                <DD>{{  props.task.status === "Available" ? task_status_types['available'] + ' ❇️' :
                                        props.task.status === "Ongoing" ? task_status_types['ongoing'] + ' ⏳' :
                                        props.task.status === "Done" ? task_status_types['done'] + ' ✅' :
                                        props.task.status === "Approved" ? task_status_types['approved'] + ' 👌' :
                                            task_status_types['rejected'] + ' 🚫'
                                    }}</DD>
                            </DescriptionListItem>


                            <DescriptionListItem colored>
                                <DT></DT><DD></DD>
                            </DescriptionListItem>
                        </DescriptionList>

                        <div class="flex justify-between items-center mb-4">
                            
                            
                            <div  class="flex inline-flex gap-4">
                                <form @submit.prevent="submit"  class="flex gap-4" enctype="multipart/form-data">
                                    <div v-if="!$page.props.auth.user.roles.includes('admin') ">
                                    <div v-if="task.employee != null && task.employee.id == $page.props.auth.user.id" class="grid grid-cols-2 gap-4">
                                            <div v-if="(task.status === 'Ongoing' || task.status === 'Rejected')">
                                                <InputLabel for="file_path" :value="__('File Upload')"/>
                                                
                                                <!-- <FileInput
                                                    name="file_path"
                                                    id="file_path"
                                                    class="mt-1 block w-full"
                                                    :class="{'border-2 border-red-500 ': form.errors.file_path}"
                                                    v-model="form.file_path"
                                                /> -->
                                                <input id="file_path" type="file" @change="handleFileChange" />

                                                <InputError class="mt-2" :message="form.errors.file_path"/>
                                            </div>                                            
                                        </div>

                                    <div v-if="ongoingTasksCount < 5">
                                        
                                        <GenericButton v-if="task.status === 'Available' && task.employee == null" :text="__('Accept Task')"
                                                    @click="form.status = 1; message=__('accept');"
                                                    :class="{ 'opacity-25': form.processing }"
                                                    :disabled="form.processing">
                                            <CheckIcon/>
                                        </GenericButton>
                                    </div>
                                    <div v-else-if="task.status === 'Available'">
                                        <p>You can only do 5 tasks at a time</p>
                                    </div>
                                    <GenericButton v-if="(task.status === 'Ongoing' || task.status === 'Rejected')  && task.employee != null && task.employee.id == $page.props.auth.user.id" :text="__('Mark as Done')"
                                                   @click="form.status = 2; message=__('done');"
                                                   :class="{ 'opacity-25': form.processing }"
                                                   :disabled="form.processing">
                                        <CheckIcon/>
                                    </GenericButton>

                                    </div>
                                    <div v-else>
                                        <GenericButton v-if="task.status === 'Done' && task.employee != null" :text="__('Approve')"
                                            @click="form.status = 3; message=__('approved');"
                                            :class="{ 'opacity-25': form.processing }"
                                            :disabled="form.processing">
                                            <CheckIcon/>
                                        </GenericButton>

                                        <GenericButton v-if="task.status === 'Done' && task.employee != null" :text="__('Reject')"
                                            @click="form.status = 4; message=__('reject');"
                                            :class="{ 'opacity-25': form.processing }"
                                            :disabled="form.processing">
                                            <XIcon/>
                                        </GenericButton>
                                    </div>
                                </form>

                                <!-- <p v-if="task.status === 'Rejected'">Reject Reason:</p> -->

                                <div v-if="task.status != 'Available' && task.status != 'Ongoing'">
                                    <div v-if="task.file_path">
                                        <p>File uploaded:</p>
                                        <a :href="'/tasks/' + task.file_path" download class="font-medium text-purple-600 dark:text-purple-500 hover:underline">Download File</a>
                                    </div>
                                    <div v-else>
                                        <p>No file uploaded</p>
                                    </div>
                                </div>

                                
                            </div>
                            
                            
                        </div>

                        

                        <form v-if="$page.props.auth.user.roles.includes('admin')" @submit.prevent="destroy" class="flex justify-end">
                            <PrimaryButton class="bg-red-600 hover:bg-red-700 ml-4 mt-4 focus:bg-red-500 active:bg-red-900" >
                                {{__('Delete Task')}}
                            </PrimaryButton>
                        </form>
                    </div>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

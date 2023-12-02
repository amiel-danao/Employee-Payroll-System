<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm, usePage} from '@inertiajs/vue3';
import {useToast} from "vue-toastification";
import InputLabel from "@/Components/InputLabel.vue";
import TextArea from "@/Components/TextArea.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TaskTabs from "@/Components/Tabs/TaskTabs.vue";
import VueDatePicker from "@vuepic/vue-datepicker";
import '@vuepic/vue-datepicker/dist/main.css'
import dayjs from "dayjs";
import Card from "@/Components/Card.vue";
import {inject, watch} from "vue";
import {__} from "@/Composables/useTranslations.js";

defineProps({
    employees: Object
});

const form = useForm({
    due_date: '',
    description: '',
});

// watch(() => form.type, (value) => {
//     if (value === 'leave')
//         form.date = '';
// });

const submitForm = () => {
    Object.keys(form.due_date).forEach(function (key) {
        if (form.due_date[key] && !/^\d{4}-\d{2}-\d{2}$/.test(form.due_date[key])){
            form.due_date[key] = dayjs(form.due_date[key]).format('YYYY-MM-DD');
        }
    });
    console.log(form.due_date);
    form.post(route('zzz.store'), {
        preserveScroll: true,
        onError: () => {
            useToast().error(__('Error Creating Task'));
        },
        onSuccess: () => {
            useToast().success(__('Task Created Successfully'));
            form.reset();
        }
    });
};

</script>
<template>
    <Head :title="__('Task Create')"/>
    <AuthenticatedLayout>
        <template #tabs>
            <TaskTabs />
        </template>
        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Card class="!mt-0">
                    <h1 class="card-header !mb-4">{{__('Create a Task')}}</h1>
                    <form @submit.prevent="submitForm">
                        <div class="grid grid-cols-2 gap-4">
                            <!-- <div>
                                <InputLabel for="type_id" :value="__('Type')"/>
                                <select id="manager_id" class="fancy-selector" v-model="form.type">
                                    <option selected value="">{{__('Choose a Task Type')}}</option>
                                    <option v-for="type in types" :key="type.id" :value="type">
                                        {{ type }}
                                    </option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.type"/>
                            </div> -->
                            <div>
                                <InputLabel for="due_date" :value="__('Due Date (Range selection is available)')"/>
                                <VueDatePicker
                                    id="due_date"
                                    v-model="form.due_date"
                                    class="py-1 block w-full"
                                    :class="{'border border-red-500': form.errors.due_date}"
                                    :placeholder="__('Select Due Date...')"
                                    :enable-time-picker="false"
                                    :dark="inject('isDark').value"
                                    range
                                    required
                                ></VueDatePicker>
                                <InputError class="mt-2" :message="form.errors.due_date"/>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-4 mt-4">
                            <div>
                                <InputLabel for="description" :value="__('Description')"/>
                                <TextArea
                                    id="description"
                                    type="text"
                                    class="mt-1 block w-full"
                                    :class="{'border border-red-500': form.errors.description}"
                                    v-model="form.description"
                                    autocomplete="off"
                                    :placeholder="__('Task description')"
                                />
                                <InputError class="mt-2" :message="form.errors.description"/>
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <PrimaryButton class="ltr:ml-4 rtl:mr-4" :class="{ 'opacity-25': form.processing }"
                                           :disabled="form.processing">
                                {{__('Initiate Task')}}
                            </PrimaryButton>
                        </div>
                    </form>
                </Card>

            </div>
        </div>
    </AuthenticatedLayout>
</template>

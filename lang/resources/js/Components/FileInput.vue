<template>
    <input
      type="file"
      name="file_path"
      class="border-gray-300 focus:border-purple-500 focus:ring-purple-500 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500"
      :placeholder="placeholder"
      ref="input"
    />
  </template>
  
  <script setup>
  import { onMounted, ref, defineProps, defineExpose } from 'vue';
  
  defineProps({
    modelValue: {
      type: Object,
      required: false,
    },
    placeholder: {
      type: String,
      default: '',
    },
  });
  
  const input = ref(null);
  
  onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
      input.value.focus();
    }
  });
  
  defineExpose({ focus: () => input.value.focus() });
  
  </script>
  
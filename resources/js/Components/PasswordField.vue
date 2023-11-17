<template>
    <div class="relative flex items-center w-full p-0 border-gray-300 focus:border-purple-500 focus:ring-purple-500 rounded-l-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500">
      <input
        class="flex-1"
        :type="showPassword ? 'text' : 'password'"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        ref="input"
        :placeholder="placeholder"
      />
      <button type="button" @click="toggleVisibility" class="px-3 rounded-r-md bg-gray-200 dark:bg-gray-800">
        
        <AkEyeOpen v-if="showPassword"/>
        <AkEyeClosed v-else/>        
      </button>
    </div>
  </template>
  
  <script setup>
  import { onMounted, ref } from 'vue';
  import { AkEyeClosed } from "@kalimahapps/vue-icons";
  import { AkEyeOpen } from "@kalimahapps/vue-icons";

defineProps({
  modelValue: {
    type: String,
    required: false,
  },
  placeholder: {
    type: String,
    default: '',
  },
});

defineEmits(['update:modelValue']);

const input = ref(null);
const showPassword = ref(false);

onMounted(() => {
  if (input.value.hasAttribute('autofocus')) {
    input.value.focus();
  }
});

const toggleVisibility = () => {
  showPassword.value = !showPassword.value;
};

defineExpose({
  focus: () => input.value.focus(),
  showPassword,
  toggleVisibility,
});
  </script>
  
  <style scoped>
  input {
    /* Adjust input width and padding */
    padding: 0.75rem;
    border: none;
  }
  
  button {
    /* Adjust button padding */
    padding: 0.75rem;
  }
  </style>
  
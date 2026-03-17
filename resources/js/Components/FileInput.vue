<template>
    <div class="relative text-gray-900 focus-within:text-purple-600 dark:focus-within:text-blue-400">
      <input
        class="uppercase rounded block w-full pl-1 mt-1 text-sm text-black dark:text-gray-600 dark:border-gray-600 dark:bg-white focus:border-blue-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input"
        type="file"
        accept="image/*"
        :value="modelValue"
        @input="handleInput"
        ref="input"
        :placeholder="text"
        :required="required"
        :accept="accept"
        :disabled="disabled"
        :maxlength="maxlength"
      >
      <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
        <slot></slot>
      </div>
    </input>
  </div>
  </template>


    <script setup>
    import { onMounted, ref } from 'vue';
    defineProps(['modelValue', 'text', 'type', 'required', 'accept', 'disabled', 'maxlength']);
    defineEmits(['update:modelValue']);
    const input = ref(null);
    onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
    input.value.focus();
    }
    });

    
    </script>

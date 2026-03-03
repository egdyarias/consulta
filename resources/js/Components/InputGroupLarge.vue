<template>
    <div class="relative text-gray-900 focus-within:text-purple-600 dark:focus-within:text-blue-400">
        <textarea
            class="appearance-none rounded block w-full px-4 py-3 mt-1 text-sm text-left text-black dark:text-gray-600 dark:border-gray-600 dark:bg-white focus:border-blue-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray resize-y min-h-[170px] max-h-[170px] uppercase"
            :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" ref="input" :placeholder="text"
            :required="required" :accept="accept" style="overflow-wrap: break-word; white-space: normal;"
            :maxlength="maxlength" :minlength="minlength"></textarea>

        <div class="absolute inset-y-0 right-0 left-0 flex items-center pointer-events-none">
            <div class="ml-3">
                <slot></slot>
            </div>

            <!-- Contador de caracteres -->
        </div>
        <div v-if="maxlength" class="font-bold flex justify-end mr-3 text-sm text-gray-500 dark:text-gray-400">
    <div v-if="minlength">
        <div v-if="modelValue && modelValue.length < minlength" class="text-red-600">
            {{ modelValue?.length || 0 }}
        </div>
        <div v-else class="text-green-600">
            {{ modelValue?.length || 0 }}
        </div>
    </div>
    <div v-else class="text-green-600">
        {{ modelValue?.length || 0 }}
    </div>/{{ maxlength }}
</div>

    </div>
</template>

    <script setup>
    import { ref } from 'vue';
    defineProps(['modelValue', 'text', 'type', 'required', 'accept', 'maxlength', 'minlength']);
    defineEmits(['update:modelValue']);
    const input = ref(null);
    </script>

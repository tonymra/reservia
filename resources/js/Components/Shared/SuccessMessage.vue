<template>
    <div v-if="show && message" class="rounded-md bg-green-50 p-4"> <!-- Use `show` here -->
        <div class="flex">
            <div class="flex-shrink-0">
                <CheckCircleIcon class="h-5 w-5 text-green-400" aria-hidden="true" />
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-green-800">{{ message }}</p>
            </div>
            <div class="ml-auto pl-3">
                <div class="-mx-1.5 -my-1.5">
                    <button @click="dismiss" type="button" class="inline-flex rounded-md bg-green-50 p-1.5 text-green-500 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 focus:ring-offset-green-50">
                        <span class="sr-only">Dismiss</span>
                        <XMarkIcon class="h-5 w-5" aria-hidden="true" />
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>


<script setup>
import { ref } from 'vue';

import { CheckCircleIcon, XMarkIcon } from '@heroicons/vue/20/solid';
import { onMounted } from 'vue';

// Props
const props = defineProps({
    message: String
});
onMounted(() => {
    console.log(props.message);
});

const show = ref(true);

function dismiss() {
    show.value = false;
}
</script>


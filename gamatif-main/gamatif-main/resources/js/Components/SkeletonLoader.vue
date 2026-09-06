<template>
    <div
        class="bg-gray-200 rounded-md dark:bg-gray-700 animate-pulse"
        :class="customClass"
    ></div>
</template>

<script setup>
defineProps({
    customClass: {
        type: String,
        default: "h-4 w-full",
    },
});
</script>

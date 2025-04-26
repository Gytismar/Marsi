<!-- Components/Charts/InfoCard.vue -->
<template>
    <div class="bg-white p-6 rounded-xl shadow-lg border h-full flex flex-col justify-center items-center">
        <h3 class="text-xl font-bold mb-4">{{ title }}</h3>
        <p class="text-3xl font-semibold text-blue-600">{{ value }}</p>
    </div>
</template>

<script setup>
const props = defineProps({
    title: String,
    value: [String, Number],
});
</script>

<!-- Components/GriCard.vue -->
<template>
    <div
        @click="toggle"
        class="border rounded-lg p-6 shadow-md cursor-pointer transition-all hover:shadow-lg"
        :class="gri.available ? 'bg-white' : 'bg-gray-200 cursor-not-allowed opacity-50'"
    >
        <h2 class="text-xl font-bold mb-2">{{ gri.title }}</h2>
        <p v-if="selected" class="text-green-600 font-semibold">Pasirinkta</p>
        <p v-else-if="gri.available" class="text-gray-600">Spauskite pasirinkti</p>
        <p v-else class="text-red-500">Nėra duomenų</p>
    </div>
</template>

<script setup>
const props = defineProps({
    gri: Object,
    selected: Boolean
});

const emit = defineEmits(['toggle']);

const toggle = () => {
    if (props.gri.available) {
        emit('toggle');
    }
};
</script>

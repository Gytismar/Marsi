<template>
    <div class="h-full flex flex-col">
        <h2 class="text-lg font-bold mb-4">{{ title }}</h2>
        <div class="flex-1 relative">
            <Radar :data="chartData" :options="chartOptions" />
        </div>
    </div>
</template>

<script setup>
import { Radar } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, RadialLinearScale, PointElement, LineElement, Filler } from 'chart.js';

ChartJS.register(Title, Tooltip, Legend, RadialLinearScale, PointElement, LineElement, Filler);

const props = defineProps({
    chartData: Object,
    title: String,
});

const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: { position: 'top' },
    },
    scales: {
        r: {
            beginAtZero: true,
        },
    },
};
</script>

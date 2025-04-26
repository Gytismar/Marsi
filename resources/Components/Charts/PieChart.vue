<template>
    <div class="h-full flex flex-col">
        <h2 class="text-lg font-bold mb-4">{{ title }}</h2>
        <div class="flex-1 relative">
            <Pie :data="chartData" :options="chartOptions" />
        </div>
    </div>
</template>

<script setup>
import { Pie } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, ArcElement } from 'chart.js';

// Register chart.js modules
ChartJS.register(Title, Tooltip, Legend, ArcElement);

// Props
const props = defineProps({
    chartData: Object,
    title: String,
});

// Chart Options
const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            position: 'bottom',
            labels: {
                font: {
                    size: 14,
                },
            },
        },
        tooltip: {
            callbacks: {
                label: function (tooltipItem) {
                    const dataset = tooltipItem.dataset;
                    const data = dataset.data;
                    const total = data.reduce((sum, value) => sum + value, 0);
                    const value = dataset.data[tooltipItem.dataIndex];
                    const percentage = ((value / total) * 100).toFixed(1);
                    return `${tooltipItem.label}: ${value} (${percentage}%)`;
                }
            }
        },
        title: {
            display: false,
        },
    },
};
</script>

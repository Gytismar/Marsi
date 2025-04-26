<template>
    <div class="h-full flex flex-col">
        <h2 class="text-lg font-bold mb-4">{{ title }}</h2>
        <div class="flex-1 relative">
            <Doughnut :data="chartData" :options="chartOptions" />
        </div>
    </div>
</template>

<script setup>
import { Doughnut } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, ArcElement } from 'chart.js';

ChartJS.register(Title, Tooltip, Legend, ArcElement);

const props = defineProps({
    chartData: Object,
    title: String,
});

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

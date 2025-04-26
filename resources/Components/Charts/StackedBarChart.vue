<template>
    <div class="h-full flex flex-col">
        <h2 class="text-lg font-bold mb-4">{{ title }}</h2>
        <div class="flex-1 relative">
            <Bar :data="chartData" :options="chartOptions" />
        </div>
    </div>
</template>

<script setup>
import { Bar } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js';

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);

const props = defineProps({
    chartData: Object,
    title: String,
});

const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: { position: 'top' },
        tooltip: {
            callbacks: {
                label: function(context) {
                    const dataset = context.dataset;
                    const value = context.raw;
                    const total = context.chart.data.datasets.reduce((sum, ds) => {
                        return sum + (ds.data[context.dataIndex] || 0);
                    }, 0);
                    const percentage = total ? ((value / total) * 100).toFixed(1) : 0;
                    return `${dataset.label}: ${value} (${percentage}%)`;
                }
            }
        }
    },
    scales: {
        x: {
            stacked: true,
        },
        y: {
            stacked: true,
            beginAtZero: true,
        },
    },
};
</script>

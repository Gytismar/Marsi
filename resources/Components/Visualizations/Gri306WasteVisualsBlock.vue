<template>
    <div class="p-8 w-full mx-auto" style="max-width: 1800px;">
        <h1 class="text-3xl font-bold mb-8">GRI 306 Atliekų vizualizacijos</h1>

        <!-- Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
            <InfoCard :title="`Bendras atliekų kiekis`" :value="totalWasteFormatted" />
            <InfoCard :title="`Perdirbtos atliekos`" :value="totalRecycledFormatted" />
            <InfoCard :title="`Atskaitos laikotarpis`" :value="periodLabel" />
        </div>

        <!-- Charts -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div v-if="wasteChartData?.datasets?.length" class="chart-block">
                <StackedBarChart :chart-data="wasteChartData" title="Pavojingos ir nepavojingos atliekos pagal metus" />
            </div>

            <div v-if="recyclingTrend?.datasets?.length" class="chart-block">
                <LineChart :chart-data="recyclingTrend" title="Perdirbimo tendencija per metus" />
            </div>

            <div v-if="disposalMethodDistribution?.datasets?.length" class="chart-block">
                <PieChart :chart-data="disposalMethodDistribution" title="Atliekų šalinimo būdų pasiskirstymas" />
            </div>

            <!-- Optional: Add total waste trend -->
            <div v-if="totalWasteTrend?.datasets?.length" class="chart-block">
                <LineChart :chart-data="totalWasteTrend" title="Bendras atliekų kiekio pokytis" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';

import InfoCard from '../Charts/InfoCard.vue';
import StackedBarChart from '../Charts/StackedBarChart.vue';
import LineChart from '../Charts/LineChart.vue';
import PieChart from '../Charts/PieChart.vue';

const wasteChartData = ref({ labels: [], datasets: [] });
const recyclingTrend = ref({ labels: [], datasets: [] });
const disposalMethodDistribution = ref({ labels: [], datasets: [] });
const totalWasteTrend = ref({ labels: [], datasets: [] });

const totalWaste = ref(0);
const totalRecycled = ref(0);
const firstYear = ref(null);
const lastYear = ref(null);

onMounted(async () => {
    const response = await axios.get('/api/v1/gri/g306-waste');
    const data = response.data ?? [];

    const hazardous = {}, nonhazardous = {}, recycled = {}, disposalMethods = {}, totalWasteYearly = {};

    data.forEach(d => {
        const year = d.reporting_year;
        hazardous[year] = (hazardous[year] || 0) + (parseFloat(d.hazardous_waste_generated) || 0);
        nonhazardous[year] = (nonhazardous[year] || 0) + (parseFloat(d.nonhazardous_waste_generated) || 0);
        recycled[year] = (recycled[year] || 0) + (parseFloat(d.waste_recycled) || 0);
        disposalMethods[d.disposal_method] = (disposalMethods[d.disposal_method] || 0) + 1;

        totalWaste.value += (parseFloat(d.total_waste_generated) || 0);
        totalRecycled.value += (parseFloat(d.waste_recycled) || 0);

        totalWasteYearly[year] = (totalWasteYearly[year] || 0) + (parseFloat(d.total_waste_generated) || 0);
    });

    const years = Object.keys(hazardous).sort((a, b) => a - b);
    firstYear.value = years[0];
    lastYear.value = years.at(-1);

    wasteChartData.value = {
        labels: years,
        datasets: [
            {
                label: 'Pavojingos atliekos (t)',
                data: years.map(y => hazardous[y]),
                backgroundColor: '#E53935',
            },
            {
                label: 'Nepavojingos atliekos (t)',
                data: years.map(y => nonhazardous[y]),
                backgroundColor: '#43A047',
            }
        ]
    };

    recyclingTrend.value = {
        labels: years,
        datasets: [{
            label: 'Perdirbtos atliekos (t)',
            data: years.map(y => recycled[y]),
            borderColor: '#FB8C00',
            tension: 0.4,
        }]
    };

    disposalMethodDistribution.value = {
        labels: Object.keys(disposalMethods),
        datasets: [{
            label: 'Atliekų šalinimo būdai',
            data: Object.values(disposalMethods),
            backgroundColor: generateColors(Object.keys(disposalMethods).length),
        }]
    };

    totalWasteTrend.value = {
        labels: years,
        datasets: [{
            label: 'Bendras atliekų kiekis (t)',
            data: years.map(y => totalWasteYearly[y]),
            borderColor: '#3949AB',
            tension: 0.4,
        }]
    };
});

// Computed for cards
const totalWasteFormatted = computed(() => `${totalWaste.value.toLocaleString('lt-LT')} t`);
const totalRecycledFormatted = computed(() => `${totalRecycled.value.toLocaleString('lt-LT')} t`);
const periodLabel = computed(() => firstYear.value && lastYear.value ? `${firstYear.value}–${lastYear.value}` : '');

function generateColors(count) {
    const baseColors = ['#4CAF50', '#FFC107', '#03A9F4', '#E91E63', '#9C27B0', '#FF5722', '#795548', '#607D8B'];
    return Array.from({ length: count }, (_, i) => baseColors[i % baseColors.length]);
}
</script>

<style scoped>
.chart-block {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    border: 1px solid #eee;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    height: 400px;
}
</style>

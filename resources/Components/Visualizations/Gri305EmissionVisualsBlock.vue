<template>
    <div class="p-8 w-full mx-auto" style="max-width: 1800px;">
        <h1 class="text-3xl font-bold mb-8">GRI 305 Emisijų vizualizacijos</h1>

        <!-- Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
            <InfoCard :title="`Bendros tiesioginės emisijos (Scope 1)`" :value="totalScope1Formatted" />
            <InfoCard :title="`Netiesioginės emisijos (Scope 2)`" :value="totalScope2Formatted" />
            <InfoCard :title="`Atskaitos laikotarpis`" :value="periodLabel" />
        </div>

        <!-- Charts -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div v-if="scopeChartData?.datasets?.length" class="chart-block">
                <StackedBarChart :chart-data="scopeChartData" title="Scope 1, 2, 3 emisijos pagal metus" />
            </div>

            <div v-if="ghgIntensityTrend?.datasets?.length" class="chart-block">
                <LineChart :chart-data="ghgIntensityTrend" title="ŠESD intensyvumo pokytis per metus" />
            </div>

            <div v-if="scopeDistributionData?.datasets?.length" class="chart-block">
                <PieChart :chart-data="scopeDistributionData" title="Scope emisijų pasiskirstymas" />
            </div>

            <!-- ✅ NEW CHART: Total emissions over years -->
            <div v-if="totalEmissionsTrend?.datasets?.length" class="chart-block">
                <LineChart :chart-data="totalEmissionsTrend" title="Bendros emisijos (Scope 1+2+3) pagal metus" />
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

// Chart data refs
const scopeChartData = ref({ labels: [], datasets: [] });
const ghgIntensityTrend = ref({ labels: [], datasets: [] });
const scopeDistributionData = ref({ labels: [], datasets: [] });
const totalEmissionsTrend = ref({ labels: [], datasets: [] }); // <-- 🔥 New chart

// Totals
const totalScope1 = ref(0);
const totalScope2 = ref(0);
const firstYear = ref(null);
const lastYear = ref(null);

onMounted(async () => {
    const response = await axios.get('/api/v1/gri/g305-emissions');
    const data = response.data ?? [];

    const scope1 = {}, scope2 = {}, scope3 = {}, ghgIntensity = {}, totalEmissions = {};

    data.forEach(d => {
        const year = d.reporting_year;
        const s1 = parseFloat(d.scope_1) || 0;
        const s2 = parseFloat(d.scope_2) || 0;
        const s3 = parseFloat(d.scope_3) || 0;

        scope1[year] = (scope1[year] || 0) + s1;
        scope2[year] = (scope2[year] || 0) + s2;
        scope3[year] = (scope3[year] || 0) + s3;
        ghgIntensity[year] = (ghgIntensity[year] || 0) + (parseFloat(d.ghg_intensity) || 0);

        totalEmissions[year] = (totalEmissions[year] || 0) + (s1 + s2 + s3);

        totalScope1.value += s1;
        totalScope2.value += s2;
    });

    const years = Object.keys(scope1).sort((a, b) => a - b);

    firstYear.value = years[0];
    lastYear.value = years.at(-1);

    scopeChartData.value = {
        labels: years,
        datasets: [
            {
                label: 'Scope 1 emisijos',
                data: years.map(y => scope1[y]),
                backgroundColor: '#66BB6A',
            },
            {
                label: 'Scope 2 emisijos',
                data: years.map(y => scope2[y]),
                backgroundColor: '#42A5F5',
            },
            {
                label: 'Scope 3 emisijos',
                data: years.map(y => scope3[y]),
                backgroundColor: '#FFA726',
            },
        ]
    };

    ghgIntensityTrend.value = {
        labels: years,
        datasets: [
            {
                label: 'ŠESD intensyvumas (tCO2e/įvykis)',
                data: years.map(y => ghgIntensity[y]),
                borderColor: '#AB47BC',
                tension: 0.4,
            }
        ]
    };

    scopeDistributionData.value = {
        labels: ['Scope 1', 'Scope 2', 'Scope 3'],
        datasets: [{
            data: [
                Object.values(scope1).reduce((a, b) => a + b, 0),
                Object.values(scope2).reduce((a, b) => a + b, 0),
                Object.values(scope3).reduce((a, b) => a + b, 0),
            ],
            backgroundColor: ['#66BB6A', '#42A5F5', '#FFA726']
        }]
    };

    totalEmissionsTrend.value = {
        labels: years,
        datasets: [{
            label: 'Bendros emisijos (tCO2e)',
            data: years.map(y => totalEmissions[y]),
            borderColor: '#FF5722',
            tension: 0.4,
        }]
    };
});

// Computed for Info Cards
const totalScope1Formatted = computed(() => totalScope1.value.toLocaleString('lt-LT') + ' tCO2e');
const totalScope2Formatted = computed(() => totalScope2.value.toLocaleString('lt-LT') + ' tCO2e');
const periodLabel = computed(() => firstYear.value && lastYear.value ? `${firstYear.value}–${lastYear.value}` : '');
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

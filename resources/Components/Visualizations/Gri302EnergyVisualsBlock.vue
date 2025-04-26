<template>
    <div class="p-8 w-full mx-auto" style="max-width: 1800px;">
        <h1 class="text-3xl font-bold mb-8">GRI 302 Energijos vizualizacijos</h1>

        <!-- Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
            <InfoCard :title="`Bendras energijos suvartojimas`" :value="totalEnergyFormatted" />
            <InfoCard :title="`Atsinaujinanti energija (naujausiais metais)`" :value="latestRenewableFormatted" />
            <InfoCard :title="`Atskaitos laikotarpis`" :value="periodLabel" />
        </div>

        <!-- Charts -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div v-if="energyChartData?.datasets?.length" class="chart-block">
                <BarChart :chart-data="energyChartData" title="Bendras energijos suvartojimas pagal metus" />
            </div>

            <div v-if="sourceChartData?.datasets?.length" class="chart-block">
                <PieChart :chart-data="sourceChartData" title="Energijos šaltinių pasiskirstymas" />
            </div>

            <div v-if="lineChartData?.datasets?.length" class="chart-block">
                <LineChart :chart-data="lineChartData" title="Energijos suvartojimo tendencija" />
            </div>

            <div v-if="groupedBarChartData?.datasets?.length" class="chart-block">
                <GroupedBarChart :chart-data="groupedBarChartData" title="Atsinaujinanti vs Neatsinaujinanti energija" />
            </div>

            <div v-if="doughnutChartData?.datasets?.length" class="chart-block">
                <DoughnutChart :chart-data="doughnutChartData" title="Atsinaujinančios ir neatsinaujinančios energijos dalis (naujausi metai)" />
            </div>

            <div v-if="radarChartData?.datasets?.length" class="chart-block">
                <RadarChart :chart-data="radarChartData" title="Energijos intensyvumo pokyčiai" />
            </div>

            <div v-if="stackedBarChartData?.datasets?.length" class="chart-block">
                <StackedBarChart :chart-data="stackedBarChartData" title="Energijos šaltinių sudėtis pagal metus" />
            </div>

            <div v-if="renewableShareData?.datasets?.length" class="chart-block">
                <LineChart :chart-data="renewableShareData" title="Atsinaujinančios energijos dalis (%) per metus" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';

import InfoCard from '../Charts/InfoCard.vue';
import BarChart from '../Charts/BarChart.vue';
import PieChart from '../Charts/PieChart.vue';
import LineChart from '../Charts/LineChart.vue';
import GroupedBarChart from '../Charts/GroupedBarChart.vue';
import DoughnutChart from '../Charts/DoughnutChart.vue';
import RadarChart from '../Charts/RadarChart.vue';
import StackedBarChart from '../Charts/StackedBarChart.vue';

const energyChartData = ref({ labels: [], datasets: [] });
const sourceChartData = ref({ labels: [], datasets: [] });
const lineChartData = ref({ labels: [], datasets: [] });
const groupedBarChartData = ref({ labels: [], datasets: [] });
const doughnutChartData = ref({ labels: [], datasets: [] });
const radarChartData = ref({ labels: [], datasets: [] });
const stackedBarChartData = ref({ labels: [], datasets: [] });
const renewableShareData = ref({ labels: [], datasets: [] });

const totalEnergy = ref(0);
const latestRenewable = ref(0);
const firstYear = ref(null);
const lastYear = ref(null);

onMounted(async () => {
    const response = await axios.get('/api/v1/gri/g302-energy');
    const data = response.data ?? [];

    const yearTotals = {}, renewableTotals = {}, nonrenewableTotals = {}, sourceTotals = {}, energyIntensity = {}, stackedSources = {};

    data.forEach(d => {
        const year = d.reporting_year;
        const total = parseFloat(d.total_energy_consumed) || 0;
        const renewable = parseFloat(d.renewable_energy_consumed) || 0;
        const nonrenewable = parseFloat(d.nonrenewable_energy_consumed) || 0;
        const intensity = parseFloat(d.energy_intensity) || 0;
        const source = d.source || 'Nežinomas šaltinis';

        yearTotals[year] = (yearTotals[year] || 0) + total;
        renewableTotals[year] = (renewableTotals[year] || 0) + renewable;
        nonrenewableTotals[year] = (nonrenewableTotals[year] || 0) + nonrenewable;
        energyIntensity[year] = (energyIntensity[year] || 0) + intensity;
        sourceTotals[source] = (sourceTotals[source] || 0) + total;

        if (!stackedSources[year]) stackedSources[year] = {};
        stackedSources[year][source] = (stackedSources[year][source] || 0) + total;

        totalEnergy.value += total;
    });

    const years = Object.keys(yearTotals ?? {}).sort((a, b) => a - b);

    firstYear.value = years[0];
    lastYear.value = years.at(-1);

    const latestYear = lastYear.value;

    energyChartData.value = {
        labels: years,
        datasets: [{ label: 'Energija (kWh)', data: years.map(y => yearTotals[y]), backgroundColor: 'rgba(54, 162, 235, 0.6)' }]
    };

    sourceChartData.value = {
        labels: Object.keys(sourceTotals),
        datasets: [{ label: 'Šaltiniai', data: Object.values(sourceTotals), backgroundColor: generateColors(Object.keys(sourceTotals).length) }]
    };

    lineChartData.value = {
        labels: years,
        datasets: [{ label: 'Bendras energijos suvartojimas', data: years.map(y => yearTotals[y]), borderColor: '#42A5F5', tension: 0.4 }]
    };

    groupedBarChartData.value = {
        labels: years,
        datasets: [
            { label: 'Atsinaujinanti energija (kWh)', data: years.map(y => renewableTotals[y] || 0), backgroundColor: '#4CAF50' },
            { label: 'Neatsinaujinanti energija (kWh)', data: years.map(y => nonrenewableTotals[y] || 0), backgroundColor: '#F44336' }
        ]
    };

    doughnutChartData.value = {
        labels: ['Atsinaujinanti', 'Neatsinaujinanti'],
        datasets: [{ data: [renewableTotals[latestYear] || 0, nonrenewableTotals[latestYear] || 0], backgroundColor: ['#4CAF50', '#F44336'] }]
    };

    radarChartData.value = {
        labels: years,
        datasets: [{ label: 'Energijos intensyvumas', data: years.map(y => energyIntensity[y] || 0), borderColor: '#FF6384', backgroundColor: 'rgba(255,99,132,0.4)' }]
    };

    stackedBarChartData.value = {
        labels: years,
        datasets: Object.keys(sourceTotals).map(source => ({
            label: source,
            data: years.map(year => stackedSources[year]?.[source] || 0),
            backgroundColor: randomColor()
        }))
    };

    renewableShareData.value = {
        labels: years,
        datasets: [{
            label: 'Atsinaujinančios energijos dalis (%)',
            data: years.map(y => {
                const total = yearTotals[y] ?? 0;
                const renewable = renewableTotals[y] ?? 0;
                return total > 0 ? ((renewable / total) * 100).toFixed(2) : 0;
            }),
            borderColor: '#66BB6A',
            tension: 0.3
        }]
    };
});

const totalEnergyFormatted = computed(() => `${totalEnergy.value.toLocaleString('lt-LT')} kWh`);
const latestRenewableFormatted = computed(() => `${latestRenewable.value.toLocaleString('lt-LT')} kWh`);
const periodLabel = computed(() => firstYear.value && lastYear.value ? `${firstYear.value}–${lastYear.value}` : '');

function randomColor() {
    const colors = ['#4CAF50', '#FFC107', '#03A9F4', '#E91E63', '#9C27B0', '#FF5722', '#795548', '#607D8B'];
    return colors[Math.floor(Math.random() * colors.length)];
}

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

<template>
    <AppLayout>
        <div class="p-8 w-full mx-auto" style="max-width: 1800px;">
            <h1 class="text-3xl font-bold mb-8">GRI 302 Energijos vizualizacijos</h1>

            <!-- Top Info Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
                <InfoCard :title="`Bendras energijos suvartojimas`" :value="totalEnergyFormatted" />
                <InfoCard :title="`Atsinaujinanti energija (naujausiais metais)`" :value="latestRenewableFormatted" />
                <InfoCard :title="`Atskaitos laikotarpis`" :value="periodLabel" />
            </div>

            <!-- Charts -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <div v-if="energyChartData?.datasets?.length" class="bg-white p-6 rounded-xl shadow-lg border" style="height: 400px;">
                    <BarChart :chart-data="energyChartData" title="Bendras energijos suvartojimas pagal metus" />
                </div>

                <div v-if="sourceChartData?.datasets?.length" class="bg-white p-6 rounded-xl shadow-lg border" style="height: 400px;">
                    <PieChart :chart-data="sourceChartData" title="Energijos šaltinių pasiskirstymas" />
                </div>

                <div v-if="lineChartData?.datasets?.length" class="bg-white p-6 rounded-xl shadow-lg border" style="height: 400px;">
                    <LineChart :chart-data="lineChartData" title="Energijos suvartojimo tendencija" />
                </div>

                <div v-if="groupedBarChartData?.datasets?.length" class="bg-white p-6 rounded-xl shadow-lg border" style="height: 400px;">
                    <GroupedBarChart :chart-data="groupedBarChartData" title="Atsinaujinanti vs Neatsinaujinanti energija" />
                </div>

                <div v-if="doughnutChartData?.datasets?.length" class="bg-white p-6 rounded-xl shadow-lg border" style="height: 400px;">
                    <DoughnutChart :chart-data="doughnutChartData" title="Atsinaujinančios ir neatsinaujinančios energijos dalis (naujausi metai)" />
                </div>

                <div v-if="radarChartData?.datasets?.length" class="bg-white p-6 rounded-xl shadow-lg border" style="height: 400px;">
                    <RadarChart :chart-data="radarChartData" title="Energijos intensyvumo pokyčiai" />
                </div>

                <div v-if="stackedBarChartData?.datasets?.length" class="bg-white p-6 rounded-xl shadow-lg border" style="height: 400px;">
                    <StackedBarChart :chart-data="stackedBarChartData" title="Energijos šaltinių sudėtis pagal metus" />
                </div>

                <div v-if="renewableShareData?.datasets?.length" class="bg-white p-6 rounded-xl shadow-lg border" style="height: 400px;">
                    <LineChart :chart-data="renewableShareData" title="Atsinaujinančios energijos dalis (%) per metus" />
                </div>

            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';
import AppLayout from '../Layouts/AppLayout.vue';

import InfoCard from '../Components/Charts/InfoCard.vue';
import BarChart from '../Components/Charts/BarChart.vue';
import PieChart from '../Components/Charts/PieChart.vue';
import LineChart from '../Components/Charts/LineChart.vue';
import GroupedBarChart from '../Components/Charts/GroupedBarChart.vue';
import DoughnutChart from '../Components/Charts/DoughnutChart.vue';
import RadarChart from '../Components/Charts/RadarChart.vue';
import StackedBarChart from '../Components/Charts/StackedBarChart.vue';

// Chart data refs
const energyChartData = ref({ labels: [], datasets: [] });
const sourceChartData = ref({ labels: [], datasets: [] });
const lineChartData = ref({ labels: [], datasets: [] });
const groupedBarChartData = ref({ labels: [], datasets: [] });
const doughnutChartData = ref({ labels: [], datasets: [] });
const radarChartData = ref({ labels: [], datasets: [] });
const stackedBarChartData = ref({ labels: [], datasets: [] });
const renewableShareData = ref({ labels: [], datasets: [] }); // <--- NEW

// Totals
const totalEnergy = ref(0);
const latestRenewable = ref(0);
const firstYear = ref(null);
const lastYear = ref(null);

onMounted(async () => {
    const response = await axios.get('/api/v1/gri/g302-energy');
    const data = response.data ?? [];

    const yearTotals = {};
    const renewableTotals = {};
    const nonrenewableTotals = {};
    const sourceTotals = {};
    const energyIntensity = {};
    const stackedSources = {};

    data.forEach(d => {
        const year = d.reporting_year;
        const totalEnergyConsumed = parseFloat(d.total_energy_consumed) || 0;
        const renewable = parseFloat(d.renewable_energy_consumed) || 0;
        const nonrenewable = parseFloat(d.nonrenewable_energy_consumed) || 0;
        const intensity = parseFloat(d.energy_intensity) || 0;
        const source = d.source || 'Nežinomas šaltinis';

        yearTotals[year] = (yearTotals[year] || 0) + totalEnergyConsumed;
        renewableTotals[year] = (renewableTotals[year] || 0) + renewable;
        nonrenewableTotals[year] = (nonrenewableTotals[year] || 0) + nonrenewable;
        energyIntensity[year] = (energyIntensity[year] || 0) + intensity;
        sourceTotals[source] = (sourceTotals[source] || 0) + totalEnergyConsumed;

        if (!stackedSources[year]) stackedSources[year] = {};
        stackedSources[year][source] = (stackedSources[year][source] || 0) + totalEnergyConsumed;

        totalEnergy.value += totalEnergyConsumed;
    });

    const years = Object.keys(yearTotals ?? {}).sort((a, b) => a - b);
    const validYears = years.length > 0 ? years : [];

    firstYear.value = Math.min(...years);
    lastYear.value = Math.max(...years);

    const latestYear = Math.max(...validYears.map(Number) || [0]);
    latestRenewable.value = renewableTotals[latestYear] ?? 0;

    energyChartData.value = {
        labels: validYears,
        datasets: [{
            label: 'Energija (kWh)',
            data: validYears.map(year => yearTotals[year] ?? 0),
            backgroundColor: 'rgba(54, 162, 235, 0.6)',
        }]
    };

    sourceChartData.value = {
        labels: Object.keys(sourceTotals),
        datasets: [{
            label: 'Šaltiniai',
            data: Object.values(sourceTotals),
            backgroundColor: generateColors(Object.keys(sourceTotals).length),
        }]
    };

    lineChartData.value = {
        labels: validYears,
        datasets: [{
            label: 'Bendras energijos suvartojimas',
            data: validYears.map(year => yearTotals[year] ?? 0),
            fill: false,
            borderColor: '#42A5F5',
            tension: 0.4,
        }]
    };

    groupedBarChartData.value = {
        labels: validYears,
        datasets: [
            {
                label: 'Atsinaujinanti energija (kWh)',
                data: validYears.map(year => renewableTotals[year] ?? 0),
                backgroundColor: '#4CAF50',
            },
            {
                label: 'Neatsinaujinanti energija (kWh)',
                data: validYears.map(year => nonrenewableTotals[year] ?? 0),
                backgroundColor: '#F44336',
            }
        ]
    };

    doughnutChartData.value = {
        labels: ['Atsinaujinanti', 'Neatsinaujinanti'],
        datasets: [{
            data: [
                renewableTotals[latestYear] ?? 0,
                nonrenewableTotals[latestYear] ?? 0,
            ],
            backgroundColor: ['#4CAF50', '#F44336'],
        }]
    };

    radarChartData.value = {
        labels: validYears,
        datasets: [{
            label: 'Energijos intensyvumas',
            data: validYears.map(year => energyIntensity[year] ?? 0),
            backgroundColor: 'rgba(255, 99, 132, 0.4)',
            borderColor: '#FF6384',
            pointBackgroundColor: '#FF6384',
        }]
    };

    stackedBarChartData.value = {
        labels: validYears,
        datasets: Object.keys(sourceTotals).map(source => ({
            label: source,
            data: validYears.map(year => stackedSources[year]?.[source] ?? 0),
            backgroundColor: randomColor(),
        }))
    };

    renewableShareData.value = {
        labels: validYears,
        datasets: [{
            label: 'Atsinaujinančios energijos dalis (%)',
            data: validYears.map(year => {
                const total = yearTotals[year] ?? 0;
                const renewable = renewableTotals[year] ?? 0;
                return total > 0 ? ((renewable / total) * 100).toFixed(2) : 0;
            }),
            fill: false,
            borderColor: '#66BB6A',
            tension: 0.3,
        }]
    };
});

// Computed
const totalEnergyFormatted = computed(() => totalEnergy.value.toLocaleString('lt-LT') + ' kWh');
const latestRenewableFormatted = computed(() => latestRenewable.value.toLocaleString('lt-LT') + ' kWh');
const periodLabel = computed(() => firstYear.value && lastYear.value ? `${firstYear.value}–${lastYear.value}` : '');

// Utility
function randomColor() {
    const colors = ['#4CAF50', '#FFC107', '#03A9F4', '#E91E63', '#9C27B0', '#FF5722', '#795548', '#607D8B'];
    return colors[Math.floor(Math.random() * colors.length)];
}

function generateColors(count) {
    const baseColors = ['#4CAF50', '#FFC107', '#03A9F4', '#E91E63', '#9C27B0', '#FF5722', '#795548', '#607D8B'];
    const result = [];
    for (let i = 0; i < count; i++) {
        result.push(baseColors[i % baseColors.length]);
    }
    return result;
}
</script>

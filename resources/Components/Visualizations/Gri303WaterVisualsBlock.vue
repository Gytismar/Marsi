<template>
    <div class="p-8 w-full mx-auto" style="max-width: 1800px;">
        <h1 class="text-3xl font-bold mb-8">GRI 303 Vandens vizualizacijos</h1>

        <!-- Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
            <InfoCard :title="`Bendras sunaudotas vanduo`" :value="totalWaterUsedFormatted" />
            <InfoCard :title="`Pakartotinai panaudotas vanduo`" :value="totalWaterRecycledFormatted" />
            <InfoCard :title="`Atskaitos laikotarpis`" :value="periodLabel" />
        </div>

        <!-- Charts -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div v-if="withdrawnChartData?.datasets?.length" class="chart-block">
                <BarChart :chart-data="withdrawnChartData" title="Panaudoto vandens kiekis pagal metus" />
            </div>

            <div v-if="consumptionChartData?.datasets?.length" class="chart-block">
                <BarChart :chart-data="consumptionChartData" title="Suvartoto vandens kiekis pagal metus" />
            </div>

            <div v-if="recycledTrendData?.datasets?.length" class="chart-block">
                <LineChart :chart-data="recycledTrendData" title="Pakartotinai panaudoto vandens tendencija" />
            </div>

            <div v-if="waterSourceDistributionData?.datasets?.length" class="chart-block">
                <PieChart :chart-data="waterSourceDistributionData" title="Vandens šaltinių pasiskirstymas" />
            </div>

            <div v-if="dischargeDestinationData?.datasets?.length" class="chart-block">
                <PieChart :chart-data="dischargeDestinationData" title="Išleidimo vietų pasiskirstymas" />
            </div>

            <div v-if="withdrawnVsDischargeData?.datasets?.length" class="chart-block">
                <StackedBarChart :chart-data="withdrawnVsDischargeData" title="Panaudotas vs Išleistas vanduo pagal metus" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';

import InfoCard from '../Charts/InfoCard.vue';
import BarChart from '../Charts/BarChart.vue';
import LineChart from '../Charts/LineChart.vue';
import PieChart from '../Charts/PieChart.vue';
import StackedBarChart from '../Charts/StackedBarChart.vue';

// Data
const withdrawnChartData = ref({ labels: [], datasets: [] });
const consumptionChartData = ref({ labels: [], datasets: [] });
const recycledTrendData = ref({ labels: [], datasets: [] });
const waterSourceDistributionData = ref({ labels: [], datasets: [] });
const dischargeDestinationData = ref({ labels: [], datasets: [] });
const withdrawnVsDischargeData = ref({ labels: [], datasets: [] });

const totalWaterUsed = ref(0);
const totalWaterRecycled = ref(0);
const firstYear = ref(null);
const lastYear = ref(null);

onMounted(async () => {
    const { data } = await axios.get('/api/v1/gri/g303-water');

    const waterWithdrawn = {}, waterConsumption = {}, waterRecycled = {}, sources = {}, dischargeDestinations = {}, withdrawnVsDischarge = {};

    (data ?? []).forEach(d => {
        const year = d.reporting_year;
        const source = d.source || 'Nežinomas šaltinis';
        const destination = d.discharge_destination || 'Nežinoma vieta';

        const withdrawn = parseFloat(d.water_withdrawn ?? 0);
        const consumption = parseFloat(d.water_consumption ?? 0);
        const recycled = parseFloat(d.water_recycled ?? 0);
        const discharge = parseFloat(d.water_discharge ?? 0);

        waterWithdrawn[year] = (waterWithdrawn[year] || 0) + withdrawn;
        waterConsumption[year] = (waterConsumption[year] || 0) + consumption;
        waterRecycled[year] = (waterRecycled[year] || 0) + recycled;

        sources[source] = (sources[source] || 0) + withdrawn;
        dischargeDestinations[destination] = (dischargeDestinations[destination] || 0) + discharge;

        if (!withdrawnVsDischarge[year]) withdrawnVsDischarge[year] = { withdrawn: 0, discharge: 0 };
        withdrawnVsDischarge[year].withdrawn += withdrawn;
        withdrawnVsDischarge[year].discharge += discharge;

        totalWaterUsed.value += withdrawn;
        totalWaterRecycled.value += recycled;
    });

    const years = Object.keys(waterWithdrawn).sort((a, b) => a - b);

    firstYear.value = Math.min(...years);
    lastYear.value = Math.max(...years);

    withdrawnChartData.value = {
        labels: years,
        datasets: [{
            label: 'Panaudotas vanduo (m³)',
            data: years.map(y => waterWithdrawn[y] ?? 0),
            backgroundColor: 'rgba(54, 162, 235, 0.6)',
        }]
    };

    consumptionChartData.value = {
        labels: years,
        datasets: [{
            label: 'Suvartotas vanduo (m³)',
            data: years.map(y => waterConsumption[y] ?? 0),
            backgroundColor: 'rgba(255, 206, 86, 0.6)',
        }]
    };

    recycledTrendData.value = {
        labels: years,
        datasets: [{
            label: 'Pakartotinai panaudotas vanduo (m³)',
            data: years.map(y => waterRecycled[y] ?? 0),
            borderColor: '#66BB6A',
            fill: false,
            tension: 0.4,
        }]
    };

    waterSourceDistributionData.value = {
        labels: Object.keys(sources),
        datasets: [{
            label: 'Šaltiniai',
            data: Object.values(sources),
            backgroundColor: generateColors(Object.keys(sources).length),
        }]
    };

    dischargeDestinationData.value = {
        labels: Object.keys(dischargeDestinations),
        datasets: [{
            label: 'Išleidimo vietos',
            data: Object.values(dischargeDestinations),
            backgroundColor: generateColors(Object.keys(dischargeDestinations).length),
        }]
    };

    withdrawnVsDischargeData.value = {
        labels: years,
        datasets: [
            {
                label: 'Panaudotas vanduo',
                data: years.map(y => withdrawnVsDischarge[y]?.withdrawn ?? 0),
                backgroundColor: '#42A5F5',
            },
            {
                label: 'Išleistas vanduo',
                data: years.map(y => withdrawnVsDischarge[y]?.discharge ?? 0),
                backgroundColor: '#FF7043',
            }
        ]
    };
});

// Computed for cards
const totalWaterUsedFormatted = computed(() => `${totalWaterUsed.value.toLocaleString('lt-LT')} m³`);
const totalWaterRecycledFormatted = computed(() => `${totalWaterRecycled.value.toLocaleString('lt-LT')} m³`);
const periodLabel = computed(() => firstYear.value && lastYear.value ? `${firstYear.value}–${lastYear.value}` : '');

function generateColors(count) {
    const colors = ['#4CAF50', '#FFC107', '#03A9F4', '#E91E63', '#9C27B0', '#FF5722', '#795548', '#607D8B'];
    return Array.from({ length: count }, (_, i) => colors[i % colors.length]);
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

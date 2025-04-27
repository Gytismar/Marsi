<template>
    <div class="p-8 w-full mx-auto" style="max-width: 1800px;">
        <h1 class="text-3xl font-bold mb-8">GRI 403 Sveikatos ir saugos vizualizacijos</h1>

        <!-- Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
            <InfoCard :title="`Darbuotojų skaičius (naujausias)`" :value="latestWorkforceFormatted" />
            <InfoCard :title="`Įvykę sužeidimai`" :value="totalIncidentsFormatted" />
            <InfoCard :title="`Atskaitos laikotarpis`" :value="periodLabel" />
        </div>

        <!-- Charts -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div v-if="incidentTrendData?.datasets?.length" class="chart-block">
                <LineChart :chart-data="incidentTrendData" title="Sužeidimų skaičius per metus" />
            </div>

            <div v-if="lostDaysTrendData?.datasets?.length" class="chart-block">
                <LineChart :chart-data="lostDaysTrendData" title="Prarastos darbo dienos per metus" />
            </div>

            <div v-if="fatalitiesTrendData?.datasets?.length" class="chart-block">
                <BarChart :chart-data="fatalitiesTrendData" title="Mirties atvejų skaičius per metus" />
            </div>

            <div v-if="trainingHoursTrendData?.datasets?.length" class="chart-block">
                <LineChart :chart-data="trainingHoursTrendData" title="Suteiktų mokymų valandos" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';

import InfoCard from '../Charts/InfoCard.vue';
import LineChart from '../Charts/LineChart.vue';
import BarChart from '../Charts/BarChart.vue';

const incidentTrendData = ref({ labels: [], datasets: [] });
const lostDaysTrendData = ref({ labels: [], datasets: [] });
const fatalitiesTrendData = ref({ labels: [], datasets: [] });
const trainingHoursTrendData = ref({ labels: [], datasets: [] });

const totalIncidents = ref(0);
const latestWorkforce = ref(0);
const firstYear = ref(null);
const lastYear = ref(null);

onMounted(async () => {
    const response = await axios.get('/api/v1/gri/g403-health-safety');
    const data = response.data ?? [];

    const incidents = {}, lostDays = {}, fatalities = {}, trainingHours = {}, workforce = {};

    data.forEach(d => {
        const year = d.reporting_year;
        incidents[year] = (incidents[year] || 0) + (parseInt(d.incidents_of_injury) || 0);
        lostDays[year] = (lostDays[year] || 0) + (parseInt(d.lost_days) || 0);
        fatalities[year] = (fatalities[year] || 0) + (parseInt(d.fatalities) || 0);
        trainingHours[year] = (trainingHours[year] || 0) + (parseFloat(d.health_safety_training) || 0);
        workforce[year] = d.total_workforce || 0;

        totalIncidents.value += (parseInt(d.incidents_of_injury) || 0);
    });

    const years = Object.keys(incidents).sort((a, b) => a - b);
    firstYear.value = years[0];
    lastYear.value = years.at(-1);

    latestWorkforce.value = workforce[lastYear.value] ?? 0;

    incidentTrendData.value = {
        labels: years,
        datasets: [{
            label: 'Sužeidimų skaičius',
            data: years.map(y => incidents[y]),
            borderColor: '#EF5350',
            tension: 0.4,
        }]
    };

    lostDaysTrendData.value = {
        labels: years,
        datasets: [{
            label: 'Prarastos darbo dienos',
            data: years.map(y => lostDays[y]),
            borderColor: '#42A5F5',
            tension: 0.4,
        }]
    };

    fatalitiesTrendData.value = {
        labels: years,
        datasets: [{
            label: 'Mirties atvejai',
            data: years.map(y => fatalities[y]),
            backgroundColor: '#AB47BC',
        }]
    };

    trainingHoursTrendData.value = {
        labels: years,
        datasets: [{
            label: 'Mokymų valandos',
            data: years.map(y => trainingHours[y]),
            borderColor: '#66BB6A',
            tension: 0.4,
        }]
    };
});

// Computed for cards
const latestWorkforceFormatted = computed(() => `${latestWorkforce.value.toLocaleString('lt-LT')} darbuotojai`);
const totalIncidentsFormatted = computed(() => `${totalIncidents.value.toLocaleString('lt-LT')} sužeidimai`);
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

<template>
    <div class="p-8 w-full mx-auto" style="max-width: 1800px;">
        <h1 class="text-3xl font-bold mb-8">GRI 2 Valdymo vizualizacijos</h1>

        <!-- Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
            <InfoCard :title="`Valdybos dydis (naujausias)`" :value="latestBoardSizeFormatted" />
            <InfoCard :title="`Nepriklausomų narių skaičius (naujausias)`" :value="latestIndependentMembersFormatted" />
            <InfoCard :title="`Atskaitos laikotarpis`" :value="periodLabel" />
        </div>

        <!-- Charts -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div v-if="boardSizeTrend?.datasets?.length" class="chart-block">
                <LineChart :chart-data="boardSizeTrend" title="Valdybos dydžio pokyčiai per metus" />
            </div>

            <div v-if="independentMembersTrend?.datasets?.length" class="chart-block">
                <LineChart :chart-data="independentMembersTrend" title="Nepriklausomų narių pokytis per metus" />
            </div>

            <div v-if="complianceViolationsTrend?.datasets?.length" class="chart-block">
                <BarChart :chart-data="complianceViolationsTrend" title="Atitikimo pažeidimų skaičius per metus" />
            </div>

            <div v-if="complianceFinesTrend?.datasets?.length" class="chart-block">
                <LineChart :chart-data="complianceFinesTrend" title="Skirtų baudų vertė (€) per metus" />
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

const boardSizeTrend = ref({ labels: [], datasets: [] });
const independentMembersTrend = ref({ labels: [], datasets: [] });
const complianceViolationsTrend = ref({ labels: [], datasets: [] });
const complianceFinesTrend = ref({ labels: [], datasets: [] });

const latestBoardSize = ref(0);
const latestIndependentMembers = ref(0);
const firstYear = ref(null);
const lastYear = ref(null);

onMounted(async () => {
    const response = await axios.get('/api/v1/gri/g2-governance');
    const data = response.data ?? [];

    const boardSize = {}, independentMembers = {}, complianceViolations = {}, complianceFines = {};

    data.forEach(d => {
        const year = d.reporting_year;
        boardSize[year] = d.board_size ?? 0;
        independentMembers[year] = d.independent_members ?? 0;
        complianceViolations[year] = d.compliance_violations_count ?? 0;
        complianceFines[year] = parseFloat(d.compliance_fines_value ?? 0);
    });

    const years = Object.keys(boardSize).sort((a, b) => a - b);

    firstYear.value = years[0];
    lastYear.value = years.at(-1);

    latestBoardSize.value = boardSize[lastYear.value] ?? 0;
    latestIndependentMembers.value = independentMembers[lastYear.value] ?? 0;

    boardSizeTrend.value = {
        labels: years,
        datasets: [{
            label: 'Valdybos narių skaičius',
            data: years.map(y => boardSize[y]),
            borderColor: '#42A5F5',
            tension: 0.4,
        }]
    };

    independentMembersTrend.value = {
        labels: years,
        datasets: [{
            label: 'Nepriklausomi nariai',
            data: years.map(y => independentMembers[y]),
            borderColor: '#66BB6A',
            tension: 0.4,
        }]
    };

    complianceViolationsTrend.value = {
        labels: years,
        datasets: [{
            label: 'Atitikimo pažeidimai',
            data: years.map(y => complianceViolations[y]),
            backgroundColor: '#FFA726',
        }]
    };

    complianceFinesTrend.value = {
        labels: years,
        datasets: [{
            label: 'Baudų suma (€)',
            data: years.map(y => complianceFines[y]),
            borderColor: '#AB47BC',
            tension: 0.4,
        }]
    };
});

// Computed
const latestBoardSizeFormatted = computed(() => `${latestBoardSize.value} nariai`);
const latestIndependentMembersFormatted = computed(() => `${latestIndependentMembers.value} nepriklausomi`);
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

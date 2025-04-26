<template>
    <AppLayout>
        <section class="generate-reports-page">

            <!-- Breadcrumbs -->
            <nav class="text-sm text-gray-500 mb-6">
                <a href="/" class="hover:underline">Pradžia</a> &raquo;
                <a href="/ataskaitos" class="hover:underline">Ataskaitos</a> &raquo;
                <span>Generuoti ataskaitą</span>
            </nav>

            <h1 class="page-title">Apjungtos Ataskaitos</h1>
            <p class="page-subtitle mb-8">Žemiau pateiktos pasirinktos GRI vizualizacijos.</p>

            <div class="flex justify-end mb-6">
                <button
                    class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg shadow-md transition"
                    @click="exportPDF"
                >
                    Eksportuoti į PDF
                </button>
            </div>

            <div v-if="loading" class="flex justify-center py-20">
                <div class="text-gray-600 text-lg animate-pulse">Kraunasi pasirinktos ataskaitos...</div>
            </div>

            <div v-else id="report-content" class="space-y-16">

                <!-- Render each selected GRI visualization -->
                <div v-for="gri in selectedStandards" :key="gri.id">
                    <component :is="gri.component" />
                </div>

            </div>
        </section>
    </AppLayout>
</template>

<script setup>
import { ref, onMounted, defineAsyncComponent } from 'vue';
import AppLayout from '../Layouts/AppLayout.vue';
import html2pdf from 'html2pdf.js';

// Async load components
const Gri302Visuals = defineAsyncComponent(() => import('./Gri302EnergyVisuals.vue'));
const Gri303Visuals = defineAsyncComponent(() => import('./Gri303WaterVisuals.vue'));
// (add other standards as needed)

const selectedStandards = ref([]);
const loading = ref(true);

onMounted(() => {
    const stored = localStorage.getItem('selectedReports');
    if (stored) {
        const selectedPaths = JSON.parse(stored);

        selectedStandards.value = selectedPaths.map(path => {
            if (path.includes('g302-energy')) {
                return { id: 'g302', component: Gri302Visuals };
            }
            if (path.includes('g303-water')) {
                return { id: 'g303', component: Gri303Visuals };
            }
            // TODO: Add mappings for g305, g306, g403, g2 etc
            return null;
        }).filter(Boolean);
    }

    loading.value = false;
});

const exportPDF = () => {
    const element = document.getElementById('report-content');
    const options = {
        margin: 0.5,
        filename: 'GRI_Ataskaita.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
    };
    html2pdf().from(element).set(options).save();
};
</script>

<style scoped>
.generate-reports-page {
    padding: 2rem;
    max-width: 1800px;
    margin: 0 auto;
}

.page-title {
    font-size: 2.5rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
}

.page-subtitle {
    font-size: 1.25rem;
    color: #666;
}
</style>

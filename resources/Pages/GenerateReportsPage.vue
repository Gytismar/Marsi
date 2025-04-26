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
                    :disabled="exporting"
                    class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg shadow-md transition disabled:opacity-50"
                    @click="exportPDF"
                >
                    {{ exporting ? 'Eksportuojama...' : 'Eksportuoti į PDF' }}
                </button>
            </div>

            <div v-if="loading" class="flex justify-center py-20">
                <div class="text-gray-600 text-lg animate-pulse">Kraunasi pasirinktos ataskaitos...</div>
            </div>

            <div v-else id="report-content" class="space-y-24">
                <div
                    v-for="(gri, index) in selectedStandards"
                    :key="gri.id"
                    :class="{'page-break': index !== 0}"
                >
                    <Suspense>
                        <template #default>
                            <component :is="gri.component" />
                        </template>
                        <template #fallback>
                            <div class="text-gray-500 text-center py-10">Kraunasi vizualizacija...</div>
                        </template>
                    </Suspense>
                </div>
            </div>

        </section>
    </AppLayout>
</template>

<script setup>
import { ref, onMounted, defineAsyncComponent } from 'vue';
import AppLayout from '../Layouts/AppLayout.vue';
import html2pdf from 'html2pdf.js';

// Load Block Components
const Gri302EnergyVisualsBlock = defineAsyncComponent(() => import('../Components/Visualizations/Gri302EnergyVisualsBlock.vue'));
// (later: add Gri303, Gri305 etc.)

const selectedStandards = ref([]);
const loading = ref(true);
const exporting = ref(false);

onMounted(() => {
    const stored = localStorage.getItem('selectedReports');
    if (stored) {
        const selectedPaths = JSON.parse(stored);

        selectedStandards.value = selectedPaths.map(path => {
            if (path.includes('gri302')) {
                return { id: 'g302', component: Gri302EnergyVisualsBlock };
            }
            // Add future mappings here
            return null;
        }).filter(Boolean);
    }

    loading.value = false;
});

const exportPDF = async () => {
    const element = document.getElementById('report-content');
    exporting.value = true;

    const options = {
        margin: [5, 5, 5, 5],
        filename: 'GRI_Ataskaita.pdf',
        image: { type: 'jpeg', quality: 1 },
        html2canvas: {
            scale: 1.5,
            useCORS: true,
            scrollY: 0
        },
        jsPDF: {
            unit: 'mm',
            format: 'a2',
            orientation: 'portrait',
        },
        pagebreak: { mode: ['css', 'legacy'] }
    };

    await html2pdf().from(element).set(options).save();
    exporting.value = false;
};

</script>

<style scoped>
.generate-reports-page {
    padding: 2rem;
    max-width: 1600px;
    margin: 0 auto;
}

#report-content {
    width: 100%;
    max-width: 1400px;
    margin: 0 auto;
    background: white;
    padding: 1rem;
}

/* Page break between different standards */
.page-break {
    page-break-before: always;
    break-before: page;
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

button:disabled {
    cursor: not-allowed;
}
</style>

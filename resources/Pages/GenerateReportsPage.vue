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

                <!-- 📄 Cover Page -->
                <div class="cover-page">
                    <h1 class="text-5xl font-extrabold mb-8">Tvarumo ataskaita</h1>
                    <p class="text-2xl mb-4 italic text-gray-600">Remiantis GRI standartais</p>

                    <div v-if="company" class="mt-12 text-left">
                        <p class="text-2xl mb-4"><strong>Įmonė:</strong> {{ company.company_name }}</p>
                        <p class="text-2xl mb-4"><strong>Įmonės kodas:</strong> {{ company.company_code }}</p>
                        <p class="text-2xl mb-4"><strong>Veiklos sektorius:</strong> {{ company.industry }}</p>
                        <p class="text-2xl mb-4"><strong>Šalis:</strong> {{ company.country }}</p>
                        <p class="text-2xl mb-4"><strong>Darbuotojų dydis:</strong> {{ company.size }}</p>
                    </div>

                    <div class="mt-12">
                        <p class="text-xl">Ataskaitos parengimo data:</p>
                        <p class="text-2xl font-semibold">{{ todayDate }}</p>
                    </div>
                </div>

                <!-- Page break -->
                <div class="page-break"></div>

                <!-- 📊 Dynamic GRI Visuals -->
                <div
                    v-for="(gri, index) in selectedStandards"
                    :key="gri.id"
                    class="standard-block"
                >
                    <Suspense>
                        <template #default>
                            <component :is="gri.component" />
                        </template>
                        <template #fallback>
                            <div class="text-gray-500 text-center py-10">Kraunasi vizualizacija...</div>
                        </template>
                    </Suspense>

                    <!-- Page break after every standard -->
                    <div class="page-break"></div>
                </div>

            </div>

        </section>
    </AppLayout>
</template>

<script setup>
import { ref, onMounted, defineAsyncComponent } from 'vue';
import AppLayout from '../Layouts/AppLayout.vue';
import html2pdf from 'html2pdf.js';
import axios from 'axios';

// Components
const Gri302EnergyVisualsBlock = defineAsyncComponent(() => import('../Components/Visualizations/Gri302EnergyVisualsBlock.vue'));

const selectedStandards = ref([]);
const loading = ref(true);
const exporting = ref(false);
const company = ref(null);

// Today Date (localized Lithuanian format)
const todayDate = new Date().toLocaleDateString('lt-LT');

// Fetch Data
onMounted(async () => {
    const stored = localStorage.getItem('selectedReports');
    if (stored) {
        const selectedPaths = JSON.parse(stored);
        selectedStandards.value = selectedPaths.map(path => {
            if (path.includes('gri302')) {
                return { id: 'g302', component: Gri302EnergyVisualsBlock };
            }
            return null;
        }).filter(Boolean);
    }

    // Fetch Company Info
    try {
        const { data } = await axios.get('/api/v1/companies');
        company.value = Array.isArray(data) ? data[0] : data;
    } catch (error) {
        console.error('Nepavyko gauti įmonės duomenų:', error);
    }

    loading.value = false;
});

// Export to PDF
const exportPDF = async () => {
    const element = document.getElementById('report-content');
    exporting.value = true;

    const options = {
        margin: [5, 5, 5, 5],
        filename: 'GRI_Ataskaita.pdf',
        image: { type: 'jpeg', quality: 1 },
        html2canvas: {
            scale: 2,
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

/* 📄 Cover Page Styles */
.cover-page {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    min-height: 90vh;
    text-align: center;
}

/* 🛑 Page Break */
.page-break {
    page-break-before: always;
    break-before: page;
}

/* 🔥 Standards Section */
.standard-block {
    padding-top: 2rem;
    padding-bottom: 2rem;
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

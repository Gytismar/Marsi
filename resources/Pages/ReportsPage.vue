<!-- Pages/ReportsPage.vue -->
<template>
    <AppLayout>
        <template #default>
            <section class="reports-page">
                <!-- Breadcrumbs -->
                <nav class="text-sm text-gray-500 mb-6">
                    <a href="/" class="hover:underline">Pradžia</a> &raquo;
                    <span>Ataskaitos</span>
                </nav>

                <h1 class="page-title">GRI Ataskaitos</h1>
                <p class="page-subtitle">Pasirinkite GRI standartą, kurį norite peržiūrėti arba sugeneruoti sujungtą ataskaitą.</p>

                <div v-if="loading" class="flex justify-center items-center py-20">
                    <div class="text-gray-600 text-lg animate-pulse">Kraunasi standartai...</div>
                </div>

                <div v-else class="cards">
                    <div
                        v-for="gri in griStandards"
                        :key="gri.id"
                        :class="['card', { 'unavailable': !gri.available }]"
                        @click="handleCardClick(gri)"
                    >
                        <div class="card-header">
                            <h2>{{ gri.title }}</h2>
                        </div>
                        <p>{{ gri.description }}</p>

                        <div v-if="selectionMode" class="mt-4">
                            <input
                                type="checkbox"
                                :checked="selected.includes(gri.id)"
                                @click.stop="toggleSelect(gri.id)"
                                :disabled="!gri.available"
                            />
                            <label class="ml-2 text-sm text-gray-700">Pasirinkti</label>
                        </div>

                        <div v-else-if="!gri.available" class="mt-4 text-red-500 text-sm">
                            Duomenų nėra
                        </div>
                    </div>
                </div>

                <div v-if="!loading" class="mt-10 flex justify-end space-x-4">
                    <button
                        v-if="!selectionMode"
                        class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-md transition"
                        @click="enableMultiSelect"
                    >
                        Apjungti ataskaitas
                    </button>

                    <template v-else>
                        <button
                            class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg shadow-md transition"
                            :disabled="selected.length === 0"
                            @click="joinSelectedReports"
                        >
                            Apjungti pasirinktas
                        </button>

                        <button
                            class="px-6 py-3 bg-gray-400 hover:bg-gray-500 text-white font-bold rounded-lg shadow-md transition"
                            @click="cancelMultiSelect"
                        >
                            Atšaukti
                        </button>
                    </template>
                </div>
            </section>
        </template>
    </AppLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import AppLayout from '../Layouts/AppLayout.vue';
import axios from 'axios';

const loading = ref(true);
const selectionMode = ref(false);
const selected = ref([]);

const griStandards = ref([
    { id: 'g302', title: 'GRI 302: Energija', description: 'Apima energijos suvartojimą, šaltinius bei efektyvumą.', path: '/ataskaitos/gri302', api: '/api/v1/gri/g302-energy', available: false },
    { id: 'g303', title: 'GRI 303: Vanduo', description: 'Vandens suvartojimo ir poveikio valdymas.', path: '/ataskaitos/gri303', api: '/api/v1/gri/g303-water', available: false },
    { id: 'g305', title: 'GRI 305: Emisijos', description: 'Šiltnamio efektą sukeliančių dujų emisijos ir mažinimas.', path: '/ataskaitos/gri305', api: '/api/v1/gri/g305-emissions', available: false },
    { id: 'g306', title: 'GRI 306: Atliekos', description: 'Atliekų tvarkymo ir perdirbimo praktikos.', path: '/ataskaitos/gri306', api: '/api/v1/gri/g306-waste', available: false },
    { id: 'g403', title: 'GRI 403: Sveikata ir sauga', description: 'Darbuotojų sveikatos ir saugos duomenys.', path: '/ataskaitos/gri403', api: '/api/v1/gri/g403-health-safety', available: false },
    { id: 'g2', title: 'GRI 2: Valdymas', description: 'Valdymo struktūros, etika ir atskaitomybė.', path: '/ataskaitos/gri2', api: '/api/v1/gri/g2-governance', available: false },
]);

const enableMultiSelect = () => {
    selectionMode.value = true;
    selected.value = [];
};

const cancelMultiSelect = () => {
    selectionMode.value = false;
    selected.value = [];
};

const toggleSelect = (id) => {
    if (selected.value.includes(id)) {
        selected.value = selected.value.filter(s => s !== id);
    } else {
        selected.value.push(id);
    }
};

const handleCardClick = (gri) => {
    if (!gri.available) return;

    if (selectionMode.value) {
        toggleSelect(gri.id);
    } else {
        window.location.href = gri.path;
    }
};

const joinSelectedReports = () => {
    const selectedPaths = griStandards.value
        .filter(g => selected.value.includes(g.id))
        .map(g => g.path);

    localStorage.setItem('selectedReports', JSON.stringify(selectedPaths));
    window.location.href = '/ataskaitos/generate';
};

const fetchAvailability = async () => {
    const promises = griStandards.value.map(async (gri) => {
        try {
            const response = await axios.get(gri.api);
            gri.available = Array.isArray(response.data) && response.data.length > 0;
        } catch (error) {
            console.error(`Klaida tikrinant ${gri.title}:`, error);
            gri.available = false;
        }
    });

    await Promise.all(promises);
    loading.value = false;
};

onMounted(() => {
    fetchAvailability();
});
</script>

<style scoped>
.reports-page {
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
    margin-bottom: 2rem;
}

.cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
}

.card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    cursor: pointer;
    transition: all 0.2s ease-in-out;
    display: flex;
    flex-direction: column;
}

.card:hover {
    transform: translateY(-4px);
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
}

.card.unavailable {
    opacity: 0.6;
    cursor: not-allowed;
}

.card-header h2 {
    font-size: 1.4rem;
    margin-bottom: 0.75rem;
    color: #007b5e;
}

.card p {
    font-size: 1rem;
    color: #444;
}
</style>

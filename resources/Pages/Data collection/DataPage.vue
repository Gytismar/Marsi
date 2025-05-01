<template>
    <AppLayout>
        <template #default>
            <div class="p-8 w-full mx-auto" style="max-width: 1800px;">
                <!-- Breadcrumbs and back button -->
                <div class="mb-4">
                    <nav class="text-sm text-gray-600 flex items-center gap-2">
                        <a href="/" class="breadcrumb-link">Pagrindinis</a>
                        <span>/</span>
                        <span class="breadcrumb-current">Duomenys</span>
                    </nav>
                    <button class="back-button" @click="goBack">← Grįžti atgal</button>
                </div>

                <!-- Page content -->
                <div class="data-page">
                    <h1 class="page-title">Duomenų Įvedimas</h1>
                    <p class="page-subtitle">Pasirinkite GRI standartą, kurį norite užpildyti</p>

                    <div class="cards-grid">
                        <a
                            v-for="gri in griPages"
                            :key="gri.route"
                            :href="gri.route"
                            class="gri-card"
                        >
                            <div class="card-content">
                                <h2>{{ gri.title }}</h2>
                                <p>{{ gri.description }}</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </template>
    </AppLayout>
</template>

<script setup>
import AppLayout from '../../Layouts/AppLayout.vue';

const goBack = () => {
    window.history.back();
};

const griPages = [
    {
        title: 'GRI 302: Energija',
        description: 'Duomenys apie energijos suvartojimą',
        route: '/gri/g302-energy',
    },
    {
        title: 'GRI 303: Vanduo',
        description: 'Informacija apie vandens suvartojimą',
        route: '/gri/g303-water',
    },
    {
        title: 'GRI 305: Emisijos',
        description: 'Duomenys apie išmetamąsias dujas',
        route: '/gri/g305-emissions',
    },
    {
        title: 'GRI 306: Atliekos',
        description: 'Atliekų tvarkymo informacija',
        route: '/gri/g306-waste',
    },
    {
        title: 'GRI 403: Sveikata ir sauga',
        description: 'Darbuotojų sveikatos ir saugos duomenys',
        route: '/gri/g403-health-safety',
    },
    {
        title: 'GRI 2: Valdymas',
        description: 'Organizacijos valdymo struktūra',
        route: '/gri/g2-governance',
    },
];
</script>

<style scoped>
.breadcrumb-link {
    text-decoration: none;
    color: #007b5e;
    font-weight: 500;
}
.breadcrumb-link:hover {
    text-decoration: underline;
}
.breadcrumb-current {
    color: #444;
    font-weight: 600;
}

.back-button {
    margin-top: 0.25rem;
    margin-bottom: 1rem;
    background: none;
    border: none;
    color: #007b5e;
    font-size: 1rem;
    font-weight: bold;
    cursor: pointer;
    padding: 0;
    transition: color 0.2s ease;
}
.back-button:hover {
    color: #004f3f;
}

.data-page {
    padding-top: 1rem;
}

.page-title {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
}

.page-subtitle {
    font-size: 1.2rem;
    margin-bottom: 2rem;
    color: #555;
}

.cards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.gri-card {
    background-color: #f0f0f0;
    padding: 1.5rem;
    border-radius: 12px;
    text-decoration: none;
    color: #000;
    transition: all 0.2s ease-in-out;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    display: block;
}

.gri-card:hover {
    background-color: #dcefe5;
    transform: scale(1.02);
}

.card-content h2 {
    font-size: 1.3rem;
    margin-bottom: 0.5rem;
}

.card-content p {
    font-size: 1rem;
    color: #333;
}
</style>

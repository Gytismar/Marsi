<template>
    <AppLayout>
        <template #default>
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
        </template>
    </AppLayout>
</template>

<script setup>
import AppLayout from '../../Layouts/AppLayout.vue';

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
.data-page {
    padding: 2rem;
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

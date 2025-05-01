<template>
    <AppLayout>
        <template #default>
            <section class="p-8 w-full mx-auto" style="max-width: 1800px;">
                <!-- Breadcrumbs and back button -->
                <div class="mb-4">
                    <nav class="text-sm text-gray-600 flex items-center gap-2">
                        <a href="/" class="breadcrumb-link">Pagrindinis</a>
                        <span>/</span>
                        <span class="breadcrumb-current">Informacija</span>
                    </nav>
                    <button class="back-button" @click="goBack">← Grįžti atgal</button>
                </div>

                <!-- Page content -->
                <div class="info-page">
                    <div class="intro">
                        <h1>GRI Standartų Apžvalga</h1>
                        <p>Raskite trumpą aprašymą apie kiekvieną GRI standartą ir eikite į detalesnį puslapį.</p>
                    </div>

                    <div class="cards">
                        <a
                            v-for="standard in griInfo"
                            :key="standard.code"
                            :href="standard.localRoute"
                            class="card"
                        >
                            <div class="card-header">
                                <h2>{{ standard.title }}</h2>
                            </div>
                            <p>{{ standard.description }}</p>
                            <span class="learn-more">Plačiau →</span>
                        </a>
                    </div>
                </div>
            </section>
        </template>
    </AppLayout>
</template>

<script setup>
import AppLayout from '../../Layouts/AppLayout.vue';

const goBack = () => {
    window.history.back();
};

const griInfo = [
    { code: '302', title: 'GRI 302: Energija', description: 'Apima energijos vartojimą, šaltinius bei efektyvumą.', localRoute: '/informacija/g302' },
    { code: '303', title: 'GRI 303: Vanduo', description: 'Vandens suvartojimo ir poveikio valdymas.', localRoute: '/informacija/g303' },
    { code: '305', title: 'GRI 305: Emisijos', description: 'Šiltnamio efektą sukeliančios dujos ir jų mažinimas.', localRoute: '/informacija/g305' },
    { code: '306', title: 'GRI 306: Atliekos', description: 'Atliekų susidarymo ir perdirbimo praktikos.', localRoute: '/informacija/g306' },
    { code: '403', title: 'GRI 403: Sveikata ir Saugumas', description: 'Darbuotojų saugos valdymas.', localRoute: '/informacija/g403' },
    { code: '2', title: 'GRI 2: Valdymas', description: 'Etika, priežiūra ir valdymo struktūros.', localRoute: '/informacija/g2' },
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

.info-page {
    padding-top: 1rem;
}

.intro h1 {
    font-size: 2.5rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
}

.intro p {
    font-size: 1.2rem;
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
    text-decoration: none;
    color: inherit;
    transition: all 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
}

.card-header h2 {
    font-size: 1.3rem;
    margin-bottom: 0.75rem;
    color: #007b5e;
}

.card p {
    font-size: 1rem;
    color: #444;
}

.learn-more {
    margin-top: 1rem;
    display: inline-block;
    font-weight: bold;
    color: #007b5e;
}
</style>

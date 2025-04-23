<template>
    <AppLayout>
        <template #default>
            <section class="info-page">
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
            </section>
        </template>
    </AppLayout>
</template>

<script setup>
import AppLayout from '../Layouts/AppLayout.vue';

const griInfo = [
    { code: '302', title: 'GRI 302: Energija', description: 'Apima energijos vartojimą, šaltinius bei efektyvumą.', localRoute: '/informacija/g302-energy' },
    { code: '303', title: 'GRI 303: Vanduo', description: 'Vandens suvartojimo ir poveikio valdymas.', localRoute: '/informacija/g303-water' },
    { code: '305', title: 'GRI 305: Emisijos', description: 'Šiltnamio efektą sukeliančios dujos ir jų mažinimas.', localRoute: '/informacija/g305-emissions' },
    { code: '306', title: 'GRI 306: Atliekos', description: 'Atliekų susidarymo ir perdirbimo praktikos.', localRoute: '/informacija/g306-waste' },
    { code: '403', title: 'GRI 403: Sveikata ir Saugumas', description: 'Darbuotojų saugos valdymas.', localRoute: '/informacija/g403-health-safety' },
    { code: '2', title: 'GRI 2: Valdymas', description: 'Etika, priežiūra ir valdymo struktūros.', localRoute: '/informacija/g2-governance' },
];
</script>

<style scoped>
.info-page {
    padding: 2rem;
    max-width: 1200px;
    margin: 0 auto;
}

.intro h1 {
    font-size: 2.2rem;
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

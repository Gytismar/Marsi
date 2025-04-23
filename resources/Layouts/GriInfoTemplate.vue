<template>
    <AppLayout>
        <template #default>
            <div class="standard-page">
                <nav class="breadcrumb">
                    <a href="/" class="breadcrumb-link">Pagrindinis</a>
                    <span>/</span>
                    <a href="/informacija" class="breadcrumb-link">Informacija</a>
                    <span>/</span>
                    <span class="breadcrumb-current">{{ title }}</span>
                </nav>

                <button class="back-button" @click="goBack">← Grįžti atgal</button>

                <h1 class="title">{{ title }}</h1>

                <div v-for="(para, idx) in paragraphs" :key="idx" class="paragraph">
                    <p>{{ para }}</p>
                </div>

                <div v-if="columnLabels && columnTooltips" class="fields-section">
                    <h2>📋 Reikalingi duomenų laukai</h2>
                    <ul class="fields-list">
                        <li v-for="(label, key) in columnLabels" :key="key">
                            <strong>{{ label }}:</strong> {{ columnTooltips[key] }}
                        </li>
                    </ul>
                </div>

                <a
                    v-if="externalUrl"
                    :href="externalUrl"
                    target="_blank"
                    class="external-link"
                >
                    🔗 Atidaryti oficialų dokumentą →
                </a>
            </div>
        </template>
    </AppLayout>
</template>

<script setup>
import AppLayout from '../Layouts/AppLayout.vue';

defineProps({
    title: String,
    paragraphs: Array,
    externalUrl: String,
    columnLabels: Object,
    columnTooltips: Object,
});

const goBack = () => {
    window.history.back();
};
</script>

<style scoped>
@import '../Pages/GriInfoStyles.css';

.standard-page {
    padding: 2rem 2rem 2rem 3rem;
    max-width: 900px;
    line-height: 1.7;
    font-size: 1.05rem;
    color: #333;
}

.breadcrumb {
    display: flex;
    align-items: center;
    font-size: 0.95rem;
    color: #666;
    margin-bottom: 1rem;
    gap: 0.5rem;
    flex-wrap: wrap;
}

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

.title {
    font-size: 2rem;
    margin-bottom: 1.5rem;
    color: #007b5e;
}

.back-button {
    margin-bottom: 0.75rem;
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

.paragraph {
    margin-bottom: 1.2rem;
}

.fields-section {
    margin-top: 2.5rem;
}

.fields-section h2 {
    font-size: 1.5rem;
    color: #444;
    margin-bottom: 1rem;
}

.fields-list {
    padding-left: 1.2rem;
    list-style: disc;
    color: #555;
}

.fields-list li {
    margin-bottom: 0.75rem;
}

.external-link {
    display: inline-block;
    margin-top: 2rem;
    font-weight: bold;
    color: #007b5e;
    text-decoration: none;
    transition: color 0.2s ease;
}

.external-link:hover {
    color: #004f3f;
}
</style>

<template>
    <AppLayout>
        <template #default>
            <div class="p-8 w-full mx-auto" style="max-width: 1800px;">
                <!-- Updated breadcrumbs -->
                <div class="mb-4">
                    <nav class="text-sm text-gray-600 flex items-center gap-2">
                        <a href="/" class="breadcrumb-link">Pagrindinis</a>
                        <span>/</span>
                        <a href="/informacija" class="breadcrumb-link">Informacija</a>
                        <span>/</span>
                        <span class="breadcrumb-current">{{ title }}</span>
                    </nav>
                    <button class="back-button" @click="goBack">← Grįžti atgal</button>
                </div>

                <!-- Main content -->
                <div class="standard-page">
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
@import '../Pages/Info/GriInfoStyles.css';

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

.standard-page {
    padding-top: 1rem;
    max-width: 900px;
    line-height: 1.7;
    font-size: 1.05rem;
    color: #333;
}

.title {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 1.5rem;
    color: #007b5e;
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

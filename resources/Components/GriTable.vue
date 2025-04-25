<template>
    <AppLayout>
        <div class="p-8 w-full mx-auto" style="max-width: 1800px;">
            <div class="mb-4">
                <nav class="text-sm text-gray-600 flex items-center gap-2">
                    <a href="/" class="breadcrumb-link">Pagrindinis</a>
                    <span>/</span>
                    <a href="/duomenys" class="breadcrumb-link">Duomenys</a>
                    <span>/</span>
                    <span class="breadcrumb-current">{{ title }}</span>
                </nav>
                <button class="back-button" @click="goBack">← Grįžti atgal</button>
            </div>
            <div class="flex justify-between items-center mb-8">
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2">
                        <h1 class="text-3xl font-bold text-gray-800">{{ title }}</h1>
                        <a v-if="infoUrl" :href="infoUrl" target="_blank" rel="noopener noreferrer" class="text-gray-500 hover:text-blue-600" :title="infoTooltip">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10A8 8 0 11 2 10a8 8 0 0116 0zM9 8a1 1 0 112 0v4a1 1 0 11-2 0V8zm1-4a1.5 1.5 0 100 3 1.5 1.5 0 000-3z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>

                    <button
                        @click="showExportModal = true"
                        class="text-white font-medium px-5 py-2 rounded-lg flex items-center gap-2 shadow hover:shadow-lg transition-all"
                        style="background-color: #538ca9;"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16h16V4H4zm8 5v6m0 0l-3-3m3 3l3-3" />
                        </svg>
                        Eksportuoti
                    </button>
                </div>

                <div class="flex items-center gap-4">
                    <div class="relative import-dropdown-wrapper">
                        <button
                            @click="showImportDropdown = !showImportDropdown"
                            class="text-white font-medium px-6 py-3 rounded-lg flex items-center gap-2 shadow-md hover:shadow-lg transition-all"
                            style="background-color: #b480ba;"
                        >
                            Importuoti
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 10a1 1 0 011-1h3V6a1 1 0 112 0v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 01-1-1z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div
                            v-if="showImportDropdown"
                            class="absolute right-0 mt-2 w-56 bg-white rounded-md shadow-lg z-50 border border-gray-200"
                        >
                            <button
                                class="w-full text-left px-4 py-2 hover:bg-blue-50 text-sm text-gray-700"
                                @click="openUploadModal"
                            >
                                Importuoti iš failo
                            </button>
                            <button
                                class="w-full text-left px-4 py-2 hover:bg-blue-50 text-sm text-gray-700"
                                @click="openRemoteModal"
                            >
                                Importuoti iš nuorodos
                            </button>
                        </div>
                    </div>

                    <button
                        @click="showAddForm"
                        class="bg-green-600 hover:bg-green-700 text-white font-medium px-6 py-3 rounded-lg flex items-center gap-2 transition-all shadow-md hover:shadow-lg"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Pridėti
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full border-collapse">
                        <thead>
                        <tr class="bg-gradient-to-r from-gray-50 to-gray-100 border-b-2 border-gray-200">
                            <th
                                v-for="col in columns"
                                :key="col"
                                class="px-6 py-4 text-left text-[11px] font-semibold text-gray-700 uppercase tracking-wide"
                                :title="columnTooltips[col] ?? ''"
                            >
                                <div class="flex items-center gap-1">
                                    {{ columnLabels[col] ?? col.replace(/_/g, ' ') }}
                                    <button @click="sortBy(col)" class="text-gray-400 hover:text-blue-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path
                                                :d="sortColumn === col && sortDirection === 'asc'
                                ? 'M5 15l7-7 7 7'
                                : 'M19 9l-7 7-7-7'"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                            />
                                        </svg>
                                    </button>
                                </div>
                            </th>
                            <th class="px-8 py-5 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Veiksmai
                            </th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                        <tr v-for="row in rows" :key="row.id" class="hover:bg-blue-50 transition-colors">
                            <td
                                v-for="col in columns"
                                :key="col"
                                class="px-6 py-3 text-xs text-gray-800 whitespace-nowrap"
                            >
                                {{ row[col] }}
                            </td>
                            <td class="px-8 py-4 text-right whitespace-nowrap">
                                <button
                                    @click="editRow(row)"
                                    class="p-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition-colors mr-2"
                                    title="Redaguoti"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M15.232 5.232l3.536 3.536M9 11l6-6 3 3-6 6H9v-3zM5 21h14" />
                                    </svg>
                                </button>
                                <button
                                    @click="confirmDelete(row.id)"
                                    class="p-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors"
                                    title="Ištrinti"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        <tr v-if="rows.length === 0">
                            <td :colspan="columns.length + 1" class="px-8 py-10 text-center text-gray-500">
                                Duomenų nėra
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div v-if="showDeleteModal" class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm flex items-center justify-center z-50">
            <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4 overflow-hidden transform transition-all animate-fadeIn">
                <div class="bg-gradient-to-r from-red-50 to-red-100 px-6 py-4 border-b border-red-200">
                    <h3 class="text-lg font-semibold text-red-800">Patvirtinti ištrynimą</h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-700">Ar tikrai norite ištrinti šį įrašą? Šis veiksmas negali būti atšauktas.</p>
                    <div class="mt-6 flex justify-end gap-3">
                        <button @click="showDeleteModal = false" class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">
                            Atšaukti
                        </button>
                        <button @click="deleteRow(deleteId)" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg shadow-sm">
                            Ištrinti
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="showFormModal" class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm flex items-center justify-center z-50">
            <div class="bg-white rounded-xl shadow-xl max-w-3xl w-full mx-4 overflow-hidden animate-fadeIn">
                <div class="bg-gray-100 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h2 class="text-xl font-semibold text-gray-800">
                        {{ form.id ? 'Atnaujinti įrašą' : 'Sukurti naują įrašą' }}
                    </h2>
                    <button @click="cancelForm" class="text-gray-500 hover:text-gray-700 text-xl">&times;</button>
                </div>

                <form @submit.prevent="handleSubmit" class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div v-for="column in columns" :key="column" class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">
                                {{ (columnLabels[column] ?? column.replace(/_/g, ' ')).charAt(0).toUpperCase() + (columnLabels[column] ?? column.replace(/_/g, ' ')).slice(1).toLowerCase() }}
                                <span v-if="requiredFields.includes(column)" class="text-red-500">*</span>
                            </label>
                            <input
                                v-model="form[column]"
                                :type="getInputType(column)"
                                :placeholder="`${columnLabels[column] ?? column.replace(/_/g, ' ')}`"
                                :class="[
                                    'w-full border rounded-lg px-4 py-2.5 shadow-sm transition-colors focus:ring-2 focus:ring-blue-500 focus:border-blue-500',
                                    form[column] ? 'bg-blue-50' : '',
                                    validationErrors[column] ? 'border-red-500' : 'border-gray-300'
                                ]"
                            />
                            <p v-if="validationErrors[column]" class="text-sm text-red-600">
                                {{ validationErrors[column] }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-8 space-x-4">
                        <button
                            @click="cancelForm"
                            type="button"
                            class="px-5 py-2.5 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors"
                        >
                            Atšaukti
                        </button>
                        <button
                            type="submit"
                            class="px-5 py-2.5 text-white font-medium rounded-lg shadow-sm hover:shadow transition-all"
                            :class="{'bg-green-600 hover:bg-green-700': !form.id, 'bg-yellow-500 hover:bg-yellow-600': form.id}"
                            style="min-width: 90px;"
                        >
                            {{ form.id ? 'Atnaujinti' : 'Pridėti' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <UploadFileModal
            v-if="showUploadModal"
            :columns="columns"
            :column-labels="columnLabels"
            :api-endpoint="apiEndpoint"
            :initial-parsed-data="externalParsedCsv"
            @close="() => { showUploadModal = false; externalParsedCsv = null }"
        />

        <ImportFromUrlModal
            v-if="showRemoteModal"
            :columns="columns"
            :column-labels="columnLabels"
            :api-endpoint="apiEndpoint"
            @close="showRemoteModal = false"
            @fetched="openUploadWithParsed"
        />
    </AppLayout>

    <ExportModal
        v-if="showExportModal"
        :rows="rows"
        :columns="columns"
        :title="title"
        @close="showExportModal = false"
    />
</template>

<script setup>
import { ref, onUnmounted, onMounted, nextTick } from 'vue'
import AppLayout from '../Layouts/AppLayout.vue'
import useGriTableLogic from './useGriTableLogic.js'
import UploadFileModal from './Import/UploadFileModal.vue'
import ImportFromUrlModal from './Import/ImportFromUrlModal.vue'
import ExportModal from './Export/ExportModal.vue'
const showExportModal = ref(false)

const props = defineProps({
    apiEndpoint: String,
    title: String,
    infoUrl: String,
    infoTooltip: { type: String, default: 'Click to learn more' },
    columnLabels: { type: Object, default: () => ({}) },
    columnTooltips: { type: Object, default: () => ({}) },
})

const {
    columns, rows, form, showFormModal, showDeleteModal, deleteId,
    sortColumn, sortDirection, requiredFields, errors, validationErrors,
    handleSubmit, editRow, showAddForm, confirmDelete, deleteRow,
    cancelForm, resetForm, getInputType, sortBy,
} = useGriTableLogic(props)

const showImportDropdown = ref(false)
const showUploadModal = ref(false)
const showRemoteModal = ref(false)
const externalParsedCsv = ref(null)

const toggleImportDropdown = () => {
    showImportDropdown.value = !showImportDropdown.value
    if (showImportDropdown.value) {
        document.addEventListener('click', handleClickOutside)
    }
}

const openUploadWithParsed = (parsedData) => {
    showRemoteModal.value = false
    externalParsedCsv.value = parsedData
    showUploadModal.value = true
}

const handleClickOutside = (event) => {
    const dropdown = document.querySelector('.import-dropdown-wrapper')
    if (dropdown && !dropdown.contains(event.target)) {
        showImportDropdown.value = false
        document.removeEventListener('click', handleClickOutside)
    }
}

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside)
})

const openUploadModal = () => {
    showUploadModal.value = true
    showImportDropdown.value = false
}

const openRemoteModal = () => {
    showRemoteModal.value = true
    showImportDropdown.value = false
}

onMounted(() => {
    window.addEventListener('refresh-gri-data', loadRows)
})

onUnmounted(() => {
    window.removeEventListener('refresh-gri-data', loadRows)
})

async function loadRows() {
    const response = await axios.get(props.apiEndpoint)
    rows.value = response.data
}

const goBack = () => {
    window.history.back()
}
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
</style>

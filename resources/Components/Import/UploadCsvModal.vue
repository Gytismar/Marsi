<template>
    <div class="fixed inset-0 bg-gray-900 bg-opacity-60 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg max-w-3xl w-full space-y-6 shadow-lg">
            <h2 class="text-xl font-bold text-gray-800">Upload from File</h2>

            <!-- File Upload Buttons -->
            <div class="flex flex-wrap gap-4">
                <!-- CSV Upload Button -->
                <label class="inline-block cursor-pointer px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors shadow">
                    Upload CSV File
                    <input
                        type="file"
                        accept=".csv"
                        @change="handleFile"
                        class="hidden"
                    />
                </label>

                <!-- Excel Upload Button -->
                <button
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition-colors shadow"
                    @click="() => alert('Excel import not implemented yet')"
                >
                    Upload Excel File
                </button>

                <!-- JSON Upload Button -->
                <button
                    class="px-4 py-2 bg-violet-600 text-white rounded hover:bg-violet-700 transition-colors shadow"
                    @click="() => alert('JSON import not implemented yet')"
                >
                    Upload JSON File
                </button>
            </div>

            <!-- Column Mapping -->
            <div v-if="headers.length" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div v-for="col in columns" :key="col" v-if="col !== 'id'">
                    <label class="block text-sm font-medium text-gray-700">
                        {{ columnLabels[col] ?? col }}
                    </label>
                    <select v-model="columnMap[col]" class="w-full border px-3 py-2 rounded">
                        <option v-for="header in headers" :value="header">{{ header }}</option>
                    </select>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-3 pt-4">
                <button @click="$emit('close')" class="px-4 py-2 text-gray-700 border rounded hover:bg-gray-100">Cancel</button>
                <button
                    @click="uploadToApi"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                    :disabled="loading"
                >
                    {{ loading ? 'Uploading...' : 'Import' }}
                </button>
            </div>

            <!-- Success message -->
            <p v-if="successMessage" class="text-green-600 text-sm text-center font-semibold">
                {{ successMessage }}
            </p>

            <p v-if="error" class="text-red-600 text-sm">{{ error }}</p>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import useGriImportLogic from './useGriImportLogic.js'

const emit = defineEmits(['close'])

const props = defineProps({
    columns: Array,
    columnLabels: Object,
    apiEndpoint: String,
    initialParsedData: { type: Array, default: null }
})

const {
    csvData, columnMap, loading, error,
    parseCsvFile, uploadToApi
} = useGriImportLogic(props.apiEndpoint)

const headers = ref([])
const successMessage = ref('')

const updateHeadersAndMapping = (parsed) => {
    if (!parsed || !Array.isArray(parsed) || parsed.length === 0) return

    csvData.value = parsed
    headers.value = Object.keys(parsed[0] ?? {})

    for (const h of headers.value) {
        columnMap.value[h] = ''
    }

    // Optional: Auto-map based on column name
    for (const dbField of props.columns) {
        if (dbField !== 'id') {
            const match = headers.value.find(h => h.toLowerCase() === dbField.toLowerCase())
            if (match) {
                columnMap.value[dbField] = match
            }
        }
    }
}

const handleFile = async (e) => {
    const file = e.target.files[0]
    if (!file) return
    const parsed = await parseCsvFile(file)
    updateHeadersAndMapping(parsed)
}

function onImportSuccess() {
    successMessage.value = '✅ Imported successfully!'
    setTimeout(() => {
        emit('close')
        window.dispatchEvent(new Event('refresh-gri-data'))
        successMessage.value = ''
    }, 2000)
}

onMounted(() => {
    window.addEventListener('import-success', onImportSuccess)

    if (props.initialParsedData) {
        updateHeadersAndMapping(props.initialParsedData)
    }
})

onUnmounted(() => {
    window.removeEventListener('import-success', onImportSuccess)
})
</script>


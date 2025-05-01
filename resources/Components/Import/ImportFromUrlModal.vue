<template>
    <div class="fixed inset-0 bg-gray-900 bg-opacity-60 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg max-w-md w-full space-y-4">
            <h2 class="text-xl font-bold text-gray-800">Importuoti duomenis iš nuorodos</h2>

            <input v-model="url" placeholder="Duomenų šaltinio nuoroda" class="w-full border px-2 py-1 rounded" />
            <input v-model="username" placeholder="Naudotojo vardas" class="w-full border px-2 py-1 rounded" />
            <input v-model="password" placeholder="Slaptažodis" type="password" class="w-full border px-2 py-1 rounded" />

            <div class="flex justify-end gap-3">
                <button @click="$emit('close')" class="px-4 py-2 text-gray-700 border rounded">Atšaukti</button>
                <button
                    @click="fetchCsvData"
                    class="px-4 py-2 bg-blue-600 text-white rounded"
                    :disabled="loading"
                >
                    {{ loading ? 'Gaunama...' : 'Toliau' }}
                </button>
            </div>

            <p v-if="error" class="text-red-600">{{ error }}</p>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'
import Papa from 'papaparse'

const emit = defineEmits(['close', 'fetched'])

const props = defineProps({
    columns: Array,
    columnLabels: Object,
    apiEndpoint: String,
})

const url = ref('')
const username = ref('')
const password = ref('')
const loading = ref(false)
const error = ref(null)

const fetchCsvData = async () => {
    error.value = null
    loading.value = true
    try {
        const { data } = await axios.post('/api/v1/fetch-csv', {
            url: url.value,
            username: username.value,
            password: password.value,
        })

        const parsed = await new Promise((resolve, reject) => {
            Papa.parse(data, {
                header: true,
                skipEmptyLines: true,
                complete: results => resolve(results.data),
                error: err => reject(err),
            })
        })

        emit('close')
        emit('fetched', parsed)

    } catch (e) {
        error.value = e.message
    } finally {
        loading.value = false
    }
}
</script>

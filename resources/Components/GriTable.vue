<template>
    <AppLayout>
        <div class="p-8 w-full max-w-screen-2xl mx-auto">
            <div class="flex justify-between items-center mb-8">
                <div class="flex items-center gap-2">
                    <h1 class="text-3xl font-bold text-gray-800">{{ title }}</h1>
                    <a
                        v-if="infoUrl"
                        :href="infoUrl"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="text-gray-500 hover:text-blue-600"
                        :title="infoTooltip"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10A8 8 0 11 2 10a8 8 0 0116 0zM9 8a1 1 0 112 0v4a1 1 0 11-2 0V8zm1-4a1.5 1.5 0 100 3 1.5 1.5 0 000-3z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>

                <button
                    @click="showAddForm"
                    class="bg-green-600 hover:bg-green-700 text-white font-medium px-6 py-3 rounded-lg flex items-center gap-2 transition-all shadow-md hover:shadow-lg"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Add
                </button>
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
                                Actions
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
                                    title="Edit"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M15.232 5.232l3.536 3.536M9 11l6-6 3 3-6 6H9v-3zM5 21h14" />
                                    </svg>
                                </button>
                                <button
                                    @click="confirmDelete(row.id)"
                                    class="p-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors"
                                    title="Delete"
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
                                No data available
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <div v-if="showDeleteModal" class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm flex items-center justify-center z-50">
            <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4 overflow-hidden transform transition-all animate-fadeIn">
                <div class="bg-gradient-to-r from-red-50 to-red-100 px-6 py-4 border-b border-red-200">
                    <h3 class="text-lg font-semibold text-red-800">Confirm Deletion</h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-700">Are you sure you want to delete this item? This action cannot be undone.</p>
                    <div class="mt-6 flex justify-end gap-3">
                        <button @click="showDeleteModal = false" class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">
                            Cancel
                        </button>
                        <button @click="deleteRow(deleteId)" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg shadow-sm">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Modal -->
        <div v-if="showFormModal" class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm flex items-center justify-center z-50">
            <div class="bg-white rounded-xl shadow-xl max-w-3xl w-full mx-4 overflow-hidden animate-fadeIn">
                <div class="bg-gray-100 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h2 class="text-xl font-semibold text-gray-800">
                        {{ form.id ? 'Update Entry' : 'Create New Entry' }}
                    </h2>
                    <button @click="cancelForm" class="text-gray-500 hover:text-gray-700 text-xl">&times;</button>
                </div>

                <form @submit.prevent="handleSubmit" class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div v-for="column in columns" :key="column" class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700 capitalize">
                                {{ columnLabels[column] ?? column.replace(/_/g, ' ') }}
                                <span v-if="requiredFields.includes(column)" class="text-red-500">*</span>
                            </label>
                            <input
                                v-model="form[column]"
                                :type="getInputType(column)"
                                :placeholder="`Enter ${props.columnLabels[column] ?? column.replace(/_/g, ' ')}`"
                                :class="[
                                'w-full border rounded-lg px-4 py-2.5 shadow-sm transition-colors focus:ring-2 focus:ring-blue-500 focus:border-blue-500',
                                form[column] ? 'bg-blue-50' : '',
                                validationErrors[column] ? 'border-red-500' : 'border-gray-300']"
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
                            Cancel
                        </button>
                        <button
                            type="submit"
                            class="px-5 py-2.5 text-white font-medium rounded-lg shadow-sm hover:shadow transition-all"
                            :class="{'bg-green-600 hover:bg-green-700': !form.id, 'bg-yellow-500 hover:bg-yellow-600': form.id}"
                            style="min-width: 90px;"
                        >
                            {{ form.id ? 'Update' : 'Add' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import AppLayout from '../Layouts/AppLayout.vue'

const props = defineProps({
    apiEndpoint: String,
    title: String,
    infoUrl: String,
    infoTooltip: {
        type: String,
        default: 'Click to learn more',
    },
    columnLabels: {
        type: Object,
        default: () => ({}),
    },
    columnTooltips: {
        type: Object,
        default: () => ({}),
    },
})

const columns = ref([])
const rows = ref([])
const form = ref({})
const showFormModal = ref(false)
const showDeleteModal = ref(false)
const deleteId = ref(null)
const sortColumn = ref(null)
const sortDirection = ref('asc')
const requiredFields = ref([])
const errors = ref({})
const validationErrors = ref({})

const fetchSchema = async () => {
    try {
        const { data } = await axios.get(`${props.apiEndpoint}/schema`)
        columns.value = Array.from(new Set(['id', ...data.fields]))
        requiredFields.value = data.required || []
        form.value = {}
    } catch (error) {
        console.error('Error fetching schema:', error)
    }
}

const fetchData = async () => {
    try {
        const { data } = await axios.get(props.apiEndpoint)
        rows.value = data.sort((a, b) => a.id - b.id)
        sortColumn.value = 'id'
        sortDirection.value = 'asc'
    } catch (error) {
        console.error('Error fetching data:', error)
    }
}

const handleSubmit = async () => {
    validationErrors.value = {} // reset errors

    let hasError = false
    for (const field of requiredFields.value) {
        if (!form.value[field]) {
            validationErrors.value[field] = `${props.columnLabels[field] ?? field} is required`
            hasError = true
        }
    }

    if (hasError) return

    try {
        const url = form.value.id ? `${props.apiEndpoint}/${form.value.id}` : props.apiEndpoint
        const method = form.value.id ? 'put' : 'post'
        await axios[method](url, form.value)
        await fetchData()
        resetForm()
    } catch (error) {
        console.error('Error submitting form:', error)
    }
}

const editRow = (row) => {
    form.value = { ...row }
    showFormModal.value = true
}

const showAddForm = () => {
    form.value = {}
    showFormModal.value = true
}

const confirmDelete = (id) => {
    deleteId.value = id
    showDeleteModal.value = true
}

const deleteRow = async (id) => {
    if (!id || isNaN(id)) return
    try {
        await axios.delete(`${props.apiEndpoint}/${id}`)
        showDeleteModal.value = false
        await fetchData()
    } catch (error) {
        console.error('Error deleting row:', error)
    }
}

const cancelForm = () => {
    form.value = {}
    showFormModal.value = false
}

const resetForm = () => {
    form.value = {}
    showFormModal.value = false
}

const getInputType = (column) => {
    if (column.includes('id') || column.includes('year')) return 'number'
    if (column.includes('email')) return 'email'
    if (column.includes('password')) return 'password'
    if (column.includes('date')) return 'date'
    if (column.includes('url') || column.includes('website')) return 'url'
    return 'text'
}

const sortBy = (column) => {
    if (sortColumn.value === column) {
        sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc'
    } else {
        sortColumn.value = column
        sortDirection.value = 'asc'
    }

    rows.value.sort((a, b) => {
        const valA = a[column]
        const valB = b[column]
        if (valA === null || valA === undefined) return 1
        if (valB === null || valB === undefined) return -1
        if (typeof valA === 'number' && typeof valB === 'number') {
            return sortDirection.value === 'asc' ? valA - valB : valB - valA
        }
        return sortDirection.value === 'asc'
            ? String(valA).localeCompare(String(valB))
            : String(valB).localeCompare(String(valA))
    })
}

onMounted(async () => {
    await fetchSchema()
    await fetchData()
})
</script>

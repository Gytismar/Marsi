<template>
    <AppLayout>
        <div class="p-8 max-w-6xl mx-auto">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800">{{ title }}</h1>
                <button
                    @click="showForm = true"
                    class="bg-green-600 hover:bg-green-700 text-white font-medium px-6 py-3 rounded-lg flex items-center gap-2 transition-all shadow-md hover:shadow-lg"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Add
                </button>
            </div>

            <!-- Form Card -->
            <transition name="fade">
                <div v-if="showForm" class="mb-8 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                        <h2 class="text-xl font-semibold text-gray-800">
                            {{ form.id ? 'Update Entry' : 'Create New Entry' }}
                        </h2>
                    </div>

                    <form @submit.prevent="handleSubmit" class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div v-for="column in columns" :key="column" class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700 capitalize">
                                    {{ column.replace(/_/g, ' ') }}
                                </label>
                                <input
                                    v-model="form[column]"
                                    :type="getInputType(column)"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition-colors"
                                    :placeholder="`Enter ${column.replace(/_/g, ' ')}`"
                                    :class="{'bg-blue-50': form[column]}"
                                />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8 space-x-4">
                            <button
                                @click="resetForm"
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
            </transition>

            <!-- Data Table Card -->
            <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full border-collapse">
                        <thead>
                        <tr class="bg-gradient-to-r from-gray-50 to-gray-100 border-b-2 border-gray-200">
                            <th
                                v-for="col in columns"
                                :key="col"
                                class="px-8 py-5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider"
                            >
                                {{ col.replace(/_/g, ' ') }}
                            </th>
                            <th class="px-8 py-5 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                        <tr
                            v-for="row in rows"
                            :key="row.id"
                            class="hover:bg-blue-50 transition-colors"
                        >
                            <td
                                v-for="col in columns"
                                :key="col"
                                class="px-8 py-4 text-sm text-gray-800 whitespace-nowrap"
                            >
                                {{ row[col] }}
                            </td>
                            <td class="px-8 py-4 text-right whitespace-nowrap">
                                <button
                                    @click="editRow(row)"
                                    class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition-colors font-medium text-sm mr-2"
                                    style="min-width: 90px;"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                    Update
                                </button>
                                <button
                                    @click="confirmDelete(row.id)"
                                    class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors font-medium text-sm"
                                    style="min-width: 90px;"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    Delete
                                </button>
                            </td>
                        </tr>
                        <tr v-if="rows.length === 0">
                            <td :colspan="columns.length + 1" class="px-8 py-10 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <p class="font-medium">No data available</p>
                                    <p class="text-sm text-gray-400">Add a new entry to get started</p>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div v-if="showDeleteModal" class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm flex items-center justify-center z-50">
            <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4 overflow-hidden transform transition-all animate-fadeIn">
                <div class="bg-gradient-to-r from-red-50 to-red-100 px-6 py-4 border-b border-red-200">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-red-800">Confirm Deletion</h3>
                    </div>
                </div>
                <div class="p-6">
                    <p class="text-gray-700">Are you sure you want to delete this item? This action cannot be undone.</p>
                    <div class="mt-6 flex justify-end gap-3">
                        <button
                            @click="showDeleteModal = false"
                            class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors"
                        >
                            Cancel
                        </button>
                        <button
                            @click="deleteRow(deleteId)"
                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors shadow-sm"
                        >
                            Delete
                        </button>
                    </div>
                </div>
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
})

const columns = ref([])
const rows = ref([])
const form = ref({})
const showForm = ref(false)
const showDeleteModal = ref(false)
const deleteId = ref(null)

const fetchSchema = async () => {
    try {
        const { data } = await axios.get(`${props.apiEndpoint}/schema`)
        columns.value = data
        resetForm()
    } catch (error) {
        console.error('Error fetching schema:', error)
    }
}

const fetchData = async () => {
    try {
        const { data } = await axios.get(props.apiEndpoint)
        rows.value = data
    } catch (error) {
        console.error('Error fetching data:', error)
    }
}

const handleSubmit = async () => {
    try {
        const url = form.value.id
            ? `${props.apiEndpoint}/${form.value.id}`
            : props.apiEndpoint

        const method = form.value.id ? 'put' : 'post'
        await axios[method](url, form.value)
        await fetchData()
        resetForm()
    } catch (error) {
        console.error('Error submitting form:', error)
        // You could add error handling UI here
    }
}

const editRow = (row) => {
    form.value = { ...row }
    showForm.value = true
    // Smooth scroll to form
    setTimeout(() => {
        window.scrollTo({ top: 0, behavior: 'smooth' })
    }, 100)
}

const confirmDelete = (id) => {
    deleteId.value = id
    showDeleteModal.value = true
}

const deleteRow = async (id) => {
    try {
        await axios.delete(`${props.apiEndpoint}/${id}`)
        await fetchData()
        showDeleteModal.value = false
    } catch (error) {
        console.error('Error deleting row:', error)
    }
}

const resetForm = () => {
    form.value = {}
    showForm.value = false
}

const getInputType = (column) => {
    if (column.includes('id') || column.includes('year') || column.includes('age')) {
        return 'number'
    } else if (column.includes('email')) {
        return 'email'
    } else if (column.includes('password')) {
        return 'password'
    } else if (column.includes('date')) {
        return 'date'
    } else if (column.includes('url') || column.includes('website')) {
        return 'url'
    } else {
        return 'text'
    }
}

onMounted(async () => {
    await fetchSchema()
    await fetchData()
})
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s, transform 0.3s;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
    transform: translateY(-10px);
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fadeIn {
    animation: fadeIn 0.3s ease-out forwards;
}

/* Add zebra-striping to table rows */
tr:nth-child(even) {
    background-color: rgba(243, 244, 246, 0.5);
}

tr:last-child td {
    border-bottom: none;
}

/* Enhanced table styles */
table {
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
}

thead th {
    position: sticky;
    top: 0;
    z-index: 10;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    letter-spacing: 0.05em;
}

/* Add a subtle highlight to the active form fields */
input:focus {
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
}
</style>

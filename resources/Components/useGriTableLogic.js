import { ref, onMounted } from 'vue'
import axios from 'axios'

export default function useGriTableLogic(props) {
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
            columns.value = data.fields
            requiredFields.value = data.required || []
            requiredFields.value = requiredFields.value.filter(field => field !== 'company_id')
            form.value = {}
        } catch (error) {
            console.error('Klaida gaunant schemą:', error)
        }
    }

    const fetchData = async () => {
        try {
            const { data } = await axios.get(props.apiEndpoint)
            rows.value = data.sort((a, b) => a.id - b.id)
            sortColumn.value = 'id'
            sortDirection.value = 'asc'
        } catch (error) {
            console.error('Klaida gaunant duomenis:', error)
        }
    }

    const handleSubmit = async () => {
        validationErrors.value = {}

        let hasError = false
        for (const field of requiredFields.value) {
            if (!form.value[field]) {
                validationErrors.value[field] = `${props.columnLabels[field] ?? field} yra privalomas laukelis`
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
            console.error('Klaida pateikiant formą:', error)
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
            console.error('Klaida trinant įrašą:', error)
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
            if (valA == null) return 1
            if (valB == null) return -1
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

    return {
        columns, rows, form, showFormModal, showDeleteModal, deleteId,
        sortColumn, sortDirection, requiredFields, errors, validationErrors,
        handleSubmit, editRow, showAddForm, confirmDelete, deleteRow,
        cancelForm, resetForm, getInputType, sortBy
    }
}

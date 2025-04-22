import { ref } from 'vue'
import axios from 'axios'
import Papa from 'papaparse'

export default function useGriImportLogic(apiEndpoint) {
    const csvData = ref([])
    const columnMap = ref({})
    const loading = ref(false)
    const error = ref(null)

    const parseCsvFile = (file) => {
        return new Promise((resolve, reject) => {
            Papa.parse(file, {
                header: true,
                skipEmptyLines: true,
                complete: results => resolve(results.data),
                error: err => reject(err),
            })
        })
    }

    const uploadToApi = async () => {
        const csv = csvData.value
        const map = columnMap.value

        if (!csv.length) return

        loading.value = true
        error.value = null

        try {
            const mappedData = csv.map(row => {
                const mappedRow = {}
                for (const [dbField, csvField] of Object.entries(map)) {
                    if (csvField && row.hasOwnProperty(csvField)) {
                        mappedRow[dbField] = row[csvField]
                    }
                }
                return mappedRow
            })

            await axios.post(`${apiEndpoint}/bulk-import`, mappedData)

            window.dispatchEvent(new CustomEvent('import-success'))

        } catch (e) {
            error.value = e.message
        } finally {
            loading.value = false
        }
    }

    return {
        csvData,
        columnMap,
        loading,
        error,
        parseCsvFile,
        uploadToApi,
    }
}

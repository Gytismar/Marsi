<template>
    <div class="fixed inset-0 bg-gray-900 bg-opacity-60 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg max-w-md w-full space-y-6 shadow-lg">
            <h2 class="text-xl font-bold text-gray-800">Export Data</h2>

            <div class="flex flex-col gap-4">
                <button
                    @click="exportAs('csv')"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors shadow"
                >
                    Export as CSV
                </button>

                <button
                    @click="exportAs('excel')"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition-colors shadow"
                >
                    Export as Excel
                </button>

                <button
                    @click="exportAs('json')"
                    class="px-4 py-2 bg-violet-600 text-white rounded hover:bg-violet-700 transition-colors shadow"
                >
                    Export as JSON
                </button>
            </div>

            <div class="text-right pt-2">
                <button @click="$emit('close')" class="text-gray-500 hover:underline">Cancel</button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { toRefs } from 'vue'
import ExcelJS from 'exceljs'

const emit = defineEmits(['close'])
const props = defineProps({
    rows: Array,
    columns: Array,
    title: String,
})

const { rows, columns, title } = toRefs(props)

function getSanitizedFileName(base, ext) {
    const safe = (base || 'exported_data')
        .toLowerCase()
        .replace(/\s+/g, '_')
        .replace(/[^\w\-]/g, '') // Remove invalid chars
    return `${safe}.${ext}`
}

async function exportAs(format) {
    const data = rows.value
    const headers = columns.value

    if (!data.length) return

    let blob
    let filename = getSanitizedFileName(title.value, format)

    if (format === 'csv') {
        const csvRows = [headers.join(',')]
        for (const row of data) {
            const values = headers.map(col => `"${String(row[col] ?? '').replace(/"/g, '""')}"`)
            csvRows.push(values.join(','))
        }
        blob = new Blob([csvRows.join('\n')], { type: 'text/csv;charset=utf-8;' })

    } else if (format === 'excel') {
        filename = getSanitizedFileName(title.value, 'xlsx')
        const workbook = new ExcelJS.Workbook()
        const worksheet = workbook.addWorksheet('Data')

        worksheet.addRow(headers)
        data.forEach(row => worksheet.addRow(headers.map(col => row[col] ?? '')))

        const buffer = await workbook.xlsx.writeBuffer()
        blob = new Blob([buffer], {
            type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        })

    } else if (format === 'json') {
        blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' })
    }

    const url = URL.createObjectURL(blob)
    const link = document.createElement('a')
    link.href = url
    link.setAttribute('download', filename)
    document.body.appendChild(link)
    link.click()
    document.body.removeChild(link)

    emit('close')
}
</script>

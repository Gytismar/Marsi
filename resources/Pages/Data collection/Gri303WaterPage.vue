<template>
    <GriTable
        apiEndpoint="/api/v1/gri/g303-water"
        title="GRI 303 Vanduo"
        infoUrl="https://example.com/gri-303"
        infoTooltip="Spauskite, jei norite sužinoti daugiau apie GRI 303: Vanduo"
        :columnLabels="columnLabels"
        :columnTooltips="columnTooltips"
    />
</template>

<script setup>
import GriTable from '../../Components/GriTable.vue'

const columnLabels = {
    company_id: 'Įmonės ID',
    reporting_year: 'Atskaitiniai metai',
    water_withdrawn: 'Panaudoto vandens kiekis',
    water_discharge: 'Išleidžiamo vandens kiekis',
    discharge_destination: 'Išleidimo vieta',
    water_consumption: 'Suvartotas vanduo',
    water_recycled: 'Pakartotinai panaudotas vanduo',
    unit: 'Matavimo vienetas',
    source: 'Šaltinis',
}

const columnTooltips = {
    company_id: 'Įmonės identifikatorius.',
    reporting_year: 'Metai, už kuriuos pateikiami duomenys.',
    water_withdrawn: 'Iš gamtos paimtas vandens kiekis.',
    water_discharge: 'Išleistas vandens kiekis po naudojimo.',
    discharge_destination: 'Kur buvo išleistas vanduo – į gamtą, miesto kanalizaciją ir pan.',
    water_consumption: 'Vandens kiekis, kuris buvo sunaudotas ir neišleistas.',
    water_recycled: 'Kiekis vandens, kuris buvo pakartotinai panaudotas po perdirbimo.',
    unit: 'Vandens kiekio matavimo vienetas (pvz., m³).',
    source: 'Vandens šaltinis',
}
</script>

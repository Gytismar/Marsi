<template>
    <GriTable
        apiEndpoint="/api/v1/gri/g305-emissions"
        title="GRI 305 Emisijos"
        infoUrl="/informacija/g305"
        infoTooltip="Spauskite, jei norite sužinoti daugiau apie GRI 305: Emisijos"
        :columnLabels="columnLabels"
        :columnTooltips="columnTooltips"
    />
</template>

<script setup>
import GriTable from '../../Components/GriTable.vue';

const columnLabels = {
    reporting_year: 'Atskaitos metai',
    scope_1: '1 srities emisijos (t CO₂e)',
    scope_2: '2 srities emisijos (t CO₂e)',
    scope_3: '3 srities emisijos (t CO₂e)',
    ghg_intensity: 'ŠESD intensyvumas',
};

const columnTooltips = {
    reporting_year: 'Metai, kuriems taikoma ataskaita.',
    scope_1: 'Tiesioginės šiltnamio efektą sukeliančių dujų emisijos iš įmonei priklausančių ar jos valdomų šaltinių.',
    scope_2: 'Netiesioginės emisijos dėl įsigytos elektros energijos, šilumos ar garo vartojimo.',
    scope_3: 'Kitos netiesioginės emisijos, atsirandančios tiekimo grandinėje (pvz., kelionės, logistikos, produktų naudojimo).',
    ghg_intensity: 'Šiltnamio efektą sukeliančių dujų emisijos intensyvumas (pvz., emisijos vienam produkto vienetui ar pajamoms).',
};

</script>

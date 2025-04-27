<template>
    <GriInfoTemplate
        title="GRI 305: Emisijos"
        :paragraphs="[
            'GRI 305 standartas padeda organizacijoms atskleisti informaciją apie šiltnamio efektą sukeliančių dujų (ŠESD) emisijas. Jame pateikiamos gairės, kaip pranešti apie tiesiogines ir netiesiogines emisijas, taip pat apie jų valdymą.',
            'Žemiau pateikti laukai, kuriuos reikia užpildyti teikiant duomenis apie emisijas ir jų intensyvumą:'
        ]"
        externalUrl="https://globalreporting.org/pdf.ashx?id=12510"
        :columnLabels="columnLabels"
        :columnTooltips="columnTooltips"
    />
</template>

<script setup>
import GriInfoTemplate from '../../Layouts/GriInfoTemplate.vue';

const columnLabels = {
    company_id: 'Įmonės ID',
    reporting_year: 'Atskaitos metai',
    scope_1: '1 srities emisijos (t CO₂e)',
    scope_2: '2 srities emisijos (t CO₂e)',
    scope_3: '3 srities emisijos (t CO₂e)',
    ghg_intensity: 'ŠESD intensyvumas',
};

const columnTooltips = {
    company_id: 'Unikalus įmonės identifikatorius.',
    reporting_year: 'Metai, kuriems taikoma ataskaita.',
    scope_1: 'Tiesioginės šiltnamio efektą sukeliančių dujų emisijos iš įmonei priklausančių ar jos valdomų šaltinių.',
    scope_2: 'Netiesioginės emisijos dėl įsigytos elektros energijos, šilumos ar garo vartojimo.',
    scope_3: 'Kitos netiesioginės emisijos, atsirandančios tiekimo grandinėje (pvz., kelionės, logistikos, produktų naudojimo).',
    ghg_intensity: 'Šiltnamio efektą sukeliančių dujų emisijos intensyvumas (pvz., emisijos vienam produkto vienetui ar pajamoms).',
};
</script>

<template>
    <GriInfoTemplate
        title="GRI 303: Vanduo"
        :paragraphs="[
            'GRI 303 standartas apima organizacijos vandens naudojimą ir jo poveikį aplinkai. Jame nurodoma, kaip organizacija paima, naudoja ir išleidžia vandenį, bei kokie yra galimi poveikiai aplinkai ar bendruomenėms.',
            'Žemiau pateikti duomenų laukai, kuriuos organizacija turi užpildyti pateikdama informaciją apie vandens vartojimą:'
        ]"
        externalUrl="https://example.com/gri-303"
        :columnLabels="columnLabels"
        :columnTooltips="columnTooltips"
    />
</template>

<script setup>
import GriInfoTemplate from '../Layouts/GriInfoTemplate.vue';

const columnLabels = {
    company_id: 'Įmonės ID',
    reporting_year: 'Atskaitiniai metai',
    water_withdrawn: 'Panaudoto vandens kiekis (m³)',
    water_source_type: 'Vandens šaltinio tipas',
    water_discharge: 'Išleidžiamo vandens kiekis (m³)',
    discharge_destination: 'Išleidimo vieta',
    water_consumption: 'Suvartotas vanduo (m³)',
};

const columnTooltips = {
    company_id: 'Įmonės identifikatorius.',
    reporting_year: 'Metai, už kuriuos pateikiami duomenys.',
    water_withdrawn: 'Iš gamtos paimtas vandens kiekis.',
    water_source_type: 'Vandens šaltinio tipas (pvz., paviršinis, požeminis, miestų vandentiekis).',
    water_discharge: 'Išleistas vandens kiekis po naudojimo.',
    discharge_destination: 'Kur buvo išleistas vanduo – į gamtą, miesto kanalizaciją ir pan.',
    water_consumption: 'Vandens kiekis, kuris buvo sunaudotas ir neišleistas.',
};
</script>

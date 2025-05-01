<template>
    <GriTable
        apiEndpoint="/api/v1/gri/g306-waste"
        title="GRI 306 Atliekos"
        infoUrl="/informacija/g306"
        infoTooltip="Spauskite, jei norite sužinoti daugiau apie GRI 306: Atliekos"
        :columnLabels="columnLabels"
        :columnTooltips="columnTooltips"
    />
</template>

<script setup>
import GriTable from '../../Components/GriTable.vue';

const columnLabels = {
    reporting_year: 'Atskaitos metai',
    total_waste_generated: 'Bendras atliekų kiekis (t)',
    hazardous_waste_generated: 'Pavojingų atliekų kiekis (t)',
    nonhazardous_waste_generated: 'Nepavojingų atliekų kiekis (t)',
    waste_recycled: 'Perdirbtos atliekos (t)',
    waste_disposed: 'Šalintos atliekos (t)',
    disposal_method: 'Šalinimo būdas',
};

const columnTooltips = {
    reporting_year: 'Metai, kuriems taikoma ataskaita.',
    total_waste_generated: 'Per ataskaitinį laikotarpį sugeneruotas bendras atliekų kiekis.',
    hazardous_waste_generated: 'Pavojingų atliekų kiekis, turinčių kenksmingų savybių.',
    nonhazardous_waste_generated: 'Visų kitų, nepavojingų, atliekų kiekis.',
    waste_recycled: 'Atliekų kiekis, kuris buvo perdirbtas ar pakartotinai panaudotas.',
    waste_disposed: 'Atliekų kiekis, kuris buvo galutinai pašalintas (pvz., deginimas, sąvartynas).',
    disposal_method: 'Naudotas atliekų šalinimo metodas.',
};
</script>

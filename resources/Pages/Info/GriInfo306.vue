<template>
    <GriInfoTemplate
        title="GRI 306: Atliekos"
        :paragraphs="[
            'GRI 306 standartas skirtas organizacijų atliekų susidarymui, rūšiavimui, perdirbimui ir šalinimui stebėti bei atskleisti. Tai padeda parodyti įmonės požiūrį į tvarų atliekų tvarkymą ir poveikio aplinkai mažinimą.',
            'Žemiau pateikti duomenų laukai, kuriuos būtina užpildyti atliekant ataskaitą apie atliekas:'
        ]"
        externalUrl="https://globalreporting.org/pdf.ashx?id=12521"
        :columnLabels="columnLabels"
        :columnTooltips="columnTooltips"
    />
</template>

<script setup>
import GriInfoTemplate from '../../Layouts/GriInfoTemplate.vue';

const columnLabels = {
    company_id: 'Įmonės ID',
    reporting_year: 'Atskaitos metai',
    total_waste_generated: 'Bendras atliekų kiekis (t)',
    hazardous_waste_generated: 'Pavojingų atliekų kiekis (t)',
    nonhazardous_waste_generated: 'Nepavojingų atliekų kiekis (t)',
    waste_recycled: 'Perdirbtos atliekos (t)',
    waste_disposed: 'Šalintos atliekos (t)',
    disposal_method: 'Šalinimo būdas',
};

const columnTooltips = {
    company_id: 'Unikalus įmonės identifikatorius.',
    reporting_year: 'Metai, kuriems taikoma ataskaita.',
    total_waste_generated: 'Per ataskaitinį laikotarpį sugeneruotas bendras atliekų kiekis.',
    hazardous_waste_generated: 'Pavojingų atliekų kiekis, turinčių kenksmingų savybių.',
    nonhazardous_waste_generated: 'Visų kitų, nepavojingų, atliekų kiekis.',
    waste_recycled: 'Atliekų kiekis, kuris buvo perdirbtas ar pakartotinai panaudotas.',
    waste_disposed: 'Atliekų kiekis, kuris buvo galutinai pašalintas (pvz., deginimas, sąvartynas).',
    disposal_method: 'Naudotas atliekų šalinimo metodas.',
};
</script>

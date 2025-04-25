<template>
    <GriInfoTemplate
        title="GRI 302: Energija"
        :paragraphs="[
            'GRI 302 standartas apima organizacijos energijos vartojimą, šaltinių kilmę, energijos intensyvumą bei energijos mažinimo priemones.',
            'Žemiau pateikti laukai, kuriuos reikia užpildyti teikiant duomenis apie energijos naudojimą:'
        ]"
        externalUrl="https://www.globalreporting.org/standards/standard-download-center/gri-302-energy-2016/"
        :columnLabels="columnLabels"
        :columnTooltips="columnTooltips"
    />
</template>

<script setup>
import GriInfoTemplate from '../../Layouts/GriInfoTemplate.vue';

const columnLabels = {
    company_id: 'Įmonės ID',
    reporting_year: 'Atskaitiniai metai',
    total_energy_consumed: 'Bendras energijos suvartojimas',
    renewable_energy_consumed: 'Atsinaujinančios energijos kiekis',
    nonrenewable_energy_consumed: 'Neatsinaujinančios energijos kiekis',
    energy_consumed_unit: 'Matavimo vienetas',
    energy_intensity: 'Energijos intensyvumas',
    reduction_achieved: 'Pasiektas sumažinimas (%)',
    source: 'Duomenų šaltinis',
};

const columnTooltips = {
    company_id: 'Įmonės identifikatorius.',
    reporting_year: 'Metai, už kuriuos pateikiami duomenys.',
    total_energy_consumed: 'Bendras energijos kiekis, suvartotas per ataskaitinį laikotarpį.',
    renewable_energy_consumed: 'Energijos kiekis iš atsinaujinančių šaltinių, tokių kaip saulė, vėjas ir pan.',
    nonrenewable_energy_consumed: 'Energijos kiekis iš neatsinaujinančių šaltinių, pvz., iškastinio kuro.',
    energy_consumed_unit: 'Energijos matavimo vienetas (pvz., MWh, GJ).',
    energy_intensity: 'Energijos suvartojimo santykis su verslo rodikliais, tokiais kaip pajamos ar produkcija.',
    reduction_achieved: 'Procentinis energijos sunaudojimo sumažinimas dėl efektyvumo priemonių.',
    source: 'Paaiškinimas ar šaltinis, iš kur gauti energijos duomenys.',
};
</script>

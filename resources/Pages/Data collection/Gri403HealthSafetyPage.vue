<template>
    <GriTable
        apiEndpoint="/api/v1/gri/g403-health-safety"
        title="GRI 403 Sveikata ir sauga"
        infoUrl="/informacija/g403"
        infoTooltip="Spauskite, jei norite sužinoti daugiau apie GRI 403: Darbuotojų sveikata ir sauga"
        :columnLabels="columnLabels"
        :columnTooltips="columnTooltips"
    />
</template>

<script setup>
import GriTable from '../../Components/GriTable.vue';

const columnLabels = {
    company_id: 'Įmonės ID',
    reporting_year: 'Atskaitos metai',
    total_workforce: 'Darbuotojų skaičius',
    incidents_of_injury: 'Sužeidimų skaičius',
    lost_days: 'Prarastos darbo dienos',
    fatalities: 'Mirtini atvejai',
    health_safety_training: 'Sveikatos ir saugos mokymai (valandomis)',
    management_system_coverage: 'Valdymo sistemos aprėptis (%)',
};

const columnTooltips = {
    company_id: 'Unikalus įmonės identifikatorius.',
    reporting_year: 'Metai, kuriems taikoma ataskaita.',
    total_workforce: 'Bendras darbuotojų skaičius per ataskaitinį laikotarpį.',
    incidents_of_injury: 'Registruotų darbuotojų sužeidimų skaičius.',
    lost_days: 'Darbo dienų, prarastų dėl incidentų ar sužeidimų, skaičius.',
    fatalities: 'Mirtinų nelaimingų atsitikimų darbo vietoje skaičius.',
    health_safety_training: 'Sveikatos ir saugos mokymų apimtis, išreikšta valandomis.',
    management_system_coverage: 'Procentinė darbuotojų dalis, kuriai taikoma saugos valdymo sistema.',
};
</script>

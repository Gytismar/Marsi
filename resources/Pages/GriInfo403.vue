<template>
    <GriInfoTemplate
        title="GRI 403: Sveikata ir Saugumas"
        :paragraphs="[
            'GRI 403 standartas apima darbuotojų sveikatos ir saugos valdymą darbo vietoje. Jis padeda organizacijoms atskleisti informaciją apie incidentų prevenciją, mokymus ir darbuotojų gerovę.',
            'Toliau pateikti pagrindiniai laukai, kuriuos reikia užpildyti teikiant informaciją apie darbuotojų sveikatą ir saugą:'
        ]"
        externalUrl="https://example.com/gri-403"
        :columnLabels="columnLabels"
        :columnTooltips="columnTooltips"
    />
</template>

<script setup>
import GriInfoTemplate from '../Layouts/GriInfoTemplate.vue';

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

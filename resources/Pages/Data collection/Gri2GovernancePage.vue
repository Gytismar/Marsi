<template>
    <GriTable
        apiEndpoint="/api/v1/gri/g2-governance"
        title="GRI 2 Valdymas"
        infoUrl="/informacija/g2"
        infoTooltip="Spauskite, jei norite sužinoti daugiau apie GRI 2: Organizacinis valdymas"
        :columnLabels="columnLabels"
        :columnTooltips="columnTooltips"
    />
</template>

<script setup>
import GriTable from '../../Components/GriTable.vue';

const columnLabels = {
    reporting_year: 'Atskaitos metai',
    governance_structure: 'Valdymo struktūra',
    board_size: 'Valdybos narių skaičius',
    independent_members: 'Nepriklausomi nariai',
    chair_is_executive: 'Pirmininkas yra vykdomasis',
    delegation_of_responsibility: 'Atsakomybės delegavimas',
    reporting_frequency: 'Ataskaitų teikimo dažnumas',
    board_review_of_esg: 'Valdybos ESG peržiūra',
    conflict_of_interest_policy: 'Interesų konflikto politika',
    policy_code_of_ethics: 'Etikos kodeksas',
    ethics_advice_mechanism: 'Etikos konsultavimo mechanizmas',
    report_misconduct_mechanism: 'Pažeidimų pranešimo sistema',
    compliance_violations_count: 'Atitikties pažeidimų skaičius',
    compliance_fines_value: 'Skirtų baudų vertė (€)',
};

const columnTooltips = {
    reporting_year: 'Metai, kuriems taikoma ataskaita.',
    governance_structure: 'Organizacijos valdymo struktūros aprašymas.',
    board_size: 'Bendras valdybos narių skaičius.',
    independent_members: 'Nepriklausomų valdybos narių skaičius.',
    chair_is_executive: 'Ar valdybos pirmininkas taip pat eina vykdomąsias pareigas.',
    delegation_of_responsibility: 'Kaip valdyba deleguoja atsakomybę už ESG klausimus.',
    reporting_frequency: 'Kaip dažnai valdyba gauna ESG ataskaitas.',
    board_review_of_esg: 'Ar valdyba peržiūri ESG strategiją ir rezultatus.',
    conflict_of_interest_policy: 'Ar organizacijoje galioja interesų konflikto politika.',
    policy_code_of_ethics: 'Ar organizacija turi etikos kodeksą.',
    ethics_advice_mechanism: 'Galimybės darbuotojams gauti etikos patarimus.',
    report_misconduct_mechanism: 'Priemonės, kaip darbuotojai gali pranešti apie netinkamą elgesį.',
    compliance_violations_count: 'Registruotų atitikties pažeidimų per ataskaitinį laikotarpį skaičius.',
    compliance_fines_value: 'Skirtų baudų suma dėl teisės aktų pažeidimų.',
};
</script>

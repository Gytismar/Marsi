<template>
    <GriTable
        apiEndpoint="/api/v1/gri/g302-energy"
        title="GRI 302 Energy"
        infoUrl="https://www.youtube.com/watch?v=xvFZjo5PgG0&pp=ygUJcmljayByb2xs"
        infoTooltip="Click to learn more about GRI 302: Energy"
        :columnLabels="columnLabels"
        :columnTooltips="columnTooltips"
    />
</template>

<script setup>
import GriTable from '../Components/GriTable.vue';

const columnLabels = {
    company_id: 'Company ID',
    reporting_year: 'Reporting Year',
    total_energy_consumed: 'Total Energy (MWh)',
    renewable_energy_consumed: 'Renewable Energy (MWh)',
    nonrenewable_energy_consumed: 'Non-Renewable Energy (MWh)',
    energy_consumed_unit: 'Unit of Measurement',
    energy_intensity: 'Energy Intensity',
    reduction_achieved: 'Reduction Achieved (%)',
    source: 'Data Source',
};

const columnTooltips = {
    company_id: 'Identifier for the company.',
    reporting_year: 'Year for which the data was reported.',
    total_energy_consumed: 'Total energy consumed during the reporting period.',
    renewable_energy_consumed: 'Amount of energy from renewable sources like solar, wind, etc.',
    nonrenewable_energy_consumed: 'Amount of energy from non-renewable sources such as fossil fuels.',
    energy_consumed_unit: 'Unit used to measure energy (e.g., MWh, GJ).',
    energy_intensity: 'Ratio of energy consumption relative to a business metric like revenue or output.',
    reduction_achieved: 'Percentage reduction in energy usage due to efficiency measures.',
    source: 'Explanation or reference for where this energy data was obtained.',
};
</script>

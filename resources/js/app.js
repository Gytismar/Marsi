import './bootstrap';
import '../css/app.css';
import { createApp } from 'vue';

import Home from '../Pages/Home.vue';
import Gri302EnergyPage from '../Pages/Gri302EnergyPage.vue';
import Gri303WaterPage from "../Pages/Gri303WaterPage.vue";
import Gri305EmissionPage from "../Pages/Gri305EmissionPage.vue";
import Gri306WastePage from "../Pages/Gri306WastePage.vue";
import Gri403HealthSafetyPage from "../Pages/Gri403HealthSafetyPage.vue";
import Gri2GovernancePage from "../Pages/Gri2GovernancePage.vue";

const pages = {
    home: Home,
    gri302: Gri302EnergyPage,
    gri303: Gri303WaterPage,
    gri305: Gri305EmissionPage,
    gri306: Gri306WastePage,
    gri403: Gri403HealthSafetyPage,
    gri2: Gri2GovernancePage,
};

const el = document.getElementById('app');
const page = el?.dataset.page;

if (page && pages[page]) {
    createApp(pages[page]).mount('#app');
}

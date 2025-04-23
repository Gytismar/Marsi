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
import DataPage from "../Pages/DataPage.vue";
import InfoPage from "../Pages/InfoPage.vue";
import GriInfo302 from "../Pages/GriInfo302.vue";
import GriInfo303 from "../Pages/GriInfo303.vue";
import GriInfo305 from "../Pages/GriInfo305.vue";
import GriInfo306 from "../Pages/GriInfo306.vue";
import GriInfo403 from "../Pages/GriInfo403.vue";
import GriInfo2 from "../Pages/GriInfo2.vue";

const pages = {
    home: Home,
    data: DataPage,
    info: InfoPage,

    gri302: Gri302EnergyPage,
    gri303: Gri303WaterPage,
    gri305: Gri305EmissionPage,
    gri306: Gri306WastePage,
    gri403: Gri403HealthSafetyPage,
    gri2: Gri2GovernancePage,

    griinfo302: GriInfo302,
    griinfo303: GriInfo303,
    griinfo305: GriInfo305,
    griinfo306: GriInfo306,
    griinfo403: GriInfo403,
    griinfo2: GriInfo2,
};

const el = document.getElementById('app');
const page = el?.dataset.page;

if (page && pages[page]) {
    createApp(pages[page]).mount('#app');
}

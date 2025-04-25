import './bootstrap';
import '../css/app.css';
import { createApp } from 'vue';

import Home from '../Pages/Home.vue';
import Gri302EnergyPage from '../Pages/Data collection/Gri302EnergyPage.vue';
import Gri303WaterPage from "../Pages/Data collection/Gri303WaterPage.vue";
import Gri305EmissionPage from "../Pages/Data collection/Gri305EmissionPage.vue";
import Gri306WastePage from "../Pages/Data collection/Gri306WastePage.vue";
import Gri403HealthSafetyPage from "../Pages/Data collection/Gri403HealthSafetyPage.vue";
import Gri2GovernancePage from "../Pages/Data collection/Gri2GovernancePage.vue";
import DataPage from "../Pages/Data collection/DataPage.vue";
import InfoPage from "../Pages/Info/InfoPage.vue";
import GriInfo302 from "../Pages/Info/GriInfo302.vue";
import GriInfo303 from "../Pages/Info/GriInfo303.vue";
import GriInfo305 from "../Pages/Info/GriInfo305.vue";
import GriInfo306 from "../Pages/Info/GriInfo306.vue";
import GriInfo403 from "../Pages/Info/GriInfo403.vue";
import GriInfo2 from "../Pages/Info/GriInfo2.vue";

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

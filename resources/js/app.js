import './bootstrap';
import '../css/app.css';
import { createApp } from 'vue';

import Home from '../Pages/Home.vue';
import Gri302EnergyPage from '../Pages/Gri302EnergyPage.vue';

const pages = {
    home: Home,
    gri302: Gri302EnergyPage,
};

const el = document.getElementById('app');
const page = el?.dataset.page;

if (page && pages[page]) {
    createApp(pages[page]).mount('#app');
}

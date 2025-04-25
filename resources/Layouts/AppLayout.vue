<template>
    <div class="app-layout">
        <header class="app-header">
            <div class="logo">
                <img :src="logo" alt="Marsi Logo" />
            </div>

            <div class="relative user-greeting" @click="toggleDropdown">
                <span v-if="userName">Sveiki, {{ userName }}!</span>
                <span v-else>Įkeliama...</span>
                <span class="dropdown-arrow">▾</span>

                <div v-if="dropdownOpen" class="dropdown-menu">
                    <button @click="logout" class="dropdown-item">Atsijungti</button>
                </div>
            </div>
        </header>

        <div class="app-body">
            <aside class="sidebar">
                <nav>
                    <ul>
                        <li v-for="item in menuItems" :key="item.text">
                            <a
                                v-if="item.route"
                                :href="item.route"
                                class="menu-link"
                                style="display: flex; align-items: center; gap: 0.75rem; text-decoration: none; color: inherit;"
                            >
                                <img :src="item.icon" :alt="`${item.text} Icon`" />
                                <span>{{ item.text }}</span>
                            </a>
                            <div v-else style="display: flex; align-items: center; gap: 0.75rem;">
                                <img :src="item.icon" :alt="`${item.text} Icon`" />
                                <span>{{ item.text }}</span>
                            </div>
                        </li>
                    </ul>
                </nav>
            </aside>

            <main class="main-content">
                <slot />
            </main>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import logo from '@/assets/icons/logo.jpg';
import homeIcon from '@/assets/icons/home.png';
import dataIcon from '@/assets/icons/data.png';
import reportsIcon from '@/assets/icons/reports.png';
import infoIcon from '@/assets/icons/info.png';

const userName = ref('');
const dropdownOpen = ref(false);

const menuItems = [
    { text: 'Pagrindinis', icon: homeIcon, route: '/pagrindinis' },
    { text: 'Duomenys', icon: dataIcon, route: '/duomenys' },
    { text: 'Ataskaitos', icon: reportsIcon },
    { text: 'Informacija', icon: infoIcon, route: '/informacija' },
];

onMounted(async () => {
    try {
        const response = await axios.get('/v1/me');
        userName.value = response.data.user?.name ?? 'Vartotojas';
    } catch (error) {
        console.error('Klaida gaunant vartotojo informaciją:', error);
        userName.value = 'Vartotojas';
    }
});

function toggleDropdown() {
    dropdownOpen.value = !dropdownOpen.value;
}

async function logout() {
    try {
        await axios.post('/logout');
        window.location.href = '/login';
    } catch (error) {
        console.error('Klaida atsijungiant:', error);
    }
}
</script>

<style scoped>
.app-layout {
    display: flex;
    flex-direction: column;
    height: 100vh;
    margin: 0;
    padding: 0;
}

.app-header {
    background-color: #349868;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 1.5rem;
    height: 100px;
    min-height: 100px;
    max-height: 100px;
    color: white;
    box-sizing: border-box;
}

.logo {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-left: 2.5rem;
}

.logo img {
    height: 70px;
    width: auto;
}

.user-greeting {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-weight: bold;
    cursor: pointer;
    position: relative;
}

.dropdown-arrow {
    margin-left: 0.5rem;
}

.dropdown-menu {
    position: absolute;
    top: 100%;
    right: 0;
    background: white;
    color: black;
    border: 1px solid #ccc;
    border-radius: 0.5rem;
    min-width: 120px;
    margin-top: 0.5rem;
    z-index: 100;
}

.dropdown-item {
    display: block;
    width: 100%;
    padding: 0.75rem 1rem;
    text-align: left;
    background: none;
    border: none;
    cursor: pointer;
}

.dropdown-item:hover {
    background-color: #f0f0f0;
}

.app-body {
    display: flex;
    flex: 1;
}

.sidebar {
    width: 200px;
    flex-shrink: 0;
    flex-grow: 0;
    background-color: #efefef;
    padding: 1rem 0.5rem;
    box-sizing: border-box;
}

.sidebar nav ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.sidebar nav ul li {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 0.5rem;
    cursor: pointer;
    font-size: 1.1rem;
    margin-bottom: 1rem;
}

.sidebar nav ul li:hover {
    background-color: #d3d3d3;
    border-radius: 8px;
}

.sidebar img {
    width: 32px;
    height: 32px;
}

.main-content {
    flex: 1;
    padding: 1rem;
    background-color: #ffffff;
}
</style>

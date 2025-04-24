<template>
    <div class="app-layout">
        <header class="app-header">
            <div class="logo">
                <img :src="logo" alt="Marsi Logo" />
            </div>
            <div class="user-greeting">
                <span>Sveiki, Vartotojas!</span>
                <span class="dropdown-arrow">▾</span>
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
import logo from '@/assets/icons/logo.jpg';
import homeIcon from '@/assets/icons/home.png';
import dataIcon from '@/assets/icons/data.png';
import reportsIcon from '@/assets/icons/reports.png';
import infoIcon from '@/assets/icons/info.png';

const menuItems = [
    { text: 'Pagrindinis', icon: homeIcon, route: '/pagrindinis' },
    { text: 'Duomenys', icon: dataIcon, route: '/duomenys' },
    { text: 'Ataskaitos', icon: reportsIcon },
    { text: 'Informacija', icon: infoIcon, route: '/informacija' },
];
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
}

.app-body {
    display: flex;
    flex: 1;
}

.sidebar {
    width: 200px;
    background-color: #efefef;
    padding: 1rem 0.5rem;
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

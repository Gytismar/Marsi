<template>
    <AppLayout>
        <div class="max-w-4xl mx-auto px-6 py-12 space-y-12">
            <section class="text-center space-y-4">
                <h1 class="text-4xl font-bold text-green-700">Sveiki atvykę į tvarumo informacinę sistemą</h1>
                <p class="text-lg text-gray-700">
                    Ši platforma skirta skaidriai ir efektyviai valdyti organizacijos duomenis apie aplinkosaugą, sveikatą ir valdymą.
                </p>
                <p class="text-md text-gray-600">
                    Mūsų misija – skatinti atsakingą ir tvarų požiūrį į aplinką bei socialinę atsakomybę pasitelkiant duomenis ir technologijas.
                </p>
            </section>

            <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <a href="/duomenys" class="p-6 bg-white shadow rounded-lg hover:shadow-lg transition-all border border-gray-200 text-center flex flex-col items-center gap-4">
                    <img src="@/assets/icons/data.png" alt="Duomenys" class="w-12 h-12">
                    <span class="text-lg font-medium text-gray-800">Duomenys</span>
                    <p class="text-sm text-gray-600">Naršykite, analizuokite ir importuokite organizacijos duomenis.</p>
                </a>

                <a href="/ataskaitos" class="p-6 bg-white shadow rounded-lg hover:shadow-lg transition-all border border-gray-200 text-center flex flex-col items-center gap-4">
                    <img src="@/assets/icons/reports.png" alt="Ataskaitos" class="w-12 h-12">
                    <span class="text-lg font-medium text-gray-800">Ataskaitos</span>
                    <p class="text-sm text-gray-600">Peržiūrėkite ir analizuokite organizacijos ataskaitas apie tvarumą.</p>
                </a>

                <a href="/informacija" class="p-6 bg-white shadow rounded-lg hover:shadow-lg transition-all border border-gray-200 text-center flex flex-col items-center gap-4">
                    <img src="@/assets/icons/info.png" alt="Informacija" class="w-12 h-12">
                    <span class="text-lg font-medium text-gray-800">Informacija</span>
                    <p class="text-sm text-gray-600">Susipažinkite su GRI standartais ir mūsų atsakomybės principais.</p>
                </a>
            </section>

            <section class="bg-green-50 border-l-4 border-green-500 p-6 rounded-md shadow-sm">
                <h2 class="text-xl font-semibold text-green-700 mb-2">Kodėl tvarumas svarbus?</h2>
                <p class="text-gray-700">
                    Tvarumas – tai ne tik atsakomybė prieš gamtą, bet ir išmintingas verslo sprendimas. Tvari įmonė kuria ilgalaikę vertę,
                    stiprina savo reputaciją ir prisideda prie geresnio pasaulio kūrimo.
                </p>
            </section>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '../Layouts/AppLayout.vue';
</script>

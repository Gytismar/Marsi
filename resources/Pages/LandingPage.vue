<template>
    <div class="min-h-screen bg-white flex flex-col">
        <!-- Header -->
        <header class="flex justify-between items-center p-6" style="background-color: #349868; color: white;">
            <div class="flex items-center gap-3">
                <img src="@/assets/icons/logo.jpg" alt="Marsi Logo" class="h-16 w-auto">
            </div>
            <div class="space-x-4">
                <a href="/login" class="px-5 py-2 bg-white text-green-700 rounded-full font-semibold hover:bg-green-100 transition">
                    Prisijungti
                </a>
                <a href="/register" class="px-5 py-2 bg-green-500 rounded-full font-semibold hover:bg-green-600 transition">
                    Registruotis
                </a>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="flex-1 flex flex-col justify-center items-center text-center px-6 py-20 bg-green-50">
            <h1 class="text-5xl font-bold text-green-700 max-w-4xl leading-tight mb-6">
                Tvarumas yra daugiau nei tikslas – tai būtinybė verslo ateičiai.
            </h1>
            <p class="text-gray-700 text-lg max-w-2xl mb-8">
                Prisijunkite prie platformos, kuri padeda įmonėms skaidriai rinkti ir valdyti duomenis, kurti atsakingesnį rytojų ir stiprinti reputaciją.
            </p>
            <div class="flex gap-4">
                <a href="/register" class="px-8 py-3 bg-green-700 text-white rounded-full text-lg font-semibold hover:bg-green-800 transition">
                    Pradėti dabar
                </a>
                <a href="/login" class="px-8 py-3 bg-white border border-green-700 text-green-700 rounded-full text-lg font-semibold hover:bg-green-100 transition">
                    Prisijungti
                </a>
            </div>
        </section>

        <!-- Why Sustainability Section -->
        <section class="py-20 px-6 bg-white text-center">
            <h2 class="text-4xl font-bold text-green-700 mb-10">
                Kodėl tvarumas yra esminis šiandienos verslui?
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 max-w-6xl mx-auto">
                <div class="bg-green-50 p-8 rounded-lg shadow hover:shadow-lg transition">
                    <h3 class="text-2xl font-semibold mb-4">Atsakomybė</h3>
                    <p class="text-gray-600">
                        Įmonės, investuojančios į tvarumą, rodo rūpestį aplinka, darbuotojais ir visuomene.
                    </p>
                </div>
                <div class="bg-green-50 p-8 rounded-lg shadow hover:shadow-lg transition">
                    <h3 class="text-2xl font-semibold mb-4">Vertė ir reputacija</h3>
                    <p class="text-gray-600">
                        Tvarūs sprendimai didina prekės ženklo patrauklumą ir lojalumą tarp klientų bei partnerių.
                    </p>
                </div>
                <div class="bg-green-50 p-8 rounded-lg shadow hover:shadow-lg transition">
                    <h3 class="text-2xl font-semibold mb-4">Reguliaciniai reikalavimai</h3>
                    <p class="text-gray-600">
                        Atitikite tarptautinius standartus ir pasiruoškite augantiems teisės aktų reikalavimams.
                    </p>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-20 px-6 bg-green-50 text-center">
            <h2 class="text-4xl font-bold text-green-700 mb-10">
                Kaip MARSI gali padėti jūsų organizacijai
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 max-w-6xl mx-auto">
                <div class="p-8 bg-white rounded-lg shadow hover:shadow-lg transition">
                    <h3 class="text-xl font-semibold mb-3 text-green-700">Automatizuotas duomenų rinkimas</h3>
                    <p class="text-gray-600">
                        Centralizuokite svarbiausius tvarumo rodiklius be papildomo vargo.
                    </p>
                </div>
                <div class="p-8 bg-white rounded-lg shadow hover:shadow-lg transition">
                    <h3 class="text-xl font-semibold mb-3 text-green-700">Analizės ir vizualizacijos įrankiai</h3>
                    <p class="text-gray-600">
                        Stebėkite pažangą ir lengvai generuokite tvarumo ataskaitas.
                    </p>
                </div>
                <div class="p-8 bg-white rounded-lg shadow hover:shadow-lg transition">
                    <h3 class="text-xl font-semibold mb-3 text-green-700">Atitikimas GRI standartams</h3>
                    <p class="text-gray-600">
                        Užtikrinkite skaidrumą ir profesionalumą naudodami pasaulinius tvarumo standartus.
                    </p>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="text-center text-gray-500 p-6">
            © 2025 MARSI – Tvarių sprendimų platforma.
        </footer>
    </div>
</template>

<script setup>
// no script needed yet
</script>

<style scoped>
/* optional enhancements */
</style>

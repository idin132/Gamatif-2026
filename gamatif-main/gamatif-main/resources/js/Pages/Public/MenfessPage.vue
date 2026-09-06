<template>
    <div class="container mx-auto p-4 md:p-8 mt-10">
        <header class="text-center mb-8">
            <router-link to="/buat-menfess" class="text-pink-500 hover:text-pink-600 transition">
                <h1 class="font-comic text-5xl md:text-7xl font-bold drop-shadow-md">GAMAFESS</h1>
            </router-link>
            <p class="text-gray-500 mt-2 text-lg">GAMATIF CONFESS</p>
            <p class="text-gray-500 mt-2 text-md">Klik salah satu kartu untuk post di story Instagram!</p>
        </header>

        <main>
            <div class="text-center mb-8">
                <router-link to="/buat-menfess" class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-3 px-6 rounded-full shadow-lg transform hover:scale-105 transition-transform duration-300 ease-in-out inline-flex items-center justify-center mx-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="16"></line>
                        <line x1="8" y1="12" x2="16" y2="12"></line>
                    </svg>
                    Buat Menfess Baru
                </router-link>
            </div>
            
            <div v-if="isLoading" class="text-center py-10 flex flex-col items-center">
                 <svg class="animate-spin -ml-1 mr-3 h-8 w-8 text-pink-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                <p class="text-pink-500 mt-4">Memuat menfess...</p>
            </div>

            <div v-else class="masonry-grid">
                <router-link v-for="(menfess, index) in menfesses" :key="menfess.id" 
                     :to="'/detail-menfess/' + menfess.id"
                     :class="getRandomColor(index)"
                     class="card block p-6 rounded-2xl shadow-md cursor-pointer hover:shadow-xl hover:-translate-y-1 transition-all duration-300"
                     :style="{ animationDelay: (index * 100) + 'ms' }">
                    <p class="text-gray-600 text-sm mb-2">Untuk: <span class="font-semibold text-pink-700">{{ menfess.to }}</span></p>
                    <p class="text-gray-800 mb-4 text-lg break-words">“{{ menfess.message }}”</p>
                    <p class="text-right text-gray-500 text-sm font-semibold break-words">— {{ menfess.from }}</p>
                </router-link>
            </div>
        </main>
    </div>
</template>

<script setup>
import { onMounted, computed } from 'vue';
import { useMenfessStore } from "@/Stores/menfessStore";

// Menggunakan store
const menfessStore = useMenfessStore();

// Mengambil data secara reaktif dari store menggunakan computed properties
const menfesses = computed(() => menfessStore.menfesses);
const isLoading = computed(() => menfessStore.loading);

const cardColors = ['bg-yellow-100', 'bg-blue-100', 'bg-green-100', 'bg-purple-100', 'bg-rose-100'];
const getRandomColor = (index) => cardColors[index % cardColors.length];

// Memanggil action dari store saat komponen dimuat
onMounted(() => {
    menfessStore.fetchMenfesses();
});
</script>

<style>
body { 
    font-family: 'Poppins', sans-serif; 
    background-color: #FFF7F9; 
}
.font-comic { 
    font-family: 'Comic Neue', cursive; 
}
.card { 
    break-inside: avoid; 
    margin-bottom: 1.5rem; 
    opacity: 0; 
    transform: translateY(20px); 
    animation: fadeIn 0.5s forwards; 
}
.masonry-grid { 
    column-count: 1; 
}
@media (min-width: 640px) { 
    .masonry-grid { 
        column-count: 2; 
        column-gap: 1.5rem; 
    } 
}
@media (min-width: 1024px) { 
    .masonry-grid { 
        column-count: 3; 
    } 
}
@keyframes fadeIn { 
    to { 
        opacity: 1; 
        transform: translateY(0); 
    } 
}
</style>


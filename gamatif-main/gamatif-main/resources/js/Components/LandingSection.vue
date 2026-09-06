<template>
    <div id="beranda" class="pt-15 sm:pt-30 mb-30 w-full grid grid-cols-1 md:grid-cols-2 items-center">
        <div class="text-center md:text-left">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight leading-tight mb-4">
                Selamat Datang di
                <span class="underline underline-offset-3 decoration-8 decoration-yellow-400 dark:decoration-yellow-600">
                    Keluarga Besar
                </span>
                Teknik Informatika UNIKOM.
            </h1>

            <p class="text-lg lg:text-xl text-gray-400 mb-8">
                Di sini, kamu akan mengubah rasa ingin tahu menjadi baris kode,
                tantangan menjadi solusi, dan ide menjadi inovasi masa depan.
            </p>

            <a
                href="#tentang"
                class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-center text-white bg-yellow-600 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:ring-yellow-300 dark:focus:ring-yellow-900 transition"
            >
                Mulai Jelajahi
                <svg class="w-4 h-4 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                </svg>
            </a>
        </div>

        <div class="p-4 flex justify-center md:justify-end">
            <div v-if="isPengaturanLoading">
                <SkeletonLoader customClass="h-96 w-80 rounded-lg" />
            </div>
            
            <img v-else :src="maskotUrl" alt="Maskot Gamatif" class="h-auto max-h-96" loading="lazy"/>
        </div>
    </div>
</template>

<script setup>
import { onMounted, computed } from "vue";
import { storeToRefs } from "pinia";
import { usePengaturanWebStore } from "@/Stores/pengaturanWebStore";
import SkeletonLoader from '@/Components/SkeletonLoader.vue';

const pengaturanWebStore = usePengaturanWebStore();
// 2. Ambil juga state `isLoading` dari store
const { pengaturanWeb, isLoading: isPengaturanLoading } = storeToRefs(pengaturanWebStore);

onMounted(() => {
    pengaturanWebStore.fetchPengaturanWeb();
});

const maskotUrl = computed(() => {
    if (pengaturanWeb.value[0]?.logo_maskot) {
        return `${window.location.origin}/storage/${pengaturanWeb.value[0].logo_maskot}`;
    }
    return "/images/maskot.png"; // fallback lokal
});
</script>
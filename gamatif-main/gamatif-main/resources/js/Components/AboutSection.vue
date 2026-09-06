<template>
    <div id="tentang" class="py-16 sm:py-24">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-extrabold tracking-tight sm:text-4xl mb-4">
                Tentang GAMATIF 2025
            </h2>

            <p class="text-lg text-gray-400">
                Sebuah wadah untuk menyambut, merangkul, dan menginspirasi
                generasi baru pemimpin teknologi di Teknik Informatika.
            </p>

            <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8 text-left">
                <!-- Loop card -->
                <div
                    v-for="(item, i) in cards"
                    :key="i"
                    class="bg-gray-800 p-6 rounded-lg transition transform hover:scale-105 group"
                >
                    <div
                        class="flex items-center justify-center h-12 w-12 rounded-md text-white mb-4 transition group-hover:shadow-[0_0_15px_3px_rgba(234,179,8,0.5)]"
                        :class="item.bgColor"
                    >
                        <component :is="item.icon" class="h-6 w-6" />
                    </div>

                    <h3 class="text-xl font-bold text-white">
                        {{ item.title }}
                    </h3>
                    <p class="mt-2 text-base text-gray-400">{{ item.desc }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { h } from "vue";

// Buat daftar card
const cards = [
    {
        title: "Kebersamaan",
        desc: "Membangun solidaritas dan jaringan sosial antar mahasiswa baru, rekan mahasiswa antar angkatan, dan dosen serta civitas akademik untuk menciptakan lingkungan kampus yang nyaman dan suportif.",
        bgColor: "bg-yellow-600",
        icon: {
            render() {
                return h(
                    "svg",
                    {
                        xmlns: "http://www.w3.org/2000/svg",
                        fill: "none",
                        viewBox: "0 0 24 24",
                        stroke: "currentColor",
                        class: "h-6 w-6",
                    },
                    [
                        h("path", {
                            "stroke-linecap": "round",
                            "stroke-linejoin": "round",
                            "stroke-width": "2",
                            d: "M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z",
                        }),
                    ]
                );
            },
        },
    },
    {
        title: "Kepemimpinan",
        desc: "Mendorong kemampuan komunikasi, kerja sama, dan pengambilan keputusan melalui aktivitas kelompok yang melatih strategi, problem-solving, dan jiwa kepemimpinan.",
        bgColor: "bg-yellow-600",
        icon: {
            render() {
                return h(
                    "svg",
                    {
                        xmlns: "http://www.w3.org/2000/svg",
                        fill: "none",
                        viewBox: "0 0 24 24",
                        stroke: "currentColor",
                        class: "h-6 w-6",
                    },
                    [
                        h("path", {
                            "stroke-linecap": "round",
                            "stroke-linejoin": "round",
                            "stroke-width": "2",
                            d: "M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z",
                        }),
                    ]
                );
            },
        },
    },
    {
        title: "Pengembangan Diri",
        desc: "Memberikan ruang eksplorasi potensi, mengenalkan budaya akademik dan organisasi, serta menanamkan nilai kemandirian dan tanggung jawab untuk menghadapi dunia perkuliahan.",
        bgColor: "bg-yellow-600",
        icon: {
            render() {
                return h(
                    "svg",
                    {
                        xmlns: "http://www.w3.org/2000/svg",
                        fill: "none",
                        viewBox: "0 0 24 24",
                        stroke: "currentColor",
                        class: "h-6 w-6",
                    },
                    [
                        h("path", {
                            "stroke-linecap": "round",
                            "stroke-linejoin": "round",
                            "stroke-width": "2",
                            d: "M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z",
                        }),
                    ]
                );
            },
        },
    },
];
</script>

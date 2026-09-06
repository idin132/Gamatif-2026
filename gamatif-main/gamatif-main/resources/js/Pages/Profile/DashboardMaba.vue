<template>
    <div class="p-8 mt-10" v-if="user">
        <!-- Judul -->
        <h1 class="text-3xl font-bold mb-8 text-gray-800">
            Selamat Datang,
            <span class="text-yellow-600">{{ user.nama_lengkap }}</span> 🎉
        </h1>

        <!-- Grid Bento -->
        <div class="grid grid-cols-1 md:grid-cols-6 gap-6">
            <!-- Kartu Profil -->
            <div
                class="md:col-span-2 bg-white rounded-2xl shadow-sm hover:shadow-md p-6 flex flex-col items-center justify-center transition"
            >
                <img
                    :src="`https://ui-avatars.com/api/?name=${user.nama_lengkap}&background=eab308&color=fff`"
                    class="w-20 h-20 rounded-full mb-4"
                />
                <h2 class="text-xl font-semibold text-gray-800">
                    {{ user.nama_lengkap }}
                </h2>
                <p class="text-sm text-gray-500">NIM: {{ user.nim }}</p>

                <p class="text-sm text-gray-500">
                    Kelompok:
                    <span
                        v-if="user.kelompok"
                        class="text-gray-800 font-medium"
                    >
                        {{ user.kelompok.nama_kelompok }}
                    </span>
                    <span v-else class="text-gray-300"
                        >belum mengambil kelompok</span
                    >
                </p>

                <div class="flex gap-2 mt-4">
                    <button
                        class="bg-yellow-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-yellow-600 cursor-pointer"
                        @click="goToProfile"
                    >
                        Lihat Profil
                    </button>

                    <button
                        v-if="!user.kelompok"
                        class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-600 cursor-pointer"
                        @click="goToAmbilKelompok"
                    >
                        Ambil Kelompok
                    </button>
                </div>
            </div>

            <div
                class="md:col-span-1 bg-white rounded-2xl shadow-sm hover:shadow-md p-6 flex flex-col items-center transition gap-2"
            >
                <button
                    :disabled="!user.kelompok"
                    class="text-white px-4 py-2 rounded-lg text-sm w-full"
                    :class="
                        user.kelompok
                            ? 'bg-green-500 hover:bg-green-600 cursor-pointer'
                            : 'bg-gray-300 cursor-not-allowed'
                    "
                    @click="goToGrup"
                >
                    Gabung Grup
                </button>
                <button
                    class="text-white px-4 py-2 rounded-lg text-sm w-full"
                    @click="openBukuSaku"
                    :disabled="!isBukuSakuAvailable"
                    :class="
                        isBukuSakuAvailable
                            ? 'bg-yellow-500 hover:bg-yellow-600 cursor-pointer'
                            : 'bg-gray-300 cursor-not-allowed'
                    "
                >
                    Buku Panduan
                </button>

                <button
                    :disabled="!user.kelompok"
                    class="text-white px-4 py-2 rounded-lg text-sm w-full"
                    @click="goToAbsen"
                    :class="
                        user.kelompok
                            ? 'bg-blue-500 hover:bg-blue-600 cursor-pointer'
                            : 'bg-gray-300 cursor-not-allowed'
                    "
                >
                    Absen
                </button>
                <!-- <button
                    :disabled="!user.kelompok"
                    disabled
                    class="text-white px-4 py-2 rounded-lg text-sm w-full"
                    :class="
                        user.kelompok
                            ? 'bg-yellow-500 hover:bg-yellow-600'
                            : 'bg-gray-300'
                    "
                    @click=""
                >
                    Absen
                </button> -->
            </div>
            <!-- Jadwal -->
            <div
                class="md:col-span-3 bg-gradient-to-br from-yellow-100 to-yellow-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition"
            >
                <h2 class="text-lg font-semibold mb-4 text-gray-800">
                    📅 Jadwal Kegiatan
                </h2>
                <!-- Tampilan Loading -->
                <div v-if="isJadwalLoading" class="space-y-4">
                    <div v-for="n in 3" :key="n">
                        <SkeletonLoader customClass="h-4 w-3/4 mb-2" />
                        <SkeletonLoader customClass="h-3 w-1/2" />
                    </div>
                </div>
                <!-- Tampilan Error -->
                <div v-if="jadwalError" class="text-sm text-red-500">
                    {{ jadwalError }}
                </div>
                <!-- Tampilan Data -->
                <ul v-else class="space-y-2 text-sm text-gray-700">
                    <li
                        v-for="item in jadwalKegiatan"
                        :key="item.id"
                        class="border-b pb-2"
                    >
                        <div class="font-semibold">{{ item.nama }}</div>
                        <div class="text-gray-500">
                            {{ item.tanggal }} | {{ item.waktu_mulai }} -
                            {{ item.waktu_selesai }}
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Pengumuman -->
            <div
                class="md:col-span-3 bg-white rounded-2xl shadow-sm hover:shadow-md p-6 transition"
            >
                <h2 class="text-lg font-semibold mb-4 text-gray-800">
                    📢 Pengumuman
                </h2>
                <div class="space-y-3 text-sm text-gray-600">
                    <p class="border-l-4 border-yellow-400 pl-3">
                        Coming Soon ✨
                    </p>
                </div>
            </div>

            <!-- Sosial Media -->
            <div
                class="md:col-span-3 bg-white rounded-2xl shadow-sm hover:shadow-md p-6 transition"
            >
                <h2 class="text-lg font-semibold mb-4 text-gray-800">
                    📲 Jangan Lupa Follow Yaa!!
                </h2>
                <!-- Tampilan Loading -->

                <div
                    v-if="isSosmedLoading"
                    role="status"
                    class="space-y-3 animate-pulse"
                >
                    <div
                        v-for="n in 2"
                        :key="n"
                        class="h-10 bg-gray-200 rounded-md dark:bg-gray-700 w-full"
                    ></div>
                    <span class="sr-only">Loading...</span>
                </div>
                <!-- Tampilan Error -->
                <div v-if="sosmedError" class="text-sm text-red-500">
                    {{ sosmedError }}
                </div>

                <!-- Tampilan Data -->
                <div v-else class="space-y-3 text-sm">
                    <a
                        v-for="item in sosialMedia"
                        :key="item.id"
                        :href="item.url"
                        target="_blank"
                        class="block border-l-4 border-yellow-500 bg-gray-100 dark:bg-gray-800 px-4 py-2 rounded-r-md text-gray-700 dark:text-gray-300 hover:bg-yellow-100 dark:hover:bg-gray-700 transition font-medium"
                    >
                        {{ item.nama }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import SkeletonLoader from "@/Components/SkeletonLoader.vue";
import { onMounted, watch, computed } from "vue"; // 1. Impor 'watch'
import { useRouter, useRoute } from "vue-router"; // 2. Impor 'useRoute'
import { storeToRefs } from "pinia";
import { useAuthStore } from "@/Stores/authStore";
import { useJadwalKegiatanStore } from "@/Stores/jadwalKegiatanStore";
import { useSosialMediaStore } from "@/Stores/sosialMediaStore";
import { usePengaturanWebStore } from "@/Stores/pengaturanWebStore";

const pengaturanWebStore = usePengaturanWebStore();
const { pengaturanWeb } = storeToRefs(pengaturanWebStore);

onMounted(() => {
    pengaturanWebStore.fetchPengaturanWeb();
});

const bukuSakuUrl = computed(() => {
    const path = pengaturanWeb.value[0]?.buku_saku; // contoh: /logo_unikom/logo_unikom_baru.png
    return path ? window.location.origin + "/storage/" + path : null;
});

const openBukuSaku = () => {
    if (bukuSakuUrl.value) {
        window.open(bukuSakuUrl.value, "_blank");
    }
};

const isBukuSakuAvailable = computed(() => {
    return !!pengaturanWeb.value[0]?.buku_saku; // true jika ada URL, false jika null/undefined
});

const router = useRouter();
const route = useRoute(); // 3. Dapatkan objek rute saat ini

// --- Stores ---
const authStore = useAuthStore();
const { user, isAuthenticated } = storeToRefs(authStore);
const jadwalStore = useJadwalKegiatanStore();
const {
    jadwalKegiatan,
    isLoading: isJadwalLoading,
    error: jadwalError,
} = storeToRefs(jadwalStore);
const sosmedStore = useSosialMediaStore();
const {
    sosialMedia,
    isLoading: isSosmedLoading,
    error: sosmedError,
} = storeToRefs(sosmedStore);

// 4. Buat fungsi terpusat untuk mengambil data
const fetchData = () => {
    if (isAuthenticated.value) {
        jadwalStore.fetchJadwalKegiatan();
        sosmedStore.fetchSosialMedia();
        authStore.tryAutoLogin();
    }
};

// 5. Awasi perubahan pada rute
watch(
    () => route.path,
    (newPath) => {
        // Jika pengguna bernavigasi KE halaman ini, panggil fetchData
        if (newPath === "/dashboard-maba") {
            // Pastikan path ini sesuai dengan rute Anda
            fetchData();
        }
    },
    { immediate: true } // immediate: true akan menjalankan watch ini saat komponen pertama kali dimuat
);

onMounted(async () => {
    // Coba auto login jika data user belum ada
    if (!user.value) {
        await authStore.tryAutoLogin();
    }

    // Redirect jika tetap tidak login
    if (!isAuthenticated.value) {
        router.push("/login");
    }
    // Tidak perlu memanggil fetchData() lagi di sini karena `watch` dengan `immediate: true` sudah menanganinya.
});

const goToProfile = () => {
    router.push("/profile-maba");
};

const goToGrup = () => {
    const url = user.value?.kelompok?.url_grub;
    if (url) {
        window.open(url, "_blank");
    } else {
        console.warn("URL grup belum tersedia.");
    }
};

const goToAmbilKelompok = () => {
    router.push("/ambil-kelompok");
};
const goToAbsen = () => {
    router.push("/absen-maba");
};
</script>

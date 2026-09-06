<template>
    <div class="min-h-screen bg-gray-100 flex items-center justify-center p-4">
        <div
            class="relative max-w-md w-full text-center bg-white rounded-xl shadow-lg p-8"
        >
            <!-- Error Message Display -->
            <div
                v-if="errors.general && !isGenerating"
                class="mb-4 p-4 bg-red-100 text-red-800 border border-red-300 rounded-lg"
            >
                <p class="text-sm">{{ errors.general[0] }}</p>
            </div>

            <!-- 1. Tampilan saat proses GENERATE/RANDOMIZE (Prioritas Utama) -->
            <div v-if="isGenerating">
                <h1 class="text-2xl font-bold text-gray-800 mb-2">
                    Mengambil Kelompok...
                </h1>
                <p class="text-gray-600 mb-6">Semoga beruntung!</p>
                <div
                    class="bg-gradient-to-r from-yellow-100 to-orange-100 border border-yellow-200 rounded-lg p-6 h-28 flex items-center justify-center"
                >
                    <h2
                        class="text-4xl font-extrabold text-yellow-600 animate-pulse transition-all duration-100"
                    >
                        {{ randomKelompokName }}
                    </h2>
                </div>

                <div class="mt-4">
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div
                            class="bg-yellow-500 h-2 rounded-full transition-all duration-100"
                            :style="{ width: progressWidth + '%' }"
                        ></div>
                    </div>
                    <p class="text-sm text-gray-500 mt-2">{{ progressText }}</p>
                </div>
            </div>

            <!-- 2. Tampilan jika SUDAH punya kelompok -->
            <div v-else-if="kelompok">
                <button
                    class="absolute cursor-pointer top-2 right-3 text-gray-500 hover:text-gray-700"
                    @click="closeCard"
                >
                    ✕
                </button>
                <h1 class="text-2xl font-bold text-gray-800 mb-2">
                    Anda Sudah Terdaftar!
                </h1>
                <p class="text-gray-600 mb-6">Anda adalah bagian dari:</p>
                <div
                    class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 transform transition-all duration-500 hover:scale-105"
                >
                    <h2
                        class="text-4xl font-extrabold text-yellow-600 drop-shadow-sm"
                    >
                        {{ kelompok.nama_kelompok }}
                    </h2>
                </div>
                <a
                    v-if="kelompok.url_grub"
                    :href="kelompok.url_grub"
                    target="_blank"
                    class="mt-6 w-full inline-flex items-center justify-center bg-green-500 hover:bg-green-600 text-white font-semibold py-3 rounded-lg shadow-md transition transform hover:scale-105"
                >
                    <svg
                        class="w-5 h-5 mr-2"
                        fill="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"
                        />
                    </svg>
                    Gabung Grup WhatsApp
                </a>
            </div>

            <!-- 3. Tampilan Loading Awal (Saat mengambil status) -->
            <div v-else-if="isLoading && !isGenerating">
                <div
                    class="animate-spin rounded-full h-12 w-12 border-b-2 border-yellow-500 mx-auto mb-4"
                ></div>
                <p class="text-gray-600">Memeriksa status kelompok...</p>
            </div>

            <!-- 4. Tampilan jika BELUM punya kelompok (DIPERBARUI) -->
            <div v-else>
                <!-- Ilustrasi SVG -->
                <div class="mx-auto mb-6 w-24 h-24 text-yellow-500">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-full h-full"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M21 11.25v8.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 1014.625 7.5H9.375A2.625 2.625 0 1012 4.875z"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 11.25a2.25 2.25 0 00-2.25 2.25v.75a2.25 2.25 0 004.5 0v-.75A2.25 2.25 0 0012 11.25z"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3.75 11.25h16.5"
                        />
                    </svg>
                </div>

                <h1 class="text-3xl font-bold text-gray-800 mb-3">
                    Petualangan Menanti!
                </h1>
                <p class="text-gray-500 mb-8 max-w-xs mx-auto">
                    Satu klik akan menentukan kelompokmu. Siap untuk memulai
                    perjalanan seru ini?
                </p>
                <button
                    @click="handleGenerate"
                    :disabled="isLoading || isGenerating"
                    class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-4 rounded-lg shadow-lg transition-transform transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-yellow-300 disabled:bg-gray-400 disabled:cursor-not-allowed disabled:transform-none"
                >
                    <span class="flex items-center justify-center cursor-pointer">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                            stroke="currentColor"
                            class="w-5 h-5 mr-2 animate-pulse"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.898 20.565L16.5 21.75l-.398-1.185a3.375 3.375 0 00-2.37-2.37L12.75 18l1.185-.398a3.375 3.375 0 002.37-2.37L16.5 14.25l.398 1.185a3.375 3.375 0 002.37 2.37L20.25 18l-1.185.398a3.375 3.375 0 00-2.37 2.37z"
                            />
                        </svg>
                        Ambil Kelompokku Sekarang!
                    </span>
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref, watch, onUnmounted } from "vue";
import { useRouter } from "vue-router";
import { useAuthStore } from "@/Stores/authStore";
import { storeToRefs } from "pinia";
import confetti from "canvas-confetti";

const router = useRouter();
const authStore = useAuthStore();
const { kelompok, isLoading, errors, isAuthenticated } = storeToRefs(authStore);

// State untuk animasi
const isGenerating = ref(false);
const randomKelompokName = ref("");
const progressWidth = ref(0);
const progressText = ref("");

const placeholderKelompok = [
    "Semoga kelompok dia",
    "Takutttt",
    "aaaa!!",
    "Bismillah",
    "Degdegannnn",
    "Sama siapa yaa?????",
    "Ummmmmmm",
    "Semoga dapet pacar hehe",
    "Pengen sama DOIIII",
    "Kelompok Mana ya",
];

const progressMessages = [
    "Menganalisis profil Anda...",
    "Mencari kelompok yang cocok...",
    "Menyeimbangkan distribusi...",
    "Memproses algoritma penempatan...",
    "Hampir selesai...",
];

let randomizeInterval = null;
let progressInterval = null;

onMounted(() => {
    authStore.clearErrors();
    if (isAuthenticated.value) {
        authStore.getKelompokStatus();
    }
});

watch(
    isAuthenticated,
    (newVal) => {
        if (newVal) {
            authStore.getKelompokStatus();
        }
    },
    { immediate: true }
);

const handleGenerate = async () => {
    authStore.clearErrors();
    isGenerating.value = true;
    progressWidth.value = 0;
    let progressStep = 0;

    randomizeInterval = setInterval(() => {
        const randomIndex = Math.floor(
            Math.random() * placeholderKelompok.length
        );
        randomKelompokName.value = placeholderKelompok[randomIndex];
    }, 120);

    progressInterval = setInterval(() => {
        progressWidth.value += 2;
        const messageIndex = Math.floor(progressStep / 20);
        if (messageIndex < progressMessages.length) {
            progressText.value = progressMessages[messageIndex];
        }
        progressStep++;
        if (progressWidth.value >= 95) {
            progressWidth.value = 95; // Jangan selesaikan sebelum API selesai
        }
    }, 80);

    progressText.value = progressMessages[0];

    const minimumDelay = new Promise((resolve) => setTimeout(resolve, 10000));

    try {
        const apiCall = authStore.generateKelompok();
        const [isSuccess] = await Promise.all([apiCall, minimumDelay]);

        progressWidth.value = 100;
        progressText.value = "Selesai!";

        await new Promise((resolve) => setTimeout(resolve, 500));

        clearInterval(randomizeInterval);
        clearInterval(progressInterval);
        isGenerating.value = false;

        if (isSuccess) {
            confetti({
                particleCount: 200,
                spread: 180,
                origin: { y: 0.6 },
                colors: ["#f59e0b", "#10b981", "#3b82f6", "#ef4444", "#8b5cf6"],
            });
            // Redirect to dashboard after success
            // setTimeout(() => {
            //     router.push("/dashboard-maba");
            // }, 2000); // Wait 2 seconds for confetti
        }
    } catch (error) {
        clearInterval(randomizeInterval);
        clearInterval(progressInterval);
        isGenerating.value = false;
        console.error("Error during generation:", error);
    }
};

onUnmounted(() => {
    if (randomizeInterval) clearInterval(randomizeInterval);
    if (progressInterval) clearInterval(progressInterval);
});

const closeCard = () => {
    router.push("/dashboard-maba");
};
</script>

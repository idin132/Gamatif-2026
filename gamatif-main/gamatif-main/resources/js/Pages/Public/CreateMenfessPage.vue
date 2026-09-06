<template>
    <div class="container mx-auto p-4 md:p-8 mt-10">
        <header class="text-center mb-8">
            <router-link
                to="/menfess"
                class="text-pink-500 hover:text-pink-600 transition"
            >
                <h1
                    class="font-comic text-5xl md:text-7xl font-bold drop-shadow-md"
                >
                    GAMAFESS
                </h1>
            </router-link>
            <p class="text-gray-500 mt-2 text-lg">GAMATIF CONFESS</p>
        </header>

        <section class="max-w-lg mx-auto">
            <div class="bg-white p-8 rounded-2xl shadow-xl">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-3xl font-bold text-pink-500">
                        Kirim Pesan Rahasia
                    </h2>
                    <router-link
                        to="/menfess"
                        class="text-gray-400 hover:text-gray-600"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="15" y1="9" x2="9" y2="15"></line>
                            <line x1="9" y1="9" x2="15" y2="15"></line>
                        </svg>
                    </router-link>
                </div>
                <form @submit.prevent="submitMenfess">
                    <div class="mb-4">
                        <label
                            for="to"
                            class="block text-gray-700 text-sm font-bold"
                            >Untuk:</label
                        >
                        <p class="text-xs text-pink mt-1 mb-2">
                            Mention instagramnya yuk >.<
                        </p>
                        <input
                            type="text"
                            v-model="form.to"
                            class="w-full px-4 py-3 rounded-lg bg-gray-100 border-2 border-transparent focus:border-pink-400 focus:bg-white focus:outline-none transition"
                            placeholder="Tulis nama penerima..."
                            required
                        />
                    </div>
                    <div class="mb-4">
                        <label
                            for="message"
                            class="block text-gray-700 text-sm font-bold mb-2"
                            >Pesanmu:</label
                        >
                        <textarea
                            v-model="form.message"
                            rows="5"
                            maxlength="500"
                            class="w-full px-4 py-3 rounded-lg bg-gray-100 border-2 border-transparent focus:border-pink-400 focus:bg-white focus:outline-none transition"
                            placeholder="Apa yang ingin kamu sampaikan?"
                            required
                        ></textarea>
                        <div class="text-right text-sm text-gray-400 mt-1">
                            {{ form.message.length }} / 500
                        </div>
                    </div>
                    <div class="mb-6">
                        <label
                            for="from"
                            class="block text-gray-700 text-sm font-bold mb-2"
                            >Dari: (Opsional)</label
                        >
                        <input
                            type="text"
                            v-model="form.from"
                            class="w-full px-4 py-3 rounded-lg bg-gray-100 border-2 border-transparent focus:border-pink-400 focus:bg-white focus:outline-none transition"
                            placeholder="Namamu atau biarkan rahasia"
                        />
                    </div>
                    <button
                        type="submit"
                        :disabled="isLoading"
                        class="w-full bg-pink-500 hover:bg-pink-600 text-white font-bold py-3 px-6 rounded-full shadow-lg transform hover:scale-105 transition-transform duration-300 ease-in-out flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <svg
                            v-if="isLoading"
                            class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                        >
                            <circle
                                class="opacity-25"
                                cx="12"
                                cy="12"
                                r="10"
                                stroke="currentColor"
                                stroke-width="4"
                            ></circle>
                            <path
                                class="opacity-75"
                                fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                            ></path>
                        </svg>
                        <span v-else>Kirim Sekarang</span>
                    </button>
                </form>
            </div>
        </section>
    </div>
</template>

<script setup>
import { ref, computed } from "vue";
import { useRouter } from "vue-router";
import { useMenfessStore } from "@/Stores/menfessStore";

const router = useRouter();
const menfessStore = useMenfessStore();
const isLoading = computed(() => menfessStore.loading);

const form = ref({
    to: "",
    message: "",
    from: "",
});

const submitMenfess = async () => {
    try {
        const payload = { ...form.value };
        if (!payload.from) {
            payload.from = "Anonymous";
        }

        await menfessStore.createMenfess(payload);

        // Bersihkan form setelah berhasil
        form.value = { to: "", message: "", from: "" };

        // Pindahkan ke halaman utama setelah berhasil
        router.push("/menfess");
    } catch (error) {
        console.error("Gagal mengirim menfess:", error);
        alert("Terjadi kesalahan saat mencoba mengirim menfess.");
    }
};
</script>

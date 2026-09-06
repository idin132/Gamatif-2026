<template>
    <div>
        <!-- Menampilkan indikator loading secara eksplisit dari store -->
        <div v-if="menfessStore.loading" class="text-center mt-12">
            <p>Memuat detail menfess...</p>
        </div>

        <!-- Konten hanya akan dirender jika loading selesai dan data ada -->
        <div v-else-if="menfessStore.currentMenfess">
            <!-- Tampilan utama yang terlihat oleh pengguna -->
            <section class="max-w-2xl mx-auto mt-12">
                <div class="bg-white p-8 rounded-2xl shadow-xl relative">
                    <router-link
                        to="/menfess"
                        class="absolute top-4 right-4 bg-gray-100 hover:bg-gray-200 text-gray-600 p-2 rounded-full transition"
                    >
                        x
                    </router-link>
                    <div class="mt-8 text-center">
                        <p class="text-gray-500 text-lg">Pesan untuk</p>
                        <h2
                            class="text-2xl md:text-4xl font-bold text-pink-500 my-2 break-words"
                        >
                            {{ menfessStore.currentMenfess.to }}
                        </h2>
                        <p
                            class="text-md md:text-2xl text-gray-700 my-8 leading-relaxed break-words"
                        >
                            “{{ menfessStore.currentMenfess.message }}”
                        </p>
                        <p
                            class="text-md md:text-xl text-gray-500 font-semibold break-words"
                        >
                            — {{ menfessStore.currentMenfess.from }}
                        </p>
                        <p class="text-sm text-gray-400 mt-4">
                            {{
                                formatDate(
                                    menfessStore.currentMenfess.created_at
                                )
                            }}
                        </p>
                    </div>
                    <div
                        class="mt-10 pt-6 border-t border-gray-200 flex flex-col sm:flex-row gap-4 justify-center"
                    >
                        <button
                            @click="shareToStory"
                            type="button"
                            class="inline-flex items-center justify-center w-full sm:w-auto text-white bg-gradient-to-r from-purple-500 to-pink-500 hover:bg-gradient-to-l focus:ring-4 focus:outline-none focus:ring-purple-200 font-medium rounded-lg text-sm px-5 py-2.5 cursor-pointer"
                        >
                            Story-kan
                        </button>
                        <button
                            @click="downloadAsImage"
                            type="button"
                            class="inline-flex items-center justify-center w-full sm:w-auto text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 cursor-pointer"
                        >
                            Unduh
                        </button>
                    </div>
                </div>
            </section>

            <!-- PERBAIKAN: Template tersembunyi untuk ekspor, menggunakan opacity dan z-index agar lebih andal -->
            <!-- Container khusus untuk export (ukuran story 9:16) -->
            <div
                ref="storyExportContainer"
                class="fixed top-0 left-0 w-[450px] h-[800px] bg-gradient-to-b from-white via-pink-100 to-pink-200 z-[-10] opacity-0 overflow-hidden"
            >
                <div class="flex items-center justify-center w-full h-full p-6">
                    <!-- Card -->
                    <div
                        class="bg-white p-8 rounded-2xl shadow-xl text-center w-full flex flex-col"
                    >
                        <div class="flex-grow">
                            <p class="text-gray-500 text-lg">Pesan untuk</p>
                            <h2
                                class="text-2xl md:text-4xl font-bold text-pink-500 my-2 break-words"
                            >
                                {{ menfessStore.currentMenfess.to }}
                            </h2>
                            <p
                                class="text-sm md:text-2xl text-gray-700 my-8 leading-relaxed break-words"
                            >
                                “{{ menfessStore.currentMenfess.message }}”
                            </p>
                            <p
                                class="text-md md:text-xl text-gray-500 font-semibold break-words"
                            >
                                — {{ menfessStore.currentMenfess.from }}
                            </p>
                            <p class="text-sm text-gray-400 mt-4">
                                {{
                                    formatDate(
                                        menfessStore.currentMenfess.created_at
                                    )
                                }}
                            </p>
                        </div>
                        <div class="mt-10 pt-6 border-t border-gray-200">
                            <h1
                                class="font-comic text-4xl text-pink-500 font-bold drop-shadow-md"
                            >
                                GAMAFESS
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menampilkan pesan jika data tidak ditemukan setelah loading selesai -->
        <div v-else class="text-center mt-12">
            <p>Maaf, menfess tidak ditemukan atau terjadi kesalahan.</p>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from "vue";
import { useRoute } from "vue-router";
import { useMenfessStore } from "@/Stores/menfessStore";
import { toPng, toBlob } from "html-to-image";

const route = useRoute();
const menfessStore = useMenfessStore();
const storyExportContainer = ref(null);

// Fungsi untuk membuat gambar dari elemen HTML
const generateImage = async (outputType = "png") => {
    if (!storyExportContainer.value) return null;
    const node = storyExportContainer.value;

    // sementara tampilkan
    node.style.opacity = "1";
    node.style.zIndex = "9999";

    await new Promise((r) => setTimeout(r, 200)); // biar render dulu

    try {
        const options = {
            quality: 1.0,
            pixelRatio: 2,
            backgroundColor: "#fce7f3", // fallback pink
        };
        const result =
            outputType === "blob"
                ? await toBlob(node, options)
                : await toPng(node, options);

        return result;
    } catch (err) {
        console.error("Gagal membuat gambar:", err);
        return null;
    } finally {
        // sembunyikan lagi
        node.style.opacity = "0";
        node.style.zIndex = "-10";
    }
};

// Fungsi untuk mengunduh gambar (untuk desktop atau fallback)
const downloadAsImage = async () => {
    const dataUrl = await generateImage("png");
    if (!dataUrl) {
        alert("Maaf, terjadi kesalahan saat mencoba membuat gambar.");
        return;
    }

    const link = document.createElement("a");
    const fileName = `story-gamafess-untuk-${menfessStore.currentMenfess.to.replace(
        /\s/g,
        "-"
    )}.png`;

    link.href = dataUrl;
    link.download = fileName;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
};

// Fungsi baru untuk berbagi ke Story (khusus mobile)
const shareToStory = async () => {
    const blob = await generateImage("blob");
    if (!blob) {
        alert(
            "Maaf, terjadi kesalahan saat mencoba membuat gambar untuk dibagikan."
        );
        return;
    }

    const fileName = `story-gamafess-untuk-${menfessStore.currentMenfess.to.replace(
        /\s/g,
        "-"
    )}.png`;
    const file = new File([blob], fileName, { type: "image/png" });

    if (navigator.canShare && navigator.canShare({ files: [file] })) {
        try {
            await navigator.share({
                files: [file],
                title: `Menfess untuk ${menfessStore.currentMenfess.to}`,
                text: "Lihat menfess ini!",
            });
        } catch (error) {
            console.error("Gagal berbagi:", error);
        }
    } else {
        alert(
            "Fitur berbagi hanya tersedia di HP. Gambar akan diunduh sebagai gantinya."
        );
        downloadAsImage();
    }
};

const formatDate = (dateString) => {
    if (!dateString) return "";
    const options = {
        year: "numeric",
        month: "long",
        day: "numeric",
    };
    return new Date(dateString).toLocaleDateString("id-ID", options);
};

watch(
    () => route.params.id,
    (newId) => {
        if (newId) {
            window.scrollTo(0, 0);
            menfessStore.fetchMenfessDetail(newId);
        }
    },
    { immediate: true }
);
</script>

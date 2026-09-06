<template>
    <div class="p-4 sm:p-8 mt-5">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm p-6">
                <div class="flex flex-wrap justify-start items-center gap-10">
                    <button
                        @click="goBack"
                        class="hidden sm:inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 hover:bg-gray-100 transition mb-2 cursor-grab"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-3 w-3 mr-2"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"
                            />
                        </svg>
                        Kembali
                    </button>
                    <h2 class="text-xl font-bold text-gray-800">QR Absensi</h2>
                </div>
                <div
                    class="p-4 pt-10 mt-1 rounded-lg bg-gray-50 flex flex-col items-center justify-center"
                >
                    <p class="text-gray-600 mb-4">
                        Pindai kode QR ini untuk absensi
                    </p>
                    <div ref="qrRef" class="mb-4 bg-white p-4 rounded-lg">
                        <QrcodeVue
                            :value="qrValue"
                            :size="qrSize"
                            level="H"
                            ref="qrCodeComponent"
                        />
                    </div>

                    <p
                        class="mb-4 text-lg font-semibold tracking-widest font-mono"
                    >
                        {{ authStore.user?.nim }}
                    </p>
                    <button
                        @click="downloadPdf"
                        class="px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 cursor-grab text-white mb-2"
                    >
                        Download PDF
                    </button>
                </div>
            </div>

            <div
                class="lg:col-span-1 bg-gradient-to-br from-yellow-100 to-yellow-200 rounded-2xl shadow-sm p-6"
            >
                <h2 class="text-xl font-bold text-gray-800 mb-4">
                    Rekap Kehadiran Anda
                </h2>

                <div
                    v-if="absenStore.isLoading"
                    class="space-y-4 animate-pulse"
                >
                    <div
                        v-for="n in 3"
                        :key="n"
                        class="flex justify-between items-center bg-white/60 p-4 rounded-lg"
                    >
                        <SkeletonLoader customClass="h-4 w-1/4" />
                        <SkeletonLoader customClass="h-6 w-1/3 rounded-full" />
                    </div>
                </div>

                <div v-else class="space-y-4">
                    <div
                        v-for="absen in absenStore.rekapAbsensi"
                        :key="absen.hari"
                        class="bg-white/60 p-4 rounded-lg flex justify-between items-center"
                    >
                        <span class="font-medium text-gray-700">{{
                            absen.hari
                        }}</span>
                        <span
                            :class="getStatusClass(absen.status)"
                            class="text-sm font-semibold px-3 py-1 rounded-full"
                        >
                            {{ absen.status }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed, nextTick, onBeforeUnmount } from "vue";
import { useRouter } from "vue-router";
import QrcodeVue from "qrcode.vue";
import jsPDF from "jspdf";
import { useAuthStore } from "@/Stores/authStore";
import { useAbsenStore } from "@/Stores/absenStore";

// Stores
const authStore = useAuthStore();
const absenStore = useAbsenStore();
const router = useRouter();
const goBack = () => {
    router.back();
};

// Refs
const qrRef = ref(null);
const qrCodeComponent = ref(null);

// Responsif: ganti ukuran QR sesuai lebar layar
const windowWidth = ref(window.innerWidth);
const handleResize = () => (windowWidth.value = window.innerWidth);
onMounted(() => window.addEventListener("resize", handleResize));
onBeforeUnmount(() => window.removeEventListener("resize", handleResize));

// 300 di layar >= md (768px), 200 di bawah itu
const qrSize = computed(() => (windowWidth.value >= 768 ? 300 : 200));

// Computed QR value
const qrValue = computed(() => authStore.user?.nim || "");

// On mount
onMounted(() => {
    absenStore.fetchAbsensi();
});

// Fungsi download PDF
const downloadPdf = async () => {
    try {
        await nextTick(); // Pastikan QR sudah render
        const canvas = qrRef.value.querySelector("canvas");
        if (!canvas) {
            alert("QR belum siap untuk diunduh.");
            return;
        }

        const imgData = canvas.toDataURL("image/png");
        const pdf = new jsPDF({
            orientation: "portrait",
            unit: "mm",
            format: "a4",
        });

        // Hitung posisi agar QR center di halaman
        const pageWidth = pdf.internal.pageSize.getWidth();
        const qrSize = 180; // ukuran QR di PDF (mm)
        const x = (pageWidth - qrSize) / 2;

        pdf.text("QR Absensi", pageWidth / 2, 20, { align: "center" });
        pdf.addImage(imgData, "PNG", x, 40, qrSize, qrSize);
        pdf.save(`QR_Absensi_${authStore.user?.nim || "MABA"}.pdf`);
    } catch (error) {
        console.error("Error generating PDF:", error);
        alert("Gagal membuat PDF. Silakan coba lagi.");
    }
};

// Fungsi untuk menentukan kelas CSS berdasarkan status absensi
const getStatusClass = (status) => {
    switch (status) {
        case "Hadir":
            return "bg-green-100 text-green-800";
        case "Izin":
            return "bg-blue-100 text-blue-800";
        case "Alpa":
            return "bg-red-100 text-red-800";
        default:
            return "bg-gray-200 text-gray-800";
    }
};
</script>

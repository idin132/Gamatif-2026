import { defineStore } from "pinia";
import { ref } from "vue";
import api from "@/axios"; // Instance Axios kustom

export const useAbsenStore = defineStore("absen", () => {
    // --- STATE ---
    const rekapAbsensi = ref([]);
    const isLoading = ref(false);
    const errors = ref({});

    // --- ACTIONS ---
    const fetchAbsensi = async () => {
        isLoading.value = true;
        errors.value = {};
        try {
            const response = await api.get("/absensi");
            rekapAbsensi.value = response.data;
        } catch (error) {
            console.error("Error fetching absensi:", error);
            errors.value = { general: ["Gagal mengambil data absensi."] };
        } finally {
            isLoading.value = false;
        }
    };

    const clearErrors = () => {
        errors.value = {};
    };

    return {
        rekapAbsensi,
        isLoading,
        errors,
        fetchAbsensi,
        clearErrors,
    };
});

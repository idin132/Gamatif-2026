import { defineStore } from "pinia";
import { ref } from "vue";
import api from "@/axios";

export const useSosialMediaStore = defineStore("sosialMedia", () => {
    const sosialMedia = ref([]);
    const isLoading = ref(false);
    const error = ref(null);

    const fetchSosialMedia = async () => {
        isLoading.value = true;
        error.value = null;

        try {
            const response = await api.get("/sosial-media");
            sosialMedia.value = response.data.payload;
        } catch (err) {
            console.error("Error fetching sosial media:", err);
            error.value = "Gagal mengambil data sosial media";
        } finally {
            isLoading.value = false;
        }
    };

    return {
        sosialMedia,
        isLoading,
        error,
        fetchSosialMedia,
    };
});

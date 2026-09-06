import { defineStore } from "pinia";
import { ref } from "vue";
import api from "@/axios";

export const usePengaturanWebStore = defineStore("pengaturanWeb", () => {
    const pengaturanWeb = ref([]);
    const isLoading = ref(false);
    const error = ref(null);

    const fetchPengaturanWeb = async () => {
        isLoading.value = true;
        error.value = null;

        try {
            const response = await api.get("/pengaturan-web");
            pengaturanWeb.value = response.data.payload; // ⬅️ fix disini
        } catch (err) {
            console.error("Error fetching pengaturan web:", err);
            error.value = "Gagal mengambil data pengaturan web";
        } finally {
            isLoading.value = false;
        }
    };

    return {
        pengaturanWeb,
        isLoading,
        error,
        fetchPengaturanWeb,
    };
});

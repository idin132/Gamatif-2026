import { defineStore } from "pinia";
import { ref } from "vue";
import api from "@/axios";

export const useKritikSaranStore = defineStore("kritikSaran", () => {
    const isLoading = ref(false);
    const error = ref(null);

    const submitKritikSaran = async (data) => {
        isLoading.value = true;
        error.value = null;

        try {
            await api.post("/kritik-saran", data);
            return { success: true };
        } catch (err) {
            console.error("Error submitting kritik saran:", err);
            error.value = "Gagal mengirim kritik dan saran";
            return { success: false, error: error.value };
        } finally {
            isLoading.value = false;
        }
    };

    return {
        isLoading,
        error,
        submitKritikSaran,
    };
});

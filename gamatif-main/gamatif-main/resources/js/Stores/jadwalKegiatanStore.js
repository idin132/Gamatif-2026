import { defineStore } from "pinia";
import { ref } from "vue";
import api from "@/axios";

export const useJadwalKegiatanStore = defineStore("jadwalKegiatan", () => {
    const jadwalKegiatan = ref([]);
    const isLoading = ref(false);
    const error = ref(null);

    const fetchJadwalKegiatan = async () => {
        isLoading.value = true;
        error.value = null;

        try {
            const response = await api.get("/jadwal-kegiatan");
            jadwalKegiatan.value = response.data.payload;
        } catch (err) {
            console.error("Error fetching jadwal kegiatan:", err);
            error.value = "Gagal mengambil data jadwal kegiatan";
        } finally {
            isLoading.value = false;
        }
    };

    return {
        jadwalKegiatan,
        isLoading,
        error,
        fetchJadwalKegiatan,
    };
});

import { defineStore } from "pinia";
import { ref } from "vue";
import api from "@/axios";

export const useMenfessStore = defineStore('menfess', () => {
    const menfesses = ref([]);
    const currentMenfess = ref(null);
    const loading = ref(false);
    const error = ref(null);

    const fetchMenfesses = async () => {
        loading.value = true;
        error.value = null;
        try {
            const response = await api.get('/menfess');
            menfesses.value = response.data.payload.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
        } catch (err) {
            error.value = err.message;
        } finally {
            loading.value = false;
        }
    };

    const createMenfess = async (data) => {
        loading.value = true;
        error.value = null;
        try {
            const response = await api.post('/menfess', data);
            return response.data;
        } catch (err) {
            error.value = err.message;
            throw err;
        } finally {
            loading.value = false;
        }
    };

    const fetchMenfessDetail = async (id) => {
        loading.value = true;
        error.value = null;
        try {
            const response = await api.get(`/menfess/${id}`);
            currentMenfess.value = response.data.payload;
        } catch (err) {
            error.value = err.message;
        } finally {
            loading.value = false;
        }
    };

    return {
        menfesses,
        currentMenfess,
        loading,
        error,
        fetchMenfesses,
        createMenfess,
        fetchMenfessDetail
    };
});

import { defineStore } from "pinia";
import { ref, computed } from "vue";
import api from "@/axios"; // Instance Axios kustom

export const useAuthStore = defineStore("auth", () => {
    // --- STATE ---
    const user = ref(null);
    const token = ref(localStorage.getItem("authToken") || null);
    const errors = ref({});
    const kelompok = ref(null);
    const isLoading = ref(false);
    const successMessage = ref("");
    const autoLoginAttempted = ref(false); // Track auto-login attempts

    const clearErrors = () => {
        errors.value = {};
    };

    // --- GETTERS ---
    const isAuthenticated = computed(() => !!token.value && !!user.value);

    // PENTING: Function untuk set/clear axios headers
    const initializeAxios = () => {
        if (token.value) {
            api.defaults.headers.common[
                "Authorization"
            ] = `Bearer ${token.value}`;
            // console.log(
            //     "✅ Axios header set:",
            //     `Bearer ${token.value.substring(0, 20)}...`
            // );
        } else {
            delete api.defaults.headers.common["Authorization"];
            // console.log("🗑️ Axios header cleared");
        }
    };

    // Initialize axios saat store pertama kali dibuat
    initializeAxios();

    // --- REGISTER ---
    const register = async (formData) => {
        isLoading.value = true;
        errors.value = {};
        successMessage.value = "";

        try {
            const response = await api.post("/register", formData);
            successMessage.value = response.data.message;
            return true;
        } catch (error) {
            if (error.response?.status === 422) {
                errors.value = error.response.data.payload;
            } else {
                console.error("Registration Error:", error);
                errors.value = { general: ["Terjadi kesalahan pada server."] };
            }
            return false;
        } finally {
            isLoading.value = false;
        }
    };

    // --- LOGIN ---
    const login = async (credentials) => {
        isLoading.value = true;
        errors.value = {};
        try {
            const response = await api.post("/login", credentials);
            const responseToken = response.data.payload.token;
            const responseUser = response.data.payload.user;

            token.value = responseToken;
            user.value = responseUser;

            localStorage.setItem("authToken", responseToken);

            // Set axios header menggunakan function
            initializeAxios();

            autoLoginAttempted.value = true; // Mark as attempted
            return true;
        } catch (error) {
            console.error("Login Error:", error);
            if (error.response?.status === 422) {
                errors.value =
                    error.response.data.payload || error.response.data.errors;
            } else {
                errors.value = { general: ["Login gagal. Silakan coba lagi."] };
            }
            return false;
        } finally {
            isLoading.value = false;
        }
    };

    // --- LOGOUT ---
    const logout = () => {
        user.value = null;
        token.value = null;
        autoLoginAttempted.value = false;
        localStorage.removeItem("authToken");

        // Clear axios header menggunakan function
        initializeAxios();
    };

    // --- AUTO LOGIN ---
    const tryAutoLogin = async () => {
        // Prevent multiple auto-login attempts
        if (autoLoginAttempted.value || !token.value || user.value) {
            return;
        }

        autoLoginAttempted.value = true;

        try {
            // PENTING: Set header sebelum request
            initializeAxios();

            // console.log(
            //     "🔄 Mencoba auto login dengan token:",
            //     token.value?.substring(0, 20) + "..."
            // );

            const response = await api.get("/me");

            // Akses struktur response yang benar
            if (response.data?.payload?.user) {
                user.value = response.data.payload.user;
                // console.log("✅ Auto login berhasil:", user.value.nama_lengkap);
            } else {
                console.error(
                    "❌ Unexpected response structure:",
                    response.data
                );
                logout();
            }
        } catch (error) {
            console.error("❌ Auto login gagal:", error);

            // Handle different error types
            if (error.response) {
                const status = error.response.status;
                if (status === 401 || status === 403) {
                    console.log("🚫 Token tidak valid, melakukan logout...");
                    // logout();
                } else if (status === 500) {
                    console.error(
                        "🔥 Server error saat auto login:",
                        error.response.data
                    );
                    // Don't logout on server errors, might be temporary
                }
            } else {
                console.error(
                    "🌐 Network error during auto login:",
                    error.message
                );
            }
        }
    };

    // --- UPDATE PROFILE ---
    const updateProfile = async (formData) => {
        isLoading.value = true;
        errors.value = {};
        try {
            const response = await api.put("/profile", formData);
            user.value = response.data.user; // update state user
            successMessage.value = "Profil berhasil diperbarui";
            return true;
        } catch (error) {
            if (error.response?.status === 422) {
                errors.value = error.response.data.errors;
            } else {
                console.error("Update Profile Error:", error);
                errors.value = { general: ["Gagal memperbarui profil."] };
            }
            return false;
        } finally {
            isLoading.value = false;
        }
    };

    // --- UPDATE PASSWORD ---
    const updatePassword = async (payload) => {
        isLoading.value = true;
        errors.value = {};
        try {
            await api.put("/profile/password", payload);
            successMessage.value = "Password berhasil diubah";
            return true;
        } catch (error) {
            if (error.response?.status === 422) {
                errors.value = error.response.data.errors;
            } else if (error.response?.status === 400) {
                errors.value = { general: [error.response.data.message] };
            } else {
                console.error("Update Password Error:", error);
                errors.value = { general: ["Gagal mengubah password."] };
            }
            return false;
        } finally {
            isLoading.value = false;
        }
    };

    const getKelompokStatus = async () => {
        if (!isAuthenticated.value) return;
        isLoading.value = true;
        try {
            const response = await api.get("/kelompok/status");
            kelompok.value = response.data.payload;
            if (user.value) user.value.kelompok = response.data.payload;
        } catch (error) {
            if (error.response && error.response.status === 404) {
                kelompok.value = null; // Pengguna belum punya kelompok
                if (user.value) user.value.kelompok = null;
            } else {
                console.error("Gagal mengambil status kelompok:", error);
            }
        } finally {
            isLoading.value = false;
        }
    };

    const generateKelompok = async () => {
        isLoading.value = true;
        errors.value = {};
        try {
            const response = await api.post("/kelompok/generate");
            kelompok.value = response.data.payload; // Update state dengan kelompok baru
            if (user.value) user.value.kelompok = response.data.payload;
            return true;
        } catch (error) {
            console.error("Gagal generate kelompok:", error);
            if (error.response && error.response.data.message) {
                alert(error.response.data.message);
            }
            return false;
        } finally {
            isLoading.value = false;
        }
    };

    return {
        user,
        token,
        kelompok,
        errors,
        isLoading,
        successMessage,
        isAuthenticated,
        autoLoginAttempted,
        register,
        login,
        logout,
        clearErrors,
        tryAutoLogin,
        updateProfile,
        updatePassword,
        getKelompokStatus,
        generateKelompok,
        initializeAxios, // Expose for debugging
    };
});

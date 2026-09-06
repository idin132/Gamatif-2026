import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "../Stores/authStore";

import LandingPage from "../Pages/Public/LandingPage.vue";
import RegisterPage from "../Pages/Auth/Register.vue";
import LoginPage from "../Pages/Auth/Login.vue";
import DashboardMabaPage from "../Pages/Profile/DashboardMaba.vue";
import ProfilePage from "../Pages/Profile/DetailProfile.vue";
import AmbilKelompokPage from "../Pages/Profile/AmbilKelompok.vue";
import AbsenMaba from "../Pages/Profile/AbsenMaba.vue";
import MenfessPage from "../Pages/Public/MenfessPage.vue";
import DetailMenfessPage from "../Pages/Public/DetailMenfessPage.vue";
import CreateMenfessPage from "../Pages/Public/CreateMenfessPage.vue";

const routes = [
    {
        path: "/", // Path URL di browser
        name: "landing", // Nama rute (opsional, tapi praktik yang baik)
        component: LandingPage, // Komponen Vue yang akan ditampilkan
    },
    {
        path: "/registrasi-maba",
        name: "registrasi",
        component: RegisterPage,
        meta: { requiresGuest: true },
    },

    {
        path: "/login-maba",
        name: "login",
        component: LoginPage,
        meta: { requiresGuest: true },
    },

    {
        path: "/dashboard-maba",
        name: "dashboard",
        component: DashboardMabaPage,
        meta: { requiresAuth: true },
    },
    {
        path: "/profile-maba",
        name: "profile",
        component: ProfilePage,
        meta: { requiresAuth: true },
    },
    {
        path: "/ambil-kelompok",
        name: "ambil_kelompok",
        component: AmbilKelompokPage,
        meta: { requiresAuth: true },
    },
    {
        path: "/absen-maba",
        name: "absen-maba",
        component: AbsenMaba,
        meta: { requiresAuth: true },
    },
    {
        path: "/buat-menfess",
        name: "buat_menfess",
        component: CreateMenfessPage,
    },
    {
        path: "/menfess",
        name: "menfess",
        component: MenfessPage,
    },
    {
        path: "/detail-menfess/:id",
        name: "detail_menfess",
        component: DetailMenfessPage,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    const authStore = useAuthStore();

    const isAuthenticated = authStore.isAuthenticated;
    const requiresAuth = to.meta.requiresAuth;
    const requiresGuest = to.meta.requiresGuest;

    if (requiresAuth && !isAuthenticated) {
        // Jika rute butuh login, TAPI pengguna belum login -> alihkan ke halaman login.
        next({ name: "login" });
    } else if (requiresGuest && isAuthenticated) {
        // Jika rute hanya untuk tamu, TAPI pengguna sudah login -> alihkan ke dashboard.
        next({ name: "dashboard" });
    } else {
        // Jika tidak ada kondisi di atas yang terpenuhi, lanjutkan navigasi.
        next();
    }
});
export default router;

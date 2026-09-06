import "flowbite";
import "../css/app.css";
import { createApp } from "vue";
import { createPinia } from "pinia";
import router from "./Router/index";
import { useAuthStore } from "../js/Stores/authStore";
import App from "./App.vue";

async function initializeApp() {
    const app = createApp(App);
    const pinia = createPinia();
    app.use(pinia);

    const authStore = useAuthStore();
    await authStore.tryAutoLogin(); // <-- ini penting

    app.use(router);
    app.mount("#app");
}
initializeApp();

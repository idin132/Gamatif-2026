<template>
    <div
        id="kontak"
        class="relative pt-16 sm:pt-24 mt-30 bg-gray-900 rounded-t-full"
    >
        <div class="max-w-2xl mx-auto px-4 pt-20 text-center z-10 relative">
            <h2
                class="text-3xl font-extrabold tracking-tight sm:text-4xl text-white"
            >
                Tinggalkan Kesan & Pesan
            </h2>
            <p class="mt-4 text-lg text-gray-400">
                Bagikan kesan atau pesan pertamamu sebagai bagian dari keluarga
                besar Teknik Informatika!
            </p>

            <form @submit.prevent="handleSubmit" class="mt-8 space-y-6">
                <div class="flex items-center gap-4">
                    <div class="flex-grow">
                        <label for="nama" class="sr-only">Nama</label>
                        <input
                            v-model="form.nama"
                            :disabled="isAnonymous"
                            type="text"
                            name="nama"
                            id="nama"
                            required
                            class="block w-full px-4 py-3 rounded-md bg-white border-gray-600 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-yellow-500 transition"
                            :class="{
                                'bg-gray-800 cursor-not-allowed': isAnonymous,
                            }"
                            placeholder="Nama Lengkap"
                        />
                    </div>
                    <div class="flex items-center flex-shrink-0">
                        <input
                            id="checked-checkbox"
                            type="checkbox"
                            v-model="isAnonymous"
                            class="w-4 h-4 text-yellow-600 rounded focus:ring-yellow-600 ring-offset-gray-800 focus:ring-2"
                        />
                        <label
                            for="checked-checkbox"
                            class="ms-2 text-sm font-medium text-gray-300"
                            >Anonim</label
                        >
                    </div>
                </div>

                <div>
                    <label for="pesan" class="sr-only">Kesan & Pesan</label>
                    <textarea
                        v-model="form.pesan"
                        name="pesan"
                        id="pesan"
                        rows="4"
                        required
                        class="block w-full px-4 py-3 rounded-md bg-white border-gray-300 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-yellow-500"
                        placeholder="Tulis kesan & pesanmu di sini..."
                    ></textarea>
                </div>

                <div>
                    <button
                        type="submit"
                        :disabled="kritikSaranStore.isLoading"
                        class="w-full inline-flex items-center justify-center px-6 py-3 text-base font-medium text-center text-white bg-yellow-600 rounded-lg hover:bg-yellow-700 focus:ring-4 focus:ring-yellow-300 dark:focus:ring-yellow-900 transition disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        {{
                            kritikSaranStore.isLoading
                                ? "Mengirim..."
                                : "Kirim Pesan"
                        }}
                    </button>
                </div>
            </form>
        </div>
        <div
            class="absolute left-1/5 bottom-200 sm:left-1/4 sm:bottom-160 z-2 opacity-80"
        >
            <img
                class="h-50"
                src="../../../public/images/kontak-pesawat.png"
                alt=""
                loading="lazy"
            />
        </div>
        <footer class="mt-30">
            <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8 px-8">
                <div class="md:flex md:justify-between">
                    <div class="mb-6 flex md:mb-0">
                        <div
                            v-if="isPengaturanLoading"
                            class="flex items-center gap-3"
                        >
                            <SkeletonLoader
                                customClass="h-12 w-12 rounded-full"
                            />
                            <SkeletonLoader
                                customClass="h-12 w-12 rounded-full"
                            />
                            <SkeletonLoader
                                customClass="h-12 w-12 rounded-full"
                            />
                        </div>
                        <div v-else class="mb-6 flex md:mb-0">
                            <img
                                :src="logoUnikomUrl"
                                class="h-15 me-3"
                                alt="Logo UNIKOM"
                                loading="lazy"
                            />

                            <a
                                href="https://hmif.unikom.my.id/"
                                target="_blank"
                                class="cursor-pointer"
                            >
                                <img
                                    :src="logoHMIFtUrl"
                                    class="h-15 me-3"
                                    alt="Logo HMIF"
                                    loading="lazy"
                            /></a>

                            <img
                                :src="logoKabinetUrl"
                                class="h-15 me-3"
                                alt="Logo Kabinet"
                                loading="lazy"
                            />
                        </div>
                    </div>

                    <!-- <div class="grid grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-2">
                        <div>
                            <h2
                                class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white"
                            >
                                Sosial Media
                            </h2>
                            <ul
                                class="text-gray-500 dark:text-gray-400 font-medium"
                            >
                                <li class="mb-4">
                                    <a
                                        href="https://github.com/themesberg/flowbite"
                                        class="hover:underline"
                                        >Github</a
                                    >
                                </li>
                                <li>
                                    <a
                                        href="https://discord.gg/4eeurUVvTy"
                                        class="hover:underline"
                                        >Discord</a
                                    >
                                </li>
                            </ul>
                        </div>
                        <div>
                            <h2
                                class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white"
                            >
                                Website Kami
                            </h2>
                            <ul
                                class="text-gray-500 dark:text-gray-400 font-medium"
                            >
                                <li class="mb-4">
                                    <a
                                        href="https://github.com/themesberg/flowbite"
                                        class="hover:underline"
                                        >Github</a
                                    >
                                </li>
                                <li>
                                    <a
                                        href="https://discord.gg/4eeurUVvTy"
                                        class="hover:underline"
                                        >Discord</a
                                    >
                                </li>
                            </ul>
                        </div>
                    </div> -->
                </div>
                <hr
                    class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8"
                />
                <div class="sm:flex sm:items-center sm:justify-between">
                    <span
                        class="text-sm text-gray-500 sm:text-center dark:text-gray-400"
                        >© 2025
                        <a href="https://flowbite.com/" class="hover:underline"
                            >HMIF | Dakshawira</a
                        >. All Rights Reserved.
                    </span>
                    <!-- <div class="flex mt-4 sm:justify-center sm:mt-0">
                        <a
                            href="#"
                            class="text-gray-500 hover:text-gray-900 dark:hover:text-white"
                        >
                            <svg
                                class="w-4 h-4"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor"
                                viewBox="0 0 8 19"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M6.135 3H8V0H6.135a4.147 4.147 0 0 0-4.142 4.142V6H0v3h2v9.938h3V9h2.021l.592-3H5V3.591A.6.6 0 0 1 5.592 3h.543Z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            <span class="sr-only">Facebook page</span>
                        </a>
                        <a
                            href="#"
                            class="text-gray-500 hover:text-gray-900 dark:hover:text-white ms-5"
                        >
                            <svg
                                class="w-4 h-4"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor"
                                viewBox="0 0 21 16"
                            >
                                <path
                                    d="M16.942 1.556a16.3 16.3 0 0 0-4.126-1.3 12.04 12.04 0 0 0-.529 1.1 15.175 15.175 0 0 0-4.573 0 11.585 11.585 0 0 0-.535-1.1 16.274 16.274 0 0 0-4.129 1.3A17.392 17.392 0 0 0 .182 13.218a15.785 15.785 0 0 0 4.963 2.521c.41-.564.773-1.16 1.084-1.785a10.63 10.63 0 0 1-1.706-.83c.143-.106.283-.217.418-.33a11.664 11.664 0 0 0 10.118 0c.137.113.277.224.418.33-.544.328-1.116.606-1.71.832a12.52 12.52 0 0 0 1.084 1.785 16.46 16.46 0 0 0 5.064-2.595 17.286 17.286 0 0 0-2.973-11.59ZM6.678 10.813a1.941 1.941 0 0 1-1.8-2.045 1.93 1.93 0 0 1 1.8-2.047 1.919 1.919 0 0 1 1.8 2.047 1.93 1.93 0 0 1-1.8 2.045Zm6.644 0a1.94 1.94 0 0 1-1.8-2.045 1.93 1.93 0 0 1 1.8-2.047 1.918 1.918 0 0 1 1.8 2.047 1.93 1.93 0 0 1-1.8 2.045Z"
                                />
                            </svg>
                            <span class="sr-only">Discord community</span>
                        </a>
                        <a
                            href="#"
                            class="text-gray-500 hover:text-gray-900 dark:hover:text-white ms-5"
                        >
                            <svg
                                class="w-4 h-4"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor"
                                viewBox="0 0 20 17"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M20 1.892a8.178 8.178 0 0 1-2.355.635 4.074 4.074 0 0 0 1.8-2.235 8.344 8.344 0 0 1-2.605.98A4.13 4.13 0 0 0 13.85 0a4.068 4.068 0 0 0-4.1 4.038 4 4 0 0 0 .105.919A11.705 11.705 0 0 1 1.4.734a4.006 4.006 0 0 0 1.268 5.392 4.165 4.165 0 0 1-1.859-.5v.05A4.057 4.057 0 0 0 4.1 9.635a4.19 4.19 0 0 1-1.856.07 4.108 4.108 0 0 0 3.831 2.807A8.36 8.36 0 0 1 0 14.184 11.732 11.732 0 0 0 6.291 16 11.502 11.502 0 0 0 17.964 4.5c0-.177 0-.35-.012-.523A8.143 8.143 0 0 0 20 1.892Z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            <span class="sr-only">Twitter page</span>
                        </a>
                        <a
                            href="#"
                            class="text-gray-500 hover:text-gray-900 dark:hover:text-white ms-5"
                        >
                            <svg
                                class="w-4 h-4"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M10 .333A9.911 9.911 0 0 0 6.866 19.65c.5.092.678-.215.678-.477 0-.237-.01-1.017-.014-1.845-2.757.6-3.338-1.169-3.338-1.169a2.627 2.627 0 0 0-1.1-1.451c-.9-.615.07-.6.07-.6a2.084 2.084 0 0 1 1.518 1.021 2.11 2.11 0 0 0 2.884.823c.044-.503.268-.973.63-1.325-2.2-.25-4.516-1.1-4.516-4.9A3.832 3.832 0 0 1 4.7 7.068a3.56 3.56 0 0 1 .095-2.623s.832-.266 2.726 1.016a9.409 9.409 0 0 1 4.962 0c1.89-1.282 2.717-1.016 2.717-1.016.366.83.402 1.768.1 2.623a3.827 3.827 0 0 1 1.02 2.659c0 3.807-2.319 4.644-4.525 4.889a2.366 2.366 0 0 1 .673 1.834c0 1.326-.012 2.394-.012 2.72 0 .263.18.572.681.475A9.911 9.911 0 0 0 10 .333Z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            <span class="sr-only">GitHub account</span>
                        </a>
                        <a
                            href="#"
                            class="text-gray-500 hover:text-gray-900 dark:hover:text-white ms-5"
                        >
                            <svg
                                class="w-4 h-4"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M10 0a10 10 0 1 0 10 10A10.009 10.009 0 0 0 10 0Zm6.613 4.614a8.523 8.523 0 0 1 1.93 5.32 20.094 20.094 0 0 0-5.949-.274c-.059-.149-.122-.292-.184-.441a23.879 23.879 0 0 0-.566-1.239 11.41 11.41 0 0 0 4.769-3.366ZM8 1.707a8.821 8.821 0 0 1 2-.238 8.5 8.5 0 0 1 5.664 2.152 9.608 9.608 0 0 1-4.476 3.087A45.758 45.758 0 0 0 8 1.707ZM1.642 8.262a8.57 8.57 0 0 1 4.73-5.981A53.998 53.998 0 0 1 9.54 7.222a32.078 32.078 0 0 1-7.9 1.04h.002Zm2.01 7.46a8.51 8.51 0 0 1-2.2-5.707v-.262a31.64 31.64 0 0 0 8.777-1.219c.243.477.477.964.692 1.449-.114.032-.227.067-.336.1a13.569 13.569 0 0 0-6.942 5.636l.009.003ZM10 18.556a8.508 8.508 0 0 1-5.243-1.8 11.717 11.717 0 0 1 6.7-5.332.509.509 0 0 1 .055-.02 35.65 35.65 0 0 1 1.819 6.476 8.476 8.476 0 0 1-3.331.676Zm4.772-1.462A37.232 37.232 0 0 0 13.113 11a12.513 12.513 0 0 1 5.321.364 8.56 8.56 0 0 1-3.66 5.73h-.002Z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            <span class="sr-only">Dribbble account</span>
                        </a>
                    </div> -->
                </div>
            </div>
        </footer>
    </div>
</template>

<script setup>
import { ref, watch, onMounted, computed } from "vue";
import { useKritikSaranStore } from "@/Stores/kritikSaranStore";
import { storeToRefs } from "pinia";
import { usePengaturanWebStore } from "@/Stores/pengaturanWebStore";
import SkeletonLoader from "@/Components/SkeletonLoader.vue";

// Store form pesan
const form = ref({ nama: "", pesan: "" });
const isAnonymous = ref(true);

// Store kritik saran
const kritikSaranStore = useKritikSaranStore();

// Watcher untuk toggle anonim
watch(
    isAnonymous,
    (newValue) => {
        form.value.nama = newValue ? "Anonim" : "";
    },
    { immediate: true }
);

// Kirim pesan
const handleSubmit = async () => {
    const result = await kritikSaranStore.submitKritikSaran(form.value);
    if (result.success) {
        const displayName =
            form.value.nama === "Anonim" ? "Pengirim Anonim" : form.value.nama;
        alert(`Terima kasih, ${displayName}! Pesanmu sudah kami terima.`);
        form.value.pesan = "";
        if (!isAnonymous.value) form.value.nama = "";
    } else {
        alert(result.error);
    }
};

// ==============================
// AMBIL LOGO DARI API
// ==============================
const pengaturanWebStore = usePengaturanWebStore();
const { pengaturanWeb, isLoading: isPengaturanLoading } =
    storeToRefs(pengaturanWebStore);

onMounted(() => {
    pengaturanWebStore.fetchPengaturanWeb();
});

const baseURL = window.location.origin;
const logoUnikomUrl = computed(() => {
    if (!pengaturanWeb.value.length) return "/images/logo-unikom.png";
    return `${baseURL}/storage/${pengaturanWeb.value[0].logo_unikom}`;
});

const logoHMIFtUrl = computed(() => {
    if (!pengaturanWeb.value.length) return "/images/logo-hmif.png";
    return `${baseURL}/storage/${pengaturanWeb.value[0].logo_hmif}`;
});

const logoKabinetUrl = computed(() => {
    if (!pengaturanWeb.value.length) return "/images/logo-kabinet.png";
    return `${baseURL}/storage/${pengaturanWeb.value[0].logo_kabinet}`;
});
</script>

<template>
    <div
        v-if="show"
        @click="closeModal"
        class="fixed inset-0 bg-black bg-opacity-50 z-40 flex items-center justify-center transition-opacity duration-300"
        :class="show ? 'opacity-100' : 'opacity-0'"
    >
        <div
            @click.stop
            class="bg-white rounded-lg shadow-xl p-8 m-4 max-w-sm w-full text-center transform transition-all duration-300"
            :class="show ? 'scale-100' : 'scale-95'"
        >
            <div
                class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4"
            >
                <slot name="icon">
                    <svg
                        class="h-10 w-10 text-green-600"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M5 13l4 4L19 7"
                        />
                    </svg>
                </slot>
            </div>

            <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ title }}</h3>

            <p class="text-gray-600 mb-6">{{ description }}</p>

            <button
                @click="closeModal"
                class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 rounded-lg shadow-md transition"
            >
                Tutup
            </button>
        </div>
    </div>
</template>

<script setup>
import { useRouter } from "vue-router"; // 1. Impor useRouter

const router = useRouter(); // 2. Buat instance router

const props = defineProps({
    show: {
        type: Boolean,
        required: true,
    },
    title: {
        type: String,
        default: "Sukses!",
    },
    description: {
        type: String,
        default: "Aksi Anda berhasil dilaksanakan.",
    },
    // 3. Tambahkan prop 'to' yang bersifat opsional
    to: {
        type: String,
        default: null,
    },
});

const emit = defineEmits(["close"]);

// 4. Perbarui fungsi closeModal dengan logika redirect
const closeModal = () => {
    if (props.to) {
        // Jika prop 'to' ada, arahkan ke rute tersebut
        router.push(props.to);
    } else {
        // Jika tidak, jalankan event 'close' seperti biasa
        emit("close");
    }
};
</script>

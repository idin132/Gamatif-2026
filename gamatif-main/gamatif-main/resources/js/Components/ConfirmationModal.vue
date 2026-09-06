<!-- ConfirmationModal.vue -->
<template>
    <!-- Modal Backdrop -->
    <Teleport to="body">
        <Transition name="modal">
            <div
                v-if="show"
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
                @click.self="$emit('cancel')"
            >
                <!-- Modal Content -->
                <div
                    class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 transform transition-all"
                    @click.stop
                >
                    <!-- Modal Header -->
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center"
                            >
                                <svg
                                    class="w-6 h-6 text-yellow-600"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"
                                    />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">
                                {{ title }}
                            </h3>
                        </div>
                    </div>

                    <!-- Modal Body -->
                    <div class="p-6">
                        <p class="text-gray-600 leading-relaxed">
                            {{ message }}
                        </p>
                    </div>

                    <!-- Modal Footer -->
                    <div
                        class="p-6 border-t border-gray-200 flex gap-3 justify-end"
                    >
                        <button
                            type="button"
                            @click="$emit('cancel')"
                            :disabled="isLoading"
                            class="px-4 py-2 text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium transition disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            {{ cancelText }}
                        </button>
                        <button
                            type="button"
                            @click="$emit('confirm')"
                            :disabled="isLoading"
                            class="px-6 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg font-medium transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2"
                        >
                            <!-- Loading Spinner -->
                            <svg
                                v-if="isLoading"
                                class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <circle
                                    class="opacity-25"
                                    cx="12"
                                    cy="12"
                                    r="10"
                                    stroke="currentColor"
                                    stroke-width="4"
                                ></circle>
                                <path
                                    class="opacity-75"
                                    fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                ></path>
                            </svg>
                            {{ isLoading ? loadingText : confirmText }}
                        </button>
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>

<script setup>
// Props
defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    title: {
        type: String,
        default: "Konfirmasi",
    },
    message: {
        type: String,
        default: "Apakah Anda yakin ingin melanjutkan?",
    },
    confirmText: {
        type: String,
        default: "Yakin",
    },
    cancelText: {
        type: String,
        default: "Batal",
    },
    loadingText: {
        type: String,
        default: "Memproses...",
    },
    isLoading: {
        type: Boolean,
        default: false,
    },
});

// Events
defineEmits(["confirm", "cancel"]);
</script>

<style scoped>
/* Modal Transition */
.modal-enter-active,
.modal-leave-active {
    transition: opacity 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
    opacity: 0;
}

.modal-enter-active .bg-white,
.modal-leave-active .bg-white {
    transition: all 0.3s ease;
}

.modal-enter-from .bg-white,
.modal-leave-to .bg-white {
    transform: scale(0.9) translateY(-10px);
    opacity: 0;
}
</style>

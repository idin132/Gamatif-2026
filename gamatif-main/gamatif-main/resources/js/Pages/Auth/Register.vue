<template>
    <div class="min-h-screen bg-gray-100 py-12 px-4">
        <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg p-8">
            <h1 class="text-3xl font-bold text-center mb-8 text-gray-800">
                Form Registrasi Mahasiswa Baru
            </h1>

            <div
                v-if="successMessage"
                class="mb-4 p-4 bg-green-100 text-green-800 border border-green-300 rounded-lg"
            >
                {{ successMessage }}
            </div>

            <div
                v-if="errors.general"
                class="mb-4 p-4 bg-red-100 text-red-800 border border-red-300 rounded-lg"
            >
                {{ errors.general[0] }}
            </div>

            <!-- Validation Errors (Frontend) -->
            <div
                v-if="validationErrors.length > 0"
                class="mb-4 p-4 bg-red-100 text-red-800 border border-red-300 rounded-lg"
            >
                <h4 class="font-semibold mb-2">Harap lengkapi data berikut:</h4>
                <ul class="list-disc list-inside space-y-1">
                    <li v-for="error in validationErrors" :key="error">{{ error }}</li>
                </ul>
            </div>

            <form class="space-y-6">
                <div>
                    <label
                        for="nama_lengkap"
                        class="block text-sm font-medium text-gray-700"
                        >Nama Lengkap</label
                    >
                    <input
                        v-model="form.nama_lengkap"
                        type="text"
                        id="nama_lengkap"
                        placeholder="Nama Lengkap"
                        class="mt-1 block w-full rounded-lg border px-4 py-2 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                        :class="
                            errors.nama_lengkap || hasValidationError('nama_lengkap')
                                ? 'border-red-500'
                                : 'border-gray-300'
                        "
                    />
                    <p
                        v-if="errors.nama_lengkap"
                        class="text-red-500 text-xs mt-1"
                    >
                        {{ errors.nama_lengkap[0] }}
                    </p>
                </div>

                <div>
                    <label
                        for="nim"
                        class="block text-sm font-medium text-gray-700"
                        >NIM</label
                    >
                    <input
                        v-model="form.nim"
                        @input="
                            form.nim = $event.target.value.replace(/\D/g, '')
                        "
                        type="text"
                        id="nim"
                        placeholder="Nomor Induk Mahasiswa"
                        class="mt-1 block w-full rounded-lg border px-4 py-2 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                        :class="
                            errors.nim || hasValidationError('nim')
                                ? 'border-red-500' 
                                : 'border-gray-300'
                        "
                    />
                    <p v-if="errors.nim" class="text-red-500 text-xs mt-1">
                        {{ errors.nim[0] }}
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700"
                        >Jenis Kelamin</label
                    >
                    <div class="mt-2 flex gap-6">
                        <label class="flex items-center gap-2">
                            <input
                                v-model="form.jenis_kelamin"
                                type="radio"
                                name="jenis_kelamin"
                                value="L"
                                class="text-yellow-500 focus:ring-yellow-400"
                            />
                            <span class="text-gray-700">Laki-laki</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input
                                v-model="form.jenis_kelamin"
                                type="radio"
                                name="jenis_kelamin"
                                value="P"
                                class="text-yellow-500 focus:ring-yellow-400"
                            />
                            <span class="text-gray-700">Perempuan</span>
                        </label>
                    </div>
                    <p
                        v-if="errors.jenis_kelamin"
                        class="text-red-500 text-xs mt-1"
                    >
                        {{ errors.jenis_kelamin[0] }}
                    </p>
                </div>

                <div>
                    <label
                        for="tanggal_lahir"
                        class="block text-sm font-medium text-gray-700"
                        >Tanggal Lahir</label
                    >
                    <input
                        v-model="form.tanggal_lahir"
                        type="date"
                        id="tanggal_lahir"
                        class="mt-1 block w-full rounded-lg border px-4 py-2 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                        :class="
                            errors.tanggal_lahir || hasValidationError('tanggal_lahir')
                                ? 'border-red-500'
                                : 'border-gray-300'
                        "
                    />
                    <p
                        v-if="errors.tanggal_lahir"
                        class="text-red-500 text-xs mt-1"
                    >
                        {{ errors.tanggal_lahir[0] }}
                    </p>
                </div>

                <div>
                    <label
                        for="alamat"
                        class="block text-sm font-medium text-gray-700"
                        >Alamat</label
                    >
                    <textarea
                        v-model="form.alamat"
                        id="alamat"
                        rows="3"
                        placeholder="cth: Jl. Dipatiukur No. 112, Bandung"
                        class="mt-1 block w-full rounded-lg border px-4 py-2 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                        :class="
                            errors.alamat || hasValidationError('alamat') 
                                ? 'border-red-500' 
                                : 'border-gray-300'
                        "
                    ></textarea>
                    <p v-if="errors.alamat" class="text-red-500 text-xs mt-1">
                        {{ errors.alamat[0] }}
                    </p>
                </div>

                <div>
                    <label
                        for="nomor_whatsapp"
                        class="block text-sm font-medium text-gray-700"
                        >Nomor WhatsApp</label
                    >
                    <input
                        v-model="form.nomor_whatsapp"
                        @input="
                            form.nomor_whatsapp = $event.target.value.replace(
                                /\D/g,
                                ''
                            )
                        "
                        type="text"
                        id="nomor_whatsapp"
                        placeholder="cth: 081234567890"
                        class="mt-1 block w-full rounded-lg border px-4 py-2 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                        :class="
                            errors.nomor_whatsapp || hasValidationError('nomor_whatsapp')
                                ? 'border-red-500'
                                : 'border-gray-300'
                        "
                    />
                    <p
                        v-if="errors.nomor_whatsapp"
                        class="text-red-500 text-xs mt-1"
                    >
                        {{ errors.nomor_whatsapp[0] }}
                    </p>
                </div>

                <div>
                    <label
                        for="email"
                        class="block text-sm font-medium text-gray-700"
                        >Email</label
                    >
                    <input
                        v-model="form.email"
                        type="email"
                        id="email"
                        placeholder="cth: email-aktif-kamu@gmail.com"
                        class="mt-1 block w-full rounded-lg border px-4 py-2 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                        :class="
                            errors.email || hasValidationError('email')
                                ? 'border-red-500' 
                                : 'border-gray-300'
                        "
                    />
                    <p v-if="errors.email" class="text-red-500 text-xs mt-1">
                        {{ errors.email[0] }}
                    </p>
                </div>

                <!-- Menggunakan CustomFileInput untuk bukti registrasi -->
                <CustomFileInput
                    id="bukti_registrasi"
                    label="Bukti Registrasi"
                    v-model="form.bukti_registrasi"
                    :error="
                        errors.bukti_registrasi
                            ? errors.bukti_registrasi[0]
                            : ''
                    "
                    :multiple="false"
                    :class="hasValidationError('bukti_registrasi') ? 'border-red-500' : ''"
                />

                <!-- CustomFileInput untuk bukti sosmed dengan multiple files -->
                <CustomFileInput
                    id="bukti_sosmed"
                    label="Bukti Follow Sosial Media (Minimal 3 File)"
                    v-model="form.bukti_sosmed"
                    :error="errors.bukti_sosmed ? errors.bukti_sosmed[0] : ''"
                    :multiple="true"
                    :class="hasValidationError('bukti_sosmed') ? 'border-red-500' : ''"
                />

                <div class="pt-4">
                    <button
                        type="button"
                        @click="validateAndShowModal"
                        :disabled="isLoading"
                        class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-3 rounded-lg shadow-md transition disabled:bg-gray-400 disabled:cursor-not-allowed"
                    >
                        Registrasi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <SuccessModal
        :show="showSuccessModal"
        title="Registrasi Berhasil!"
        :description="successMessage"
        @close="showSuccessModal = false"
        to="/login-maba"
    />

    <ConfirmationModal
        :show="showConfirmationModal"
        title="Konfirmasi Registrasi"
        message="Data Anda sudah valid dan siap dikirim. Apakah Anda yakin ingin mengirim data registrasi?"
        confirm-text="Ya, Kirim"
        cancel-text="Batal"
        loading-text="Sedang Mengirim..."
        :is-loading="isLoading"
        @confirm="handleSubmit"
        @cancel="showConfirmationModal = false"
    />
</template>

<script setup>
import { ref, computed, nextTick } from "vue";
import { useAuthStore } from "@/Stores/authStore";
import { storeToRefs } from "pinia";
import SuccessModal from "../../Components/SuccessModal.vue";
import CustomFileInput from "../../Components/CustomFileInput.vue";
import ConfirmationModal from "../../Components/ConfirmationModal.vue";

const authStore = useAuthStore();
const { errors, isLoading, successMessage } = storeToRefs(authStore);

const showSuccessModal = ref(false);
const showConfirmationModal = ref(false);
const validationErrors = ref([]);
const validatedFields = ref([]);

const form = ref({
    nama_lengkap: "",
    nim: "",
    jenis_kelamin: "L",
    tanggal_lahir: "",
    alamat: "",
    nomor_whatsapp: "",
    email: "",
    bukti_registrasi: null,
    bukti_sosmed: [],
});

// Definisikan urutan field di form
const fieldOrder = [
    "nama_lengkap",
    "nim", 
    "jenis_kelamin",
    "tanggal_lahir",
    "alamat",
    "nomor_whatsapp",
    "email",
    "bukti_registrasi",
    "bukti_sosmed",
];

// Helper function untuk cek apakah field memiliki validation error
const hasValidationError = (fieldName) => {
    return validatedFields.value.includes(fieldName);
};

// Function untuk validasi file size (2MB = 2097152 bytes)
const validateFileSize = (file) => {
    const maxSize = 2 * 1024 * 1024; // 2MB
    return file.size <= maxSize;
};

// Function untuk validasi email format
const validateEmail = (email) => {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
};

// Function untuk validasi WhatsApp (minimal 10 digit)
const validateWhatsApp = (number) => {
    return number.length >= 10 && number.length <= 15;
};

// Function untuk comprehensive validation
const validateForm = () => {
    const errors = [];
    const errorFields = [];

    // Reset validatedFields
    validatedFields.value = [];

    // Validasi nama lengkap
    if (!form.value.nama_lengkap.trim()) {
        errors.push("Nama lengkap harus diisi");
        errorFields.push("nama_lengkap");
    }

    // Validasi NIM
    if (!form.value.nim.trim()) {
        errors.push("NIM harus diisi");
        errorFields.push("nim");
    } else if (form.value.nim.length < 8) {
        errors.push("NIM minimal 8 digit");
        errorFields.push("nim");
    }

    // Validasi tanggal lahir
    if (!form.value.tanggal_lahir) {
        errors.push("Tanggal lahir harus diisi");
        errorFields.push("tanggal_lahir");
    }

    // Validasi alamat
    if (!form.value.alamat.trim()) {
        errors.push("Alamat harus diisi");
        errorFields.push("alamat");
    }

    // Validasi nomor WhatsApp
    if (!form.value.nomor_whatsapp.trim()) {
        errors.push("Nomor WhatsApp harus diisi");
        errorFields.push("nomor_whatsapp");
    } else if (!validateWhatsApp(form.value.nomor_whatsapp)) {
        errors.push("Nomor WhatsApp tidak valid (10-15 digit)");
        errorFields.push("nomor_whatsapp");
    }

    // Validasi email
    if (!form.value.email.trim()) {
        errors.push("Email harus diisi");
        errorFields.push("email");
    } else if (!validateEmail(form.value.email)) {
        errors.push("Format email tidak valid");
        errorFields.push("email");
    }

    // Validasi bukti registrasi
    if (!form.value.bukti_registrasi) {
        errors.push("Bukti registrasi harus diupload");
        errorFields.push("bukti_registrasi");
    } else if (!validateFileSize(form.value.bukti_registrasi)) {
        errors.push("Ukuran file bukti registrasi maksimal 2MB");
        errorFields.push("bukti_registrasi");
    }

    // Validasi bukti sosmed
    if (form.value.bukti_sosmed.length < 3) {
        errors.push("Minimal 3 file bukti follow sosial media");
        errorFields.push("bukti_sosmed");
    } else {
        // Check individual file sizes
        let hasOversizeFile = false;
        for (const file of form.value.bukti_sosmed) {
            if (!validateFileSize(file)) {
                hasOversizeFile = true;
                break;
            }
        }
        if (hasOversizeFile) {
            errors.push("Setiap file bukti sosmed maksimal 2MB");
            errorFields.push("bukti_sosmed");
        }
    }

    validationErrors.value = errors;
    validatedFields.value = errorFields;
    
    return errors.length === 0;
};

// Function yang dipanggil saat klik tombol Registrasi
const validateAndShowModal = async () => {
    // Clear previous errors
    authStore.clearErrors();
    
    // Validate form
    const isValid = validateForm();
    
    if (!isValid) {
        // Scroll ke error pertama
        await nextTick();
        const firstErrorField = fieldOrder.find((field) => validatedFields.value.includes(field));
        
        if (firstErrorField) {
            const errorElement = document.querySelector(`#${firstErrorField}`);
            if (errorElement) {
                errorElement.scrollIntoView({
                    behavior: "smooth",
                    block: "center",
                });
                errorElement.focus();
            }
        }
        return;
    }

    // Jika semua valid, tampilkan modal konfirmasi
    showConfirmationModal.value = true;
};

// Function untuk handle submit (hanya kirim data yang sudah valid)
const handleSubmit = async () => {
    const formData = new FormData();

    for (const key in form.value) {
        if (key === "bukti_sosmed") {
            form.value.bukti_sosmed.forEach((file) => {
                formData.append("bukti_sosmed[]", file);
            });
        } else if (form.value[key] !== null) {
            formData.append(key, form.value[key]);
        }
    }

    const isSuccess = await authStore.register(formData);

    if (isSuccess) {
        showConfirmationModal.value = false;
        showSuccessModal.value = true;

        // Reset form
        form.value = {
            nama_lengkap: "",
            nim: "",
            jenis_kelamin: "L",
            tanggal_lahir: "",
            alamat: "",
            nomor_whatsapp: "",
            email: "",
            bukti_registrasi: null,
            bukti_sosmed: [],
        };

        // Reset validation
        validationErrors.value = [];
        validatedFields.value = [];
    } else {
        // Tutup modal konfirmasi jika ada error dari server
        showConfirmationModal.value = false;

        // Tunggu DOM selesai diperbarui dengan pesan error dari server
        await nextTick();

        // Scroll ke error pertama dari server
        const firstErrorField = fieldOrder.find((field) => errors.value[field]);
        if (firstErrorField) {
            const errorElement = document.querySelector(`#${firstErrorField}`);
            if (errorElement) {
                errorElement.scrollIntoView({
                    behavior: "smooth",
                    block: "center",
                });
            }
        }
    }
};
</script>
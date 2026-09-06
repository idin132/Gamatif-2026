<template>
  <div class="p-8 mt-14 bg-gray-50 min-h-screen rounded-3xl" v-if="user">
    <h1 class="text-3xl font-bold mb-8 text-gray-800">👤 Profil Saya</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
      <!-- ======================== PROFIL ======================== -->
      <div class="bg-white rounded-2xl shadow p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">📋 Data Diri</h2>

        <form @submit.prevent="updateProfile" class="space-y-4">
          <div>
            <label class="block text-sm text-gray-600 mb-1">Nama Lengkap</label>
            <input v-model="form.nama_lengkap" type="text"
              class="w-full rounded-lg border-gray-300 focus:ring-yellow-400 focus:border-yellow-400" />
          </div>

          <div>
            <label class="block text-sm text-gray-600 mb-1">NIM</label>
            <input v-model="form.nim" type="text"
              class="w-full rounded-lg border-gray-300 focus:ring-yellow-400 focus:border-yellow-400" />
          </div>

          <div>
            <label class="block text-sm text-gray-600 mb-1">Jenis Kelamin</label>
            <select v-model="form.jenis_kelamin" disabled
              class="w-full rounded-lg border-gray-200 bg-gray-100 text-gray-500">
              <option value="L">Laki-laki</option>
              <option value="P">Perempuan</option>
            </select>
          </div>

          <div>
            <label class="block text-sm text-gray-600 mb-1">Tanggal Lahir</label>
            <input v-model="form.tanggal_lahir" type="date"
              class="w-full rounded-lg border-gray-300 focus:ring-yellow-400 focus:border-yellow-400" />
          </div>

          <div>
            <label class="block text-sm text-gray-600 mb-1">Alamat</label>
            <textarea v-model="form.alamat"
              class="w-full rounded-lg border-gray-300 focus:ring-yellow-400 focus:border-yellow-400"></textarea>
          </div>

          <div>
            <label class="block text-sm text-gray-600 mb-1">Nomor WhatsApp</label>
            <input v-model="form.nomor_whatsapp" type="text"
              class="w-full rounded-lg border-gray-300 focus:ring-yellow-400 focus:border-yellow-400" />
          </div>

          <div>
            <label class="block text-sm text-gray-600 mb-1">Email</label>
            <input v-model="form.email" type="email" disabled
              class="w-full rounded-lg border-gray-200 bg-gray-100 text-gray-500" />
          </div>

          <div>
            <label class="block text-sm text-gray-600 mb-1">Status</label>
            <div class="flex items-center gap-2">
              <span class="w-3 h-3 rounded-full"
                :class="form.status === true ? 'bg-green-500' : 'bg-red-500'"></span>
              <span class="text-sm capitalize text-gray-600">{{ form.status === true ? 'Aktif' : 'Belum Aktif' }}</span>
            </div>
          </div>

          <button type="submit"
            class="mt-4 bg-yellow-500 hover:bg-yellow-600 text-white font-medium px-4 py-2 rounded-lg">
            Simpan Profil
          </button>
        </form>
      </div>

      <!-- ======================== GANTI PASSWORD ======================== -->
      <div class="bg-white rounded-2xl shadow p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">🔐 Ganti Password</h2>

        <form @submit.prevent="updatePassword" class="space-y-4">
          <div>
            <label class="block text-sm text-gray-600 mb-1">Password Lama</label>
            <input v-model="password.old" type="password"
              class="w-full rounded-lg border-gray-300 focus:ring-yellow-400 focus:border-yellow-400" />
          </div>

          <div>
            <label class="block text-sm text-gray-600 mb-1">Password Baru</label>
            <label class="block text-xs text-gray-500 mb-1">Harus Kombinasi Huruf dan Angka ya, Contoh : gamatif2025</label>
            <input v-model="password.new" type="password"
              class="w-full rounded-lg border-gray-300 focus:ring-yellow-400 focus:border-yellow-400" />
          </div>

          <div>
            <label class="block text-sm text-gray-600 mb-1">Konfirmasi Password Baru</label>
            <input v-model="password.confirm" type="password"
              class="w-full rounded-lg border-gray-300 focus:ring-yellow-400 focus:border-yellow-400" />
          </div>

          <button type="submit"
            class="mt-4 bg-yellow-500 hover:bg-yellow-600 text-white font-medium px-4 py-2 rounded-lg">
            Ubah Password
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { storeToRefs } from "pinia";
import { useAuthStore } from "@/Stores/authStore";
import api from "@/axios";

const authStore = useAuthStore();
const { user } = storeToRefs(authStore);

const form = ref({
  nama_lengkap: "",
  nim: "",
  jenis_kelamin: "",
  tanggal_lahir: "",
  alamat: "",
  nomor_whatsapp: "",
  email: "",
  status: "",
});

const password = ref({
  old: "",
  new: "",
  confirm: "",
});

// Isi form dari user yang login
onMounted(() => {
  if (user.value) {
    form.value = { ...user.value };
  }
});

// Update profil
const updateProfile = async () => {
  const success = await authStore.updateProfile(form.value);
  if (success) {
    alert("Profil berhasil diperbarui");
  } else {
    alert("Gagal update profil");
  }
};

// Update password
const updatePassword = async () => {
  if (password.value.new !== password.value.confirm) {
    return alert("Konfirmasi password tidak cocok");
  }
  const payload = {
    old_password: password.value.old,
    new_password: password.value.new,
    new_password_confirmation: password.value.confirm
  };
  const success = await authStore.updatePassword(payload);
  if (success) {
    alert("Password berhasil diubah");
    password.value = { old: "", new: "", confirm: "" };
  } else {
    alert("Gagal update password");
  }
};
</script>

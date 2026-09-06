<template>
    <div>
        <label :for="id" class="block text-sm font-medium text-gray-700">{{
            label
        }}</label>
        <span class="text-sm text-gray-500 block">Maksimal 2 MB</span>

        <div class="mt-1">
            <label
                :for="id"
                class="relative flex items-center px-4 py-2 w-full rounded-lg border cursor-pointer transition hover:bg-gray-50"
                :class="[
                    (error || sizeError) ? 'border-red-500 bg-red-50' : 'border-gray-300',
                    isUploaded && !sizeError ? 'border-green-500 bg-green-50' : '',
                ]"
            >
                <span
                    class="bg-yellow-400 text-white font-semibold text-sm px-4 py-2 rounded-md hover:bg-yellow-500 transition flex-shrink-0"
                >
                    Choose File<span v-if="multiple">s</span>
                </span>

                <span
                    class="ml-4 text-sm truncate flex-1"
                    :class="(error || sizeError) ? 'text-red-500' : (isUploaded ? 'text-gray-700' : 'text-gray-500')"
                >
                    {{ sizeError || fileText }}
                </span>

                <input
                    :id="id"
                    :multiple="multiple"
                    @change="handleFileChange"
                    type="file"
                    accept="image/*"
                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                />
            </label>
        </div>

        <!-- Display selected files list for multiple files -->
        <div v-if="multiple && selectedFiles.length > 0" class="mt-2 space-y-1">
            <div
                v-for="(file, index) in selectedFiles"
                :key="index"
                class="flex items-center justify-between text-xs bg-gray-100 px-3 py-1 rounded"
            >
                <span class="truncate">{{ file.name }}</span>
                <button
                    @click="removeFile(index)"
                    class="ml-2 text-red-500 hover:text-red-700 font-semibold"
                >
                    ×
                </button>
            </div>
        </div>

        <p v-if="error" class="text-red-500 text-xs mt-1">{{ error }}</p>
    </div>
</template>

<script setup>
import { ref, computed } from "vue";

const props = defineProps({
    id: String,
    label: String,
    modelValue: [Object, Array, null],
    multiple: {
        type: Boolean,
        default: false,
    },
    error: String,
});

const emit = defineEmits(["update:modelValue"]);

const selectedFiles = ref([]);
const sizeError = ref('');

const fileText = computed(() => {
    if (props.multiple) {
        if (selectedFiles.value.length === 0) return "No files chosen";
        if (selectedFiles.value.length === 1)
            return `${selectedFiles.value[0].name}`;
        return `${selectedFiles.value.length} files selected`;
    } else {
        return selectedFiles.value.length > 0
            ? selectedFiles.value[0].name
            : "No file chosen";
    }
});

const isUploaded = computed(() => selectedFiles.value.length > 0);

const handleFileChange = (event) => {
    const files = event.target.files;
    sizeError.value = '';

    const maxSize = 2 * 1024 * 1024; // 2MB
    let hasError = false;

    for (let i = 0; i < files.length; i++) {
        if (files[i].size > maxSize) {
            hasError = true;
            break;
        }
    }

    if (hasError) {
        sizeError.value = 'upload gagal, tidak bisa upload lebih dari 2mb';
        selectedFiles.value = [];
        emit("update:modelValue", props.multiple ? [] : null);
    } else {
        if (props.multiple) {
            // For multiple files, add new files to existing ones
            const newFiles = Array.from(files);
            selectedFiles.value = [...selectedFiles.value, ...newFiles];
            emit("update:modelValue", selectedFiles.value);
        } else {
            const file = files[0] || null;
            selectedFiles.value = file ? [file] : [];
            emit("update:modelValue", file);
        }
    }

    // Clear the input so the same file can be selected again
    event.target.value = "";
};

const removeFile = (index) => {
    selectedFiles.value.splice(index, 1);
    if (props.multiple) {
        emit("update:modelValue", selectedFiles.value);
    } else {
        emit("update:modelValue", null);
    }
};

// Initialize with existing value if any
if (props.modelValue) {
    if (props.multiple && Array.isArray(props.modelValue)) {
        selectedFiles.value = [...props.modelValue];
    } else if (!props.multiple && props.modelValue) {
        selectedFiles.value = [props.modelValue];
    }
}
</script>

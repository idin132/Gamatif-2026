<x-filament::breadcrumbs :breadcrumbs="[
    '/' => 'Home',
    '/admin/data-mahasiswas' => 'Data Mahasiswas',
]" />

<h1 class="text-2xl font-bold mb-4">Data Mahasiswa</h1>

<div>
    <form wire:submit.prevent="save" class="w-full max-w-sm space-y-4">
        <div>
            <label for="file" class="block text-gray-700 font-bold mb-2">
                Pilih Berkas
            </label>
            <input
                type="file"
                id="file"
                wire:model="file"
                class="w-full py-2 px-3 rounded border border-gray-300"
            >
            @error('file')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <button
            type="submit"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
        >
            Unggah
        </button>
    </form>
</div>


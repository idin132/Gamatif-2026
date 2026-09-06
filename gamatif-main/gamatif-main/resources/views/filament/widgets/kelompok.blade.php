<x-filament-widgets::widget>
    {{-- full width keluar dari container Filament --}}
    <div class="w-screen -mx-6 px-6">

        <h2 class="text-lg font-semibold text-gray-900 mb-4">
            Daftar Kelompok
        </h2>

        {{-- Responsive: 2 cols (xs) / 4 cols (sm) / 8 cols (lg) --}}
        <div class="grid w-full grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-4">
            @foreach ($kelompok as $item)
            <div
                class="p-4 rounded-lg shadow-sm ring-1 ring-gray-200
                           {{ $loop->index % 2 === 0 ? 'bg-white' : 'bg-gray-50' }}">
                <div class="text-sm font-medium text-gray-600 truncate">
                    {{ $item->nama_kelompok }}
                </div>

                <div class="text-2xl font-bold text-gray-900 mt-2">
                    {{ $item->total_maba }}
                </div>

                <div class="mt-3 flex items-center gap-2 text-xs">
                    {{-- L (info / biru) --}}
                    <span class="inline-flex items-center px-2 py-1 rounded-full bg-blue-50 text-blue-700 font-semibold">
                        L: {{ $item->jumlah_laki }}
                    </span>

                    {{-- P (danger / merah) --}}
                    <span class="inline-flex items-center px-2 py-1 rounded-full bg-red-50 text-red-700 font-semibold">
                        P: {{ $item->jumlah_perempuan }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</x-filament-widgets::widget>
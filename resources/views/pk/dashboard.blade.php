<!DOCTYPE html>
<html lang="id" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>PK Portal - {{ $kelompok->nama_kelompok ?? 'House' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        spice: { 400: '#fbbf24', 500: '#f59e0b', 600: '#d97706' },
                        sand: '#121214',
                        sandcard: '#1c1c20',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-sand text-zinc-100 font-sans pb-24 select-none" x-data="{ activeTab: 'bawaan', activeDay: 'day_1' }">

    <!-- Header Mobile Bar -->
    <div
        class="sticky top-0 z-40 bg-sandcard/95 backdrop-blur border-b border-zinc-800 px-4 py-3 flex items-center justify-between shadow-lg">
        <div>
            <span class="text-[10px] font-mono tracking-widest text-spice-400 uppercase font-bold">HOUSE LEADER
                PANEL</span>
            <h1 class="text-lg font-black text-white flex items-center gap-2">
                House {{ $kelompok->nama_kelompok ?? '-' }}
            </h1>
        </div>
        <div class="text-right">
            <span class="text-xs text-zinc-400 block">{{ $user->name }}</span>
            <form action="{{ route('pk.logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="text-[11px] text-rose-400 hover:underline">Logout</button>
            </form>
        </div>
    </div>

    <!-- Alert Flash -->
    <div class="px-4 mt-3">
        @if(session('success'))
            <div class="p-3 rounded-lg bg-emerald-950 border border-emerald-700 text-emerald-300 text-xs">
                {{ session('success') }}
            </div>
        @endif
    </div>

    <!-- Main Tab Content -->
    <main class="px-4 py-3 space-y-4">

        <!-- TAB 1: CHECKLIST BARANG BAWAAN (Touch-Optimized) -->
        <div x-show="activeTab === 'bawaan'" class="space-y-4">

            <!-- Selector Hari (Day 1 / 2 / 3) -->
            <div class="grid grid-cols-3 gap-2 bg-zinc-900 p-1.5 rounded-xl border border-zinc-800">
                <button @click="activeDay = 'day_1'"
                    :class="activeDay === 'day_1' ? 'bg-spice-500 text-black font-bold' : 'text-zinc-400'"
                    class="py-2 text-xs rounded-lg transition text-center">Day 1</button>
                <button @click="activeDay = 'day_2'"
                    :class="activeDay === 'day_2' ? 'bg-spice-500 text-black font-bold' : 'text-zinc-400'"
                    class="py-2 text-xs rounded-lg transition text-center">Day 2</button>
                <button @click="activeDay = 'day_3'"
                    :class="activeDay === 'day_3' ? 'bg-spice-500 text-black font-bold' : 'text-zinc-400'"
                    class="py-2 text-xs rounded-lg transition text-center">Day 3</button>
            </div>

            <!-- Legenda / Daftar Nama Barang Bawaan Dinamis -->
            <div class="bg-zinc-900/90 border border-zinc-800 p-3 rounded-xl text-xs space-y-1">
                <p class="text-[10px] font-bold text-spice-400 uppercase tracking-wider">Keterangan Barang Bawaan:</p>

                <div x-show="activeDay === 'day_1'" class="space-y-0.5 text-zinc-300">
                    @forelse($masterBarang['day_1'] ?? [] as $idx => $nama)
                        <p><span class="font-mono text-spice-400 font-bold">B{{ $idx + 1 }}:</span> {{ $nama }}</p>
                    @empty
                        <p class="text-zinc-500 italic text-[11px]">Belum ada data barang Day 1.</p>
                    @endforelse
                </div>

                <div x-show="activeDay === 'day_2'" class="space-y-0.5 text-zinc-300">
                    @forelse($masterBarang['day_2'] ?? [] as $idx => $nama)
                        <p><span class="font-mono text-spice-400 font-bold">B{{ $idx + 1 }}:</span> {{ $nama }}</p>
                    @empty
                        <p class="text-zinc-500 italic text-[11px]">Belum ada data barang Day 2.</p>
                    @endforelse
                </div>

                <div x-show="activeDay === 'day_3'" class="space-y-0.5 text-zinc-300">
                    @forelse($masterBarang['day_3'] ?? [] as $idx => $nama)
                        <p><span class="font-mono text-spice-400 font-bold">B{{ $idx + 1 }}:</span> {{ $nama }}</p>
                    @empty
                        <p class="text-zinc-500 italic text-[11px]">Belum ada data barang Day 3.</p>
                    @endforelse
                </div>
            </div>

            <p class="text-[11px] text-zinc-400">Tap tombol B1–B5 untuk update status bawa (Hijau = Bawa, Abu-abu =
                Tidak).</p>

            <!-- Card List Mahasiswa & Tombol B1-B5 -->
            <div class="space-y-3">
                @forelse($dataMahasiswas as $row)
                    <div id="card-maba-{{ $row->id }}" class="bg-sandcard border border-zinc-800 p-4 rounded-xl shadow">
                        <div class="flex justify-between items-center mb-3">
                            <div>
                                <h3 class="font-bold text-sm text-zinc-100">{{ $row->nama }}</h3>
                                <span class="text-xs font-mono text-zinc-400">{{ $row->nim }}</span>
                            </div>

                            <!-- Tombol Bawa Semua -->
                            <button type="button" onclick="checkAllBarang({{ $row->id }})"
                                class="px-3 py-1.5 bg-zinc-800 hover:bg-emerald-600 border border-zinc-700 hover:border-emerald-500 text-zinc-300 hover:text-white rounded-lg text-xs font-semibold transition flex items-center gap-1.5 shadow-sm">
                                <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Bawa Semua</span>
                            </button>
                        </div>

                        <!-- Grid Tombol B1 sampai B5 -->
                        <div class="grid grid-cols-5 gap-2">
                            @for($i = 0; $i < 5; $i++)
                                @php
                                    $colDay1 = $barangColumns['day_1'][$i];
                                    $colDay2 = $barangColumns['day_2'][$i];
                                    $colDay3 = $barangColumns['day_3'][$i];
                                @endphp
                                <button type="button"
                                    @click="toggleBarang({{ $row->id }}, activeDay === 'day_1' ? '{{ $colDay1 }}' : (activeDay === 'day_2' ? '{{ $colDay2 }}' : '{{ $colDay3 }}'), $event)"
                                    class="barang-btn h-11 rounded-lg flex flex-col items-center justify-center font-mono font-bold text-xs border transition"
                                    :class="$el.dataset[activeDay] === '1' ? 'bg-emerald-600 border-emerald-400 text-white' : 'bg-zinc-800 border-zinc-700 text-zinc-500'"
                                    data-day_1="{{ $row->$colDay1 }}" data-day_2="{{ $row->$colDay2 }}"
                                    data-day_3="{{ $row->$colDay3 }}">
                                    <span>B{{ $i + 1 }}</span>
                                </button>
                            @endfor
                        </div>
                    </div>
                @empty
                    <p class="text-center text-zinc-500 text-xs py-8">Belum ada maba di kelompok ini.</p>
                @endforelse
            </div>
        </div>

        <!-- TAB 2: ABSENSI KEHADIRAN CEPAT -->
        <div x-show="activeTab === 'absensi'" class="space-y-4">
            <div class="grid grid-cols-3 gap-2 bg-zinc-900 p-1.5 rounded-xl border border-zinc-800">
                <button @click="activeDay = 'day_1'"
                    :class="activeDay === 'day_1' ? 'bg-spice-500 text-black font-bold' : 'text-zinc-400'"
                    class="py-2 text-xs rounded-lg transition text-center">Day 1</button>
                <button @click="activeDay = 'day_2'"
                    :class="activeDay === 'day_2' ? 'bg-spice-500 text-black font-bold' : 'text-zinc-400'"
                    class="py-2 text-xs rounded-lg transition text-center">Day 2</button>
                <button @click="activeDay = 'day_3'"
                    :class="activeDay === 'day_3' ? 'bg-spice-500 text-black font-bold' : 'text-zinc-400'"
                    class="py-2 text-xs rounded-lg transition text-center">Day 3</button>
            </div>

            <div class="space-y-3">
                @forelse($dataMahasiswas as $row)
                    <div class="bg-sandcard border border-zinc-800 p-3.5 rounded-xl flex items-center justify-between">
                        <div>
                            <h4 class="font-bold text-xs text-zinc-200">{{ $row->nama }}</h4>
                            <span class="text-[10px] font-mono text-zinc-400">{{ $row->nim }}</span>
                        </div>

                        <!-- Dropdown Kehadiran -->
                        <select onchange="updateKehadiran({{ $row->id }}, this.value)"
                            class="bg-zinc-900 border border-zinc-700 text-xs rounded-lg px-2.5 py-1.5 text-spice-400 focus:outline-none">
                            <option value="1"
                                :selected="activeDay === 'day_1' ? '{{ $row->day_1 }}' === '1' : activeDay === 'day_2' ? '{{ $row->day_2 }}' === '1' : '{{ $row->day_3 }}' === '1'">
                                Hadir</option>
                            <option value="2"
                                :selected="activeDay === 'day_1' ? '{{ $row->day_1 }}' === '2' : activeDay === 'day_2' ? '{{ $row->day_2 }}' === '2' : '{{ $row->day_3 }}' === '2'">
                                Izin</option>
                            <option value="0"
                                :selected="activeDay === 'day_1' ? '{{ $row->day_1 }}' === '0' : activeDay === 'day_2' ? '{{ $row->day_2 }}' === '0' : '{{ $row->day_3 }}' === '0'">
                                Alfa</option>
                        </select>
                    </div>
                @empty
                    <p class="text-center text-zinc-500 text-xs py-8">Belum ada maba di kelompok ini.</p>
                @endforelse
            </div>
        </div>

        <!-- TAB 3: INPUT SURAT IZIN / SAKIT -->
        <div x-show="activeTab === 'izin'" class="space-y-4">
            <div class="bg-sandcard border border-zinc-800 p-4 rounded-xl">
                <h3 class="font-bold text-sm text-spice-400 mb-3">Input Surat Izin / Sakit</h3>
                <form action="{{ route('pk.store_izin') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-xs text-zinc-400 mb-1">Pilih Mahasiswa</label>
                        <select name="mahasiswa_baru_id" required
                            class="w-full bg-zinc-900 border border-zinc-700 text-xs rounded-lg p-2.5 text-zinc-100">
                            @foreach($mabas as $m)
                                <option value="{{ $m->id }}">{{ $m->nim }} - {{ $m->nama_lengkap }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs text-zinc-400 mb-1">Agenda Kegiatan</label>
                        <select name="jadwal_kegiatan_id" required
                            class="w-full bg-zinc-900 border border-zinc-700 text-xs rounded-lg p-2.5 text-zinc-100">
                            @foreach($jadwals as $j)
                                <option value="{{ $j->id }}">{{ $j->nama }} ({{ $j->tanggal->format('d M') }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-xs text-zinc-400 mb-1">Keterangan</label>
                            <select name="keterangan" required
                                class="w-full bg-zinc-900 border border-zinc-700 text-xs rounded-lg p-2.5 text-zinc-100">
                                <option value="sakit">Sakit</option>
                                <option value="izin">Izin</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs text-zinc-400 mb-1">Foto Surat (Kamera)</label>
                            <input type="file" name="foto" accept="image/*" capture="environment"
                                class="w-full text-xs text-zinc-400 file:py-1 file:px-2 file:rounded file:border-0 file:bg-zinc-800 file:text-spice-400">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs text-zinc-400 mb-1">Catatan / Alasan</label>
                        <textarea name="catatan" rows="2" required
                            class="w-full bg-zinc-900 border border-zinc-700 text-xs rounded-lg p-2.5 text-zinc-100"
                            placeholder="Alasan sakit/izin..."></textarea>
                    </div>

                    <button type="submit" class="w-full bg-spice-500 text-black font-bold py-2.5 rounded-lg text-xs">
                        Simpan Surat Izin
                    </button>
                </form>
            </div>
        </div>

        <!-- TAB 4: LIST ANGGOTA MABA & KONTAK -->
        <div x-show="activeTab === 'maba'" class="space-y-3">
            @forelse($mabas as $maba)
                <div class="bg-sandcard border border-zinc-800 p-3.5 rounded-xl flex items-center justify-between">
                    <div>
                        <h4 class="font-bold text-xs text-zinc-100">{{ $maba->nama_lengkap }}</h4>
                        <p class="text-[10px] font-mono text-zinc-400">{{ $maba->nim }} •
                            {{ $maba->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </p>
                    </div>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $maba->nomor_whatsapp) }}" target="_blank"
                        class="bg-emerald-950 text-emerald-400 border border-emerald-700 px-3 py-1.5 rounded-lg text-xs font-semibold">
                        WhatsApp
                    </a>
                </div>
            @empty
                <p class="text-center text-zinc-500 text-xs py-8">Belum ada maba di kelompok ini.</p>
            @endforelse
        </div>

    </main>

    <!-- Bottom Navigation Bar Mobile -->
    <nav
        class="fixed bottom-0 left-0 right-0 bg-sandcard/95 backdrop-blur border-t border-zinc-800 flex justify-around py-2 z-50">
        <button @click="activeTab = 'bawaan'" :class="activeTab === 'bawaan' ? 'text-spice-400' : 'text-zinc-500'"
            class="flex flex-col items-center text-[10px] gap-1">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <span>Bawaan</span>
        </button>
        <button @click="activeTab = 'absensi'" :class="activeTab === 'absensi' ? 'text-spice-400' : 'text-zinc-500'"
            class="flex flex-col items-center text-[10px] gap-1">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>Absensi</span>
        </button>
        <button @click="activeTab = 'izin'" :class="activeTab === 'izin' ? 'text-spice-400' : 'text-zinc-500'"
            class="flex flex-col items-center text-[10px] gap-1">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span>Izin</span>
        </button>
        <button @click="activeTab = 'maba'" :class="activeTab === 'maba' ? 'text-spice-400' : 'text-zinc-500'"
            class="flex flex-col items-center text-[10px] gap-1">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span>Anggota</span>
        </button>
    </nav>

    <!-- Script AJAX Handler -->
    <script>
        function toggleBarang(id, field, event) {
            const btn = event.currentTarget;
            const currentDay = Alpine.$data(document.querySelector('body')).activeDay;

            fetch("{{ route('pk.toggle_barang') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ id: id, field: field })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        btn.dataset[currentDay] = data.new_value;
                        if (data.new_value === '1' || data.new_value === 1) {
                            btn.classList.remove('bg-zinc-800', 'border-zinc-700', 'text-zinc-500');
                            btn.classList.add('bg-emerald-600', 'border-emerald-400', 'text-white');
                        } else {
                            btn.classList.add('bg-zinc-800', 'border-zinc-700', 'text-zinc-500');
                            btn.classList.remove('bg-emerald-600', 'border-emerald-400', 'text-white');
                        }
                    }
                })
                .catch(err => console.error(err));
        }

        function updateKehadiran(id, status) {
            const currentDay = Alpine.$data(document.querySelector('body')).activeDay;

            fetch("{{ route('pk.update_kehadiran') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    id: id,
                    day: currentDay,
                    status: status
                })
            })
                .then(res => res.json())
                .catch(err => console.error(err));
        }

        function checkAllBarang(id) {
            const currentDay = Alpine.$data(document.querySelector('body')).activeDay;
            const card = document.getElementById(`card-maba-${id}`);

            fetch("{{ route('pk.check_all_barang') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    id: id,
                    day: currentDay
                })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Ubah tampilan semua tombol B1 - B5 pada kartu maba tersebut menjadi hijau
                        const buttons = card.querySelectorAll('.barang-btn');
                        buttons.forEach(btn => {
                            btn.dataset[currentDay] = '1';
                            btn.classList.remove('bg-zinc-800', 'border-zinc-700', 'text-zinc-500');
                            btn.classList.add('bg-emerald-600', 'border-emerald-400', 'text-white');
                        });
                    }
                })
                .catch(err => console.error(err));
        }
    </script>
</body>

</html>